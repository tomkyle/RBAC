<?php
/**
 * This file is part of tomkyle/rbac.
 *
 * Copyright (c) 2014 Carsten Witt
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace tomkyle\Permissions;


/**
 * ApplyPermissionsStorage
 *
 * Finds the permissions that are granted to the given client:
 *
 * - Rights he is granted because of the roles he is associated with
 * - Rights he is granted or prohibited because of a user-based allocation
 *
 * The permissions are stored in a PermissionsStorage and applied to the client.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
class ApplyPermissionsStorage
{

    /**
     * @param PermissionsAwareInterface   $client
     * @param PDO                    $pdo PDO Database connection
     * @param PermissionsStorageInterface $permissions_storage Optional: Predefined PermissionsStorage
     *
     * @throws RuntimeException If in PDO::ERRMODE_SILENT and error occured in PDO execution
     */
    public function __construct(PermissionsAwareInterface $client, \PDO $pdo, PermissionsStorageInterface $permissions_storage = null)
    {
        $permissions_storage = $permissions_storage ?: new PermissionsStorage;

        $sql = 'SELECT
        final.permission_id,
        final.permission_name,
        IF(SUM(final.hasPermission)>=1, 1, 0) AS hasPermission
        FROM
        (
            (
                SELECT
                R.id as permission_id,
                R.permission_name,
                IF(SUM(counter)>=1, 1, 0) AS hasPermission
                FROM tomkyle_permissions R
                LEFT JOIN
                (
                    SELECT
                    RUG.*,
                    1 AS counter
                    FROM tomkyle_permissions_roles_mm RUG,
                         tomkyle_clients_roles_mm  UUG
                    WHERE UUG.role_id = RUG.role_id
                    AND UUG.client_id = :client_id
                ) RUG
                ON R.id = RUG.permission_id
                GROUP BY R.id
            )

            UNION
            (
                SELECT
                R.id,
                R.permission_name,
                URA.permission_adjust AS hasPermission
                FROM tomkyle_permissions R,
                     tomkyle_clients_permissions_adjust URA
                WHERE   R.id = URA.permission_id
                AND     URA.client_id = :client_id
            )
        ) AS final
        GROUP BY final.permission_id';

        // PDO magic
        $stmt = $pdo->prepare( $sql );
        $stmt->execute([
          'client_id' => $client->getId()
        ]);

        // Catch errors, throw RuntimeException.
        if( $stmt->errorCode() != 0 ) {
            $errors = $stmt->errorInfo();
            throw new \RuntimeException( "SQLSTATE[{$errors[0]}]: {$errors[2]}" );
        }

        // Configure PermissionsStorage
        while ( $right = $stmt->fetch( \PDO::FETCH_OBJ ) ) {
            $permissions_storage->offsetSet($right->permission_name, $right->hasPermission);
        }


        // Apply to given client
        $client->setPermissions( $permissions_storage );

    }
}

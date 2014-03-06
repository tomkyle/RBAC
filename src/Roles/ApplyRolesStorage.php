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
namespace tomkyle\Roles;



/**
 * ApplyRolesStorage
 *
 * Finds the Roles the given client is assigned to
 * and applies an according RolesStorage to the client.
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
class ApplyRolesStorage
{

    /**
     * @param RolesAwareInterface   $client        Client that can have roles.
     * @param PDO                   $pdo           Database connection
     * @param RolesStorageInterface $roles_storage Optional: Predefined RolesStorage
     *
     * @throws RuntimeException If in PDO::ERRMODE_SILENT and error occured in PDO execution
     */
    public function __construct(RolesAwareInterface $client, \PDO $pdo, RolesStorageInterface $roles_storage = null)
    {
        $roles_storage = $roles_storage ?: new RolesStorage;

        $sql = 'SELECT
        UG.id
        -- , UG.role_short_name
        -- , UG.role_display_name

        FROM
        tomkyle_roles UG
        LEFT JOIN
        tomkyle_clients_roles_mm UGmm
        ON    UG.id        = UGmm.role_id
        AND   UGmm.client_id = :client_id
        WHERE UGmm.client_id = :client_id';

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

        // Retrieve client's Roles
        // and append found role IDs to RolesStorage
        while ($role_id = $stmt->fetch( \PDO::FETCH_COLUMN )) {
            $roles_storage->append( $role_id );
        }

        // Apply to client
        $client->setRoles( $roles_storage );
    }

}

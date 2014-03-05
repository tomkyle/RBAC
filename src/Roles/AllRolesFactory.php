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
 * AllRolesFactory
 *
 * Creates an ArrayObject containing all Roles defined in the database.
 *
 * Usage:
 *
 *     <?php
 *     $factory   = new AllRolesFactory;
 *     $all_roles = $factory->getRolesArrayObject();
 *     ?>
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
class AllRolesFactory
{

    /**
     * @var \ArrayObject
     */
    public $roles = [];

    /**
     * Stores all Roles defined in an ArrayObject, using $roles member.
     *
     * A preset array may be passed, overriding the
     * role defaults defined in $roles.
     *
     * @param PDO   $pdo   PDO Connection
     * @param array $roles Optional: Role Presets
     */
    public function __construct( \PDO $pdo, $roles = array())
    {
        // Prepare target
        $this->roles = new \ArrayObject( array_merge($this->roles, $roles ));

        // Database magic
        $sql = 'SELECT
        id
        -- , role_short_name
        , role_display_name
        FROM tomkyle_roles
        WHERE 1';

        $stmt = $pdo->prepare( $sql );
        $bool = $stmt->execute();

        // Retrieve client's Roles
        // and configure Roles ArrayObject
        while ($role = $stmt->fetch( \PDO::FETCH_OBJ )) {
            $this->roles->offsetSet($role->id, $role->role_display_name);
        }
    }

    /**
     * Returns all Roles as ArrayObject.
     *
     * @return \ArrayObject
     * @uses   $roles
     */
    public function getRolesArrayObject()
    {
        return $this->roles;
    }
}

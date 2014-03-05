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
 * PermissionsAwareInterface
 *
 * Methods that any Permissions-aware client must provide.
 * For implementation, check out the trait PermissionsAwareTrait.
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
interface PermissionsAwareInterface
{

    /**
     * Sets the PermissionsStorage that contains the permissions the client has.
     *
     * @param  \tomkyle\Permissions\PermissionsStorageInterface $permissions
     * @return object                                 Fluent Interface
     */
    public function setPermissions( PermissionsStorageInterface $permissions );

    /**
     * Returns the permissions a client has as PermissionsStorage.
     *
     * @return \tomkyle\Permissions\PermissionsStorageInterface
     */
    public function getPermissions();

    /**
     * Checks if the client has a certain permission,
     * i.e. if the client is allowed to do an action that requires the given permission.
     *
     * @param  string $permission
     * @return bool
     */
    public function hasPermission( $permission );


    /**
     * Returns the permission-aware clients' ID
     * identifying him when reading from database.
     *
     * Trait PermissionsAwareTrait does not implement this.
     *
     * @return int
     */
    public function getId();


    /**
     * BC alias for `hasPermission`
     * @todo Remove in a later release.
     */
    public function hasRight( $right );

}

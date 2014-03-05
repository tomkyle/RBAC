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
 * Convenience, convenience:
 *
 * This trait does more than half of the work PermissionsAwareInterface
 * prescribes its implementing clients.
 *
 * It implements:
 * - setPermissions
 * - getPermissions
 * - hasPermission
 *
 * It does NOT implement:
 * - getId
 *
 * @author Carsten Witt <tomkyle@posteo.de>
 */
trait PermissionsAwareTrait
{

    /**
     * @var \tomkyle\Permissions\PermissionsStorage
     */
    public $permissions;

    /**
     * Sets the PermissionsStorage that contains the permissions the client has.
     *
     * @param  \tomkyle\Permissions\PermissionsStorageInterface $permissions
     * @return PermissionsAwareInterface Fluent Interface
     *
     * @uses   $permissions
     * @uses   ArrayExpected
     */
    public function setPermissions(PermissionsStorageInterface $permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Returns an instance of PermissionsStorageInterface
     * If none is set, a blank PermissionsStorage will be set and returned.
     *
     * @return \tomkyle\Permissions\PermissionsStorage
     * @uses   $permissions
     * @uses   setPermissions()
     * @uses   \tomkyle\Permissions\PermissionsStorage
     */
    public function getPermissions()
    {
        if ($this->permissions instanceOf PermissionsStorageInterface) {
            return $this->permissions;
        }
        elseif ( is_array($this->permissions) ) {
            $this->setPermissions( new PermissionsStorage($this->permissions) );
        }
        else {
            $this->setPermissions( new PermissionsStorage );
        }
        return $this->permissions;
    }

    /**
     * Checks if the client has a certain permission,
     * i.e. if the client is allowed to do an action that requires the given permission.
     *
     * @param  string $permission_name
     * @return bool
     * @uses   getPermissions()
     */
    public function hasPermission($permission_name)
    {
        return $this->getPermissions()->contains( $permission_name );
    }

    /**
     * BC alias for `hasPermission`
     * @todo Remove in a later release.
     */
    public function hasRight($right_name)
    {
        return $this->hasPermission( $right_name );
    }
}

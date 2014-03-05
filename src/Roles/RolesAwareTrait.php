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
 * RolesAwareTrait
 *
 * This convenience implementation does more than half of the work
 * RolesAwareInterface prescribes its implementing clients.
 *
 * It implements:
 * - setRoles
 * - getRoles
 *
 * It does NOT implement:
 * - getId
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
trait RolesAwareTrait
{


    /**
     * Holds the roles storage.
     *
     * Implementing subclasses may use this array
     * to programmatically define roles in class definition.
     *
     * @var RolesStorageInterface
     */
    protected $roles = array();


    /**
     * Sets the RolesStorage that contains the roles the client
     * is assigned to.
     *
     * @param  RolesStorageInterface RoleStorage Instance
     * @return RolesAwareInterface Fluent interface
     * @uses   $roles
     */
    public function setRoles(RolesStorageInterface $roles)
    {
        $this->roles = $roles;
        return $this;
    }


    /**
     * Returns an instance of RolesStorageInterface
     * containing all roles the client is assigned to.
     *
     * Id none is defined, an (empty) RolesStorage
     * will be set, configured with the roles refined
     * in `$roles` member array.
     *
     * @return RolesStorageInterface
     * @uses   $roles
     */
    public function getRoles()
    {
        if ($this->roles instanceOf RolesStorageInterface) {
            return $this->roles;
        }
        $this->setRoles( new RolesStorage( $this->roles ) );
        return $this->roles;
    }

}

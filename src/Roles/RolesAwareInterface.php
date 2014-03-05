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
 * RolesAwareInterface
 *
 * Defines methods that any role client must provide.
 *
 * For implementation, check out the trait RolesAwareTrait.
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
interface RolesAwareInterface
{

    /**
     * Sets the RolesStorage that contains the roles the client
     * is assigned to.
     *
     * For implementation, check out the trait RolesAwareTrait.
     *
     * @param  RolesStorageInterface RoleStorage Instance
     * @return RolesAwareInterface Fluent interface
     */
    public function setRoles ( RolesStorageInterface $roles );

    /**
     * Returns an instance of RolesStorageInterface
     * containing all roles the client is assigned to.
     *
     * For implementation, check out the trait RolesAwareTrait.
     *
     * @return RolesStorageInterface
     */
    public function getRoles ();

    /**
     * Returns the role clients' ID
     * identifying him when reading from database.
     *
     * Trait RolesAwareTrait does not implement this.
     *
     * @return int Role Client ID
     */
    public function getId();

}

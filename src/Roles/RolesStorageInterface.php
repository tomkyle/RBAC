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
 * RolesStorageInterface
 *
 * Defines methods every RolesStorage objects must provide.
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
interface RolesStorageInterface
{

    /**
     * Checks if the given RolesStorage has any intersections
     * with this RolesStorage, i.e. if the user has one of the roles
     * stored in this object.
     *
     * @param  RolesStorageInterface $client Role Client
     * @return bool
     */
    public function intersect(RolesStorageInterface $client);


    /**
     * Checks if the given Role ID exists in the RolesStorage ArrayObject,
     * i.e. if the client is assigned to this role.
     *
     * @param  int  $id Role ID
     * @return bool
     */
    public function contains( $id );

}

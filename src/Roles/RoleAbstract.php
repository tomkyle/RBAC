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
 * RoleAbstract
 *
 * Implements the interceptors defined in RoleInterface.
 *
 * @author  Carsten Witt <tomkyle@posteo.de>
 */
abstract class RoleAbstract implements RoleInterface
{

    public $id;
    public $display_name;
    public $short_name;

    /**
     * Sets the role ID.
     *
     * @param  int          $id
     * @return RoleAbstract Fluent Interface
     *
     * @uses   $id
     * @throws InvalidArgumentException If parameter is not integer-like.
     */
    public function setId($id)
    {
        // blacklist
        if (!(is_string($id) and filter_var($id, \FILTER_VALIDATE_INT) !== false)
        and !is_int($id)) {
            throw new \InvalidArgumentException( "Integer ID expected." );
        }

        $this->id = (int) trim($id);

        return $this;
    }

    /**
     * Returns the Role ID.
     *
     * @return int
     * @uses   $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the Role's display name.
     *
     * @param  string       $display_name
     * @return RoleAbstract Fluent Interface
     *
     * @uses   $display_name
     *
     * @throws InvalidArgumentException If parameter is not a string.
     */
    public function setDisplayName($display_name)
    {
        if (is_string( $display_name )) {
            $this->display_name = $display_name;

            return $this;
        }
        throw new \InvalidArgumentException( "String expected");
    }


    /**
     * Returns the Role's display name.
     *
     * @return string
     * @uses   $display_name
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Sets the Role's short name.
     *
     * @param  string       $short_name
     * @return RoleAbstract Fluent Interface
     *
     * @uses  $short_name
     *
     * @throws InvalidArgumentException If parameter is not a string.
     */
    public function setShortName($short_name)
    {
        if (is_string( $short_name )) {
            $this->short_name = $short_name;

            return $this;
        }
        throw new \InvalidArgumentException( "String expected");
    }


    /**
     * Returns the Role's short name.
     *
     * @return string
     * @uses   $short_name
     */
    public function getShortName()
    {
        return $this->short_name;
    }

}

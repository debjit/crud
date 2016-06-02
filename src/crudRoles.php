<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD;

/**
 * Class crudRoles.
 */
trait crudRoles
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        /* @var \Illuminate\Database\Eloquent\Model $this */
        return $this->belongsToMany(Models\Role::class);
    }

    /**
     * @param string|Models\Role $role
     *
     * @return mixed
     */
    public function hasRole($role)
    {
        /* @var \Illuminate\Database\Eloquent\Model $this */
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $role->intersect($this->roles);
    }

    /**
     * @param string|Models\Role $role
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assignRole($role)
    {
        /* @var \App\User $this */
        if (is_string($role)) {
            return $this->roles()->save(
                Models\Role::where(['name' => $role])->firstOrFail()
            );
        }

        return $this->roles()->save($role);
    }

    /**
     * @param string|Models\Permission $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        /** @var \App\User $this */
        if ($this->roles->contains('root', 1)) {
            return true;
        }

        $retVal = false;

        if (is_string($permission)) {
            foreach ($this->roles as $role) {
                /** @var Models\Role $role */
                if ($role->permissions->contains('name', $permission)) {
                    $retVal = true;
                }
            }
        } elseif (is_object($permission)) {
            foreach ($this->roles as $role) {
                /** @var Models\Role $role */

                /* TODO: revisit this for a more proper way */
                if ($role->permissions->contains('name', $permission->name)) {
                    $retVal = true;
                }
            }
        }


        return $retVal;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        /* @var \App\User $this */
        return $this->roles->contains('root', 1);
    }
}

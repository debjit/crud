<?php

namespace BlackfyreStudio\CRUD;

trait crudRoles
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Models\Role::class);
    }

    /**
     * @param string|Models\Role $role
     * @return mixed
     */
    public function hasRole($role)
    {

        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $role->intersect($this->roles);
    }

    /**
     * @param string|Models\Role $role
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assignRole($role)
    {

        if (is_string($role)) {
            return $this->roles()->save(
                Models\Role::whereName($role)->firstOrFail()
            );
        }

        return $this->roles()->save($role);
    }

    /**
     * @param string|Models\Permission $permission
     * @return bool
     */
    public function hasPermission($permission)
    {

        if ($this->roles->contains('root', 1)) {
            return true;
        }

        $retVal = false;

        if (is_string($permission)) {

            foreach ($this->roles as $role) {
                /** @var Models\Role $role */

                if ($role->permissions->contains('name',$permission)) {
                    $retVal = true;
                }
            }


        } elseif (is_object($permission)) {

            foreach ($this->roles as $role) {
                /** @var Models\Role $role */

                /* TODO: revisit this for a more proper way */
                if ($role->permissions->contains('name',$permission->name)) {
                    $retVal = true;
                }
            }
        }


        return $retVal;
    }

    /**
     * @return boolean
     */
    public function isRoot() {
        return $this->roles->contains('root', 1);
    }

}
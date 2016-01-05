<?php

namespace BlackfyreStudio\CRUD;


trait crudRoles
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->belongsToMany(Models\Role::class);
    }


    /**
     * @param string|Models\Role $role
     * @return mixed
     */
    public function hasRole($role)
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
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
        /** @var \App\User $this */
        if (is_string($role)) {
            return $this->roles()->save(
                Models\Role::where(['name'=>$role])->firstOrFail()
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
        /** @var \App\User $this */

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
        /** @var \App\User $this */
        return $this->roles->contains('root', 1);
    }

}
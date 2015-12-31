<?php

namespace BlackfyreStudio\CRUD;

trait crudRoles {
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|Role $role
     * @return mixed
     */
    public function hasRole($role) {

        if (is_string($role)) {
            return $this->roles->contains('name',$role);
        }

        return $role->intersect($this->roles);
    }

    /**
     * @param string|Role $role
     */
    public function assignRole($role) {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }
}
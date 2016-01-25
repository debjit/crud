<?php
/**
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@gmail.com>
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

namespace BlackfyreStudio\CRUD\Console;

use BlackfyreStudio\CRUD\Models\Permission;
use BlackfyreStudio\CRUD\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class CreatePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:permission
                            {name : The name of the model to create permissions for}
                            {--only=CRUD : Create permissions to Create, Read, Update or Delete, use the initials}
                            {--assign= : Assign created permissions to a role, by role ID}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user role for this instance';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $permissions = [
            'C' => 'Create',
            'R' => 'Read',
            'U' => 'Update',
            'D' => 'Delete'
        ];

        $requests = str_split(strtoupper($this->option('only')));

        foreach ($requests as $permissionTo) {
            $permission = new Permission();
            $permission->name = $this->argument('name') . '.' . strtolower($permissions[$permissionTo]);
            $permission->label = $permissions[strtoupper($permissionTo)] . ' ' . $this->argument('name');
            $permission->save();

            if (!is_null($this->option('assign'))) {
                if (is_numeric($this->option('assign'))) {

                    try {

                        /** @var Role $role */
                        $role = Role::findOrFail($this->option('assign'));
                        $role->givePermission($permission);

                    } catch (QueryException $e) {
                        $this->error('Role not found!');
                    }


                } else {
                    $this->error('The supplied role id is not a number!');
                }
            }

        }
    }
}
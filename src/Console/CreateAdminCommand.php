<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>
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

use App\User;
use BlackfyreStudio\CRUD\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CreateAdminCommand
 * @package BlackfyreStudio\CRUD\Console
 */
class CreateAdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user for this instance';

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


        $user = new User();

        $user->email = $this->argument('email');
        $raw = '';

        if (is_null($this->option('password'))) {
            $password = substr(sha1(time() . $this->argument('email')), 0, 9);
            $raw = $password;
        } else {
            $password = $this->option('password');
        }

        $user->password = bcrypt($password);

        if (!is_null($this->option('name'))) {
            $user->name = $this->option('name');
        }

        try {
            $user->save();
            /* Assign as admin */
            $this->info('The generated password is ' . $raw);

        } catch (QueryException $e) {
            $this->error("Failed to create user, possible reasons: table doesn't exists yet, or there is another user with the supplied email address");
        }

        $user = User::where('email', $this->argument('email'))->firstOrFail();

        try {
            $role = Role::where('root', true)->firstOrFail();
            $user->assignRole($role);
            $this->info('User assigned to: ' . $role->name . ' role');
        } catch (ModelNotFoundException $e) {
            $this->error('Administrator role not found');
            $role = new Role();
            $role->name = 'Admin';
            $role->label = 'Administrators';
            $role->root = true;
            $role->save();
            $this->info('Role ' . $role->name . ' created with root access level');
            $user->assignRole($role);
            $this->info('User assigned to: ' . $role->name . ' role');
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['email', InputArgument::REQUIRED, 'The email address of the admin user'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['name', null, InputOption::VALUE_OPTIONAL, 'The name of the user', null],
            ['password', null, InputOption::VALUE_OPTIONAL, 'The password for the user', null]
        ];
    }
}
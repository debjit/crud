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
namespace BlackfyreStudio\CRUD\Console;

use Illuminate\Console\Command;

/**
 * Class InstallCommand.
 */
class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish vendor files, run migrations, and seed the database';

    /**
     * Create a new command instance.
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
        $this->call('clear-compiled');
        $this->info('Publishing CSS, JS, Fonts and images required to work');
        $this->call('vendor:publish', [
            '--provider' => 'BlackfyreStudio\CRUD\CRUDProvider',
            '--tag'      => 'public',
        ]);


        $this->info('Publishing config file');
        $this->call('vendor:publish', [
            '--provider' => 'BlackfyreStudio\CRUD\CRUDProvider',
            '--tag'      => 'config',
        ]);


        /* Run migrations */
        $this->info('Running migrations');
        $this->call('migrate');

        /*
        $this->info('Seeding database');
        $this->call('db:seed',[
            '--class'=>'BlackfyreStudio\\CRUD\\DatabaseSeeder'
        ]);
        */

        if ($this->confirm('Do you want to create an administrator?')) {
            $email = $this->ask('The Administrator\'s email address?');

            $this->call('crud:admin', [
            'email' => $email,
            ]);
        }

        $this->info('Creating default controllers');
        $this->call('crud:controller-stub', [
            'name' => 'Role',
        ]);
        $this->call('crud:controller-stub', [
            'name' => 'User',
        ]);

        $this->call('optimize');
    }
}

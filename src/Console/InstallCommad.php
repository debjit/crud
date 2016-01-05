<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command {
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
     *
     */
    public function __construct() {
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
        $this->call('vendor:publish',[
            '--provider'=>'BlackfyreStudio\CRUD\CRUDProvider',
            '--tag'=>'public'
        ]);


        $this->info('Publishing config file');
        $this->call('vendor:publish',[
            '--provider'=>'BlackfyreStudio\CRUD\CRUDProvider',
            '--tag'=>'config'
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
            'email'=>$email
            ]);
        }

        $this->call('optimize');

    }

}

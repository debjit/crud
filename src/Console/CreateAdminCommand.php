<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.04.02.
 * Time: 7:12
 */

namespace BlackfyreStudio\CRUD\Console;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateAdminCommand extends Command {
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

        $user = new User();

        $user->email = $this->argument('email');
        $raw = '';

        if (is_null($this->option('password'))) {
            $password = substr(sha1(time() . $this->argument('email')),0,9);
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
            ['name', null, InputOption::VALUE_OPTIONAL , 'The name of the user', null],
            ['password', null, InputOption::VALUE_OPTIONAL, 'The password for the user', null]
        ];
    }
}
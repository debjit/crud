<?php
/**
 * User: mgalicz
 * Date: 2015.06.18.
 * Time: 13:44
 * Project: crud-tester
 */

 namespace BlackfyreStudio\CRUD\Console;

 use Illuminate\Console\GeneratorCommand;
 use Symfony\Component\Console\Input\InputOption;

 class ControllerCommand extends GeneratorCommand {
     /**
      * The console command name.
      *
      * @var string
      */
     protected $name = 'crud:controller';
     /**
      * The console command description.
      *
      * @var string
      */
     protected $description = 'Create a new CRUD controller';
     /**
      * The type of class being generated.
      *
      * @var string
      */
     protected $type = 'Controller';
     /**
      * Parse the name and format according to the root namespace.
      *
      * @param  string $name
      * @return string
      */
     protected function parseName($name)
     {
         return ucwords(camel_case($name)) . 'Controller';
     }
     /**
      * Get the stub file for the generator.
      *
      * @return string
      */
     protected function getStub()
     {
         return __DIR__ . '/../stubs/controller.stub';
     }

     /**
      * Get the destination class path.
      *
      * @param  string $name
      * @return string
      */
     protected function getPath($name)
     {
         return './app/Http/Controllers/' . \Config::get('crud.directory') . '/' . str_replace('\\', '/', $name) . '.php';
     }

     /**
      * Get the console command options.
      *
      * @return array
      */
     protected function getOptions()
     {
         return [
             ['model', null, InputOption::VALUE_OPTIONAL, 'The name of the model this controller belongs to.', null]
         ];
     }
 }
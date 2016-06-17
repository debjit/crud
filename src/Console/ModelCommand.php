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

use Illuminate\Console\GeneratorCommand;
use Schema;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ModelCommand.
 */
class ModelCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class, Laravel\'s own generator is insufficient';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * The excluded columns for fillable.
     *
     * @var array
     */
    protected $exclude = ['id', 'password'];

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/model.stub';
    }

    /**
     * Build the model class with the given name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $table = $this->option('table') ?: str_plural(strtolower($this->getNameInput()));

        return $this->replaceNamespace($stub, $name)->replaceTable($stub, $table)->replaceFillable($stub, $table)->replaceClass($stub, $name);
    }

    /**
     * Replace the table for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceTable(&$stub, $table)
    {
        $stub = str_replace(
            'DummyTableName', $table, $stub
        );

        return $this;
    }

    /**
     * Replace the fillable for the given stub.
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceFillable(&$stub, $table)
    {
        if ($this->input->getOption('fillable')) {
            // Get the table columns
            $columns = Schema::getColumnListing($table);
            // Exclude the unwanted columns
            $columns = array_filter($columns, function ($value) {
                return ! in_array($value, $this->exclude);
            });
            // Add quotes
            array_walk($columns, function (&$value) {
                $value = "'".$value."'";
            });
            // CSV format
            $columns = implode(',', $columns);
        }

        $stub = str_replace(
            'DummyFillable', isset($columns) ? $columns : '', $stub
        );

        return $this;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['table', null, InputOption::VALUE_OPTIONAL, 'The table name.', null],
            ['fillable', null, InputOption::VALUE_NONE, 'The fillable columns.', null],
        ];
    }
}

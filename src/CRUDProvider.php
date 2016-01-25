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

namespace BlackfyreStudio\CRUD;

use GrahamCampbell\Markdown\Facades\Markdown;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Html\FormFacade;
use Illuminate\Html\HtmlFacade;
use Illuminate\Html\HtmlServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider;

/**
 * Class CRUDProvider
 * @package BlackfyreStudio\CRUD
 */
class CRUDProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupDependencies();

        /*
         * Only register the CLI commands if we're in a local (probably development) environment
         */
        if ($this->app->environment() === 'local') {
            $this->registerCommands();
        }
    }

    /**
     * Set up the package dependencies, so that the developer won't have to :)
     * Some dependencies should be ran in development environments only...
     */
    private function setupDependencies()
    {
        /*
         * Registering dependencies, so the developers won't have to
         */
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(MarkdownServiceProvider::class);
        $this->app->register(HtmlServiceProvider::class);
        $this->app->register(ExcelServiceProvider::class);
        $this->app->register(AuthProvider::class);
        $this->app->register(LaravelGravatarServiceProvider::class);

        /*
         * Adding aliases so the developers won't have to
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('InterventionImage', Image::class);
        $loader->alias('Markdown', Markdown::class);
        $loader->alias('CRUDForm', FormFacade::class);
        $loader->alias('CRUDHTML', HtmlFacade::class);
        $loader->alias('CRUDExcel', Excel::class);
        $loader->alias('CRUDGravatar', Gravatar::class);
    }

    /**
     * This method registers all the commands provided by the package
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.crud.scaffold', function ($app) {
            return $app[Console\ScaffoldCommand::class];
        });

        $this->app->singleton('command.crud.model', function ($app) {
            return $app[Console\ModelCommand::class];
        });

        $this->app->singleton('command.crud.migration', function ($app) {
            return $app[Console\MigrationCommand::class];
        });

        $this->app->singleton('command.crud.admin', function ($app) {
            return $app[Console\CreateAdminCommand::class];
        });

        $this->app->singleton('command.crud.controller', function ($app) {
            return $app[Console\ControllerCommand::class];
        });

        $this->app->singleton('command.crud.roles', function ($app) {
            return $app[Console\CreateRoleCommand::class];
        });

        $this->app->singleton('command.crud.permission', function ($app) {
            return $app[Console\CreatePermissionsCommand::class];
        });

        $this->app->singleton('command.crud.install', function ($app) {
            return $app[Console\InstallCommand::class];
        });

        $this->commands([
            'command.crud.scaffold',
            'command.crud.migration',
            'command.crud.admin',
            'command.crud.controller',
            'command.crud.roles',
            'command.crud.install',
            'command.crud.permission',
            'command.crud.model'
        ]);
    }

    /**
     * @return void
     */
    public function boot()
    {

        /*
         * Setting up view for publishing
         */
        $viewPath = __DIR__ . '/../views';
        $this->publishes([$viewPath => base_path('resources/views/vendor/crud')], 'views');
        $this->loadViewsFrom($viewPath, 'crud');

        /*
         * Setting up asset publishing (css, javascript, fonts, images, ...)
         */
        $publicPath = __DIR__ . '/../public/';
        $this->publishes([$publicPath => public_path('vendor/blackfyrestudio/crud')], 'public');

        /*
         * Setting up config files for publishing
         */
        $configPath = __DIR__ . '/../config/crud.php';
        $this->publishes([$configPath => config_path('crud.php')], 'config');
        $this->mergeConfigFrom($configPath, 'crud');

        /*
         * Setting up migrations to be published
         */
        $migrations = __DIR__ . '/Migrations/';
        $this->publishes([$migrations => base_path('database/migrations')],'migrations');

        /*
         * Setting up translations
         */
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'crud');

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        if ($this->app->environment() === 'local') {
            return array([
                'command.crud.scaffold',
                'command.crud.migration',
                'command.crud.model'
            ]);
        } else {
            return [];
        }

    }
}

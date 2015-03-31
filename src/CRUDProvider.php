<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 22:40
 */

namespace BlackfyreStudio\CRUD;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class CRUDProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupDependencies();
    }

    public function boot() {
        $viewPath = __DIR__.'/../views';
        $this->publishes([$viewPath => base_path('resources/views/vendor/crud')], 'views');
        $this->loadViewsFrom($viewPath, 'crud');

        $publicPath = __DIR__.'/../public';
        $this->publishes([$publicPath => public_path('vendor/blackfyrestudio/crud')], 'public');

        $configPath = __DIR__ . '/../config/crud-config.php';
        $this->mergeConfigFrom($configPath,'crud-config');
        $this->publishes([$configPath=>config_path('crud-config')],'config');

        include 'routes.php';
    }

    private function setupDependencies() {
        /*
         * Registering dependencies, so the user won't have to
         */
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('GrahamCampbell\Markdown\MarkdownServiceProvider');

        /*
         * Adding aliases so the user won't have to
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('Image','Intervention\Image\Facades\Image');
        $loader->alias('Markdown','GrahamCampbell\Markdown\Facades\Markdown');
    }
}
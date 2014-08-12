<?php namespace Rabbit\Labo;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Rabbit\Labo\Libraries\LaboList;
use Rabbit\Labo\Libraries\LaboWidget;

class LaboServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('rabbit/labo');

        include __DIR__.'/../../routes.php';
        include __DIR__.'/../../page_properties.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Labo list
        $this->app->bind(
            'labo-list',
            function () {
                return new LaboList();
            }
        );
        // Labo list facade
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('LaboList', 'Rabbit\Labo\Facades\LaboList');
            }
        );
        // Labo Widget
        $this->app->bind(
            'labo-widget',
            function () {
                return new LaboWidget();
            }
        );
        // Labo Widget facade
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('LaboWidget', 'Rabbit\Labo\Facades\LaboWidget');
            }
        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

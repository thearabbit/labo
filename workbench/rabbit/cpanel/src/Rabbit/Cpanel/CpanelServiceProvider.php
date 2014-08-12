<?php namespace Rabbit\Cpanel;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Rabbit\Cpanel\Libraries\Action;
use Rabbit\Cpanel\Libraries\CharSequence;
use Rabbit\Cpanel\Libraries\CpanelExcelWriter;
use Rabbit\Cpanel\Libraries\CpanelList;
use Rabbit\Cpanel\Libraries\CpanelWidget;
use Rabbit\Cpanel\Libraries\FormProperty;
use Rabbit\Cpanel\Libraries\IDGenerator;
use Rabbit\Cpanel\Libraries\PageProperty;

class CpanelServiceProvider extends ServiceProvider
{

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
        $this->package('rabbit/cpanel');

        include __DIR__ . '/../../routes.php';
        include __DIR__ . '/../../filters.php';
        include __DIR__ . '/../../page_properties.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Select box list
        $this->app->bind(
            'cpanel-list',
            function () {
                return new CpanelList();
            }
        );
        // Select box list facade
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('CpanelList', 'Rabbit\Cpanel\Facades\CpanelList');
            }
        );

        // Cpanel Widget
        $this->app->bind(
            'cpanel-widget',
            function () {
                return new CpanelWidget();
            }
        );
        // Cpanel widget facade
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('CpanelWidget', 'Rabbit\Cpanel\Facades\CpanelWidget');
            }
        );

        // For Action (data table)
        $this->app->bind(
            'action',
            function () {
                return new Action();
            }
        );

        // For Page Property
        $this->app->bind(
            'page-property',
            function () {
                return new PageProperty();
            }
        );

        // For Form Property
        $this->app->bind(
            'form-property',
            function () {
                return new FormProperty();
            }
        );

        // ID Generator
        $this->app->bind(
            'id-generator',
            function () {
                return new IDGenerator();
            }
        );

        // Cpanel Excel Writer
        $this->app->bind(
            'cpanel-excel-writer',
            function () {
                return new CpanelExcelWriter();
            }
        );

        // Character Sequence
        $this->app->bind(
            'char-sequence',
            function () {
                return new CharSequence();
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

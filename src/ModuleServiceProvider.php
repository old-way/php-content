<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:12
 */
namespace Notadd\Content;

use Illuminate\Events\Dispatcher;
use Notadd\Content\Injections\Installer;
use Notadd\Content\Injections\Uninstaller;
use Notadd\Content\Listeners\CsrfTokenRegister;
use Notadd\Content\Listeners\FlowRegister;
use Notadd\Content\Listeners\PermissionGroupRegister;
use Notadd\Content\Listeners\PermissionModuleRegister;
use Notadd\Content\Listeners\PermissionRegister;
use Notadd\Content\Listeners\PermissionTypeRegister;
use Notadd\Content\Listeners\RouteRegister;
use Notadd\Content\Managers\ArticleManager;
use Notadd\Content\Managers\CategoryManager;
use Notadd\Content\Managers\PageManager;
use Notadd\Content\Models\Article;
use Notadd\Content\Models\ArticleDraft;
use Notadd\Content\Observers\ArticleObserver;
use Notadd\Content\Observers\DraftObserver;
use Notadd\Foundation\Module\Abstracts\Module;

/**
 * Class Module.
 */
class ModuleServiceProvider extends Module
{
    /**
     * Boot service provider.
     */
    public function boot()
    {
        Article::observe(ArticleObserver::class);
        ArticleDraft::observe(DraftObserver::class);
        $this->app->make(Dispatcher::class)->subscribe(CsrfTokenRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(FlowRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionModuleRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionGroupRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(PermissionTypeRegister::class);
        $this->app->make(Dispatcher::class)->subscribe(RouteRegister::class);
        $this->loadMigrationsFrom(realpath(__DIR__ . '/../databases/migrations'));
        $this->loadTranslationsFrom(realpath(__DIR__ . '/../resources/translations'), 'content');
        $this->loadViewsFrom(realpath(__DIR__ . '/../resources/views'), 'content');
        $this->publishes([
            realpath(__DIR__ . '/../resources/mixes/administration/dist/assets/content/administration') => public_path('assets/content/administration'),
            realpath(__DIR__ . '/../resources/mixes/foreground/dist/assets/content/foreground') => public_path('assets/content/foreground'),
        ], 'public');
    }

    /**
     * Install module.
     *
     * @return string
     */
    public static function install()
    {
        return Installer::class;
    }

    /**
     * Register services.
     */
    public function register()
    {
        $this->app->alias('article.manager', ArticleManager::class);
        $this->app->alias('category.manager', CategoryManager::class);
        $this->app->alias('page.manager', PageManager::class);
        $this->app->singleton('article.manager', function ($app) {
            $manager = new ArticleManager($app, $app['events']);

            return $manager;
        });
        $this->app->singleton('category.manager', function ($app) {
            $manager = new CategoryManager($app, $app['events']);

            return $manager;
        });
        $this->app->singleton('page.manager', function ($app) {
            $manager = new PageManager($app, $app['events']);

            return $manager;
        });
    }

    /**
     * Uninstall module.
     *
     * @return string
     */
    public static function uninstall()
    {
        return Uninstaller::class;
    }
}

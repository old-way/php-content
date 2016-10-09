<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:12
 */
namespace Notadd\Content;
use Notadd\Content\Listeners\RouteRegister;
use Notadd\Content\Managers\ArticleManager;
use Notadd\Content\Managers\CategoryManager;
use Notadd\Content\Managers\PageManager;
use Notadd\Extension\Abstracts\ExtensionRegistrar;
/**
 * Class Module
 * @package Notadd\Content
 */
class Extension extends ExtensionRegistrar {
    /**
     * @return string
     */
    protected function getExtensionName() {
        return 'notadd/content';
    }
    /**
     * @return string
     */
    protected function getExtensionPath() {
        return realpath(__DIR__ . '/../');
    }
    /**
     * @return void
     */
    public function register() {
        $this->container->alias('article.manager', ArticleManager::class);
        $this->container->alias('category.manager', CategoryManager::class);
        $this->container->alias('page.manager', PageManager::class);
        $this->container->singleton('article.manager', function($app) {
            return new ArticleManager($app, $app['events']);
        });
        $this->container->singleton('category.manager', function($app) {
            return new CategoryManager($app, $app['events']);
        });
        $this->container->singleton('page.manager', function($app) {
            return new PageManager($app, $app['events']);
        });
        $this->events->subscribe(RouteRegister::class);
    }
}
<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 18:30
 */
namespace Notadd\Content\Listeners;

use Notadd\Content\Controllers\ArticleController;
use Notadd\Content\Controllers\CategoryController;
use Notadd\Content\Controllers\PageController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegistrar
{
    /**
     * @return void
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/article'], function () {
        });
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/category'], function () {
        });
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/page'], function () {
        });
        $this->router->group(['middleware' => 'web', 'prefix' => 'article'], function () {
            $this->router->resource('/', ArticleController::class);
        });
        $this->router->group(['middleware' => 'web', 'prefix' => 'category'], function () {
            $this->router->resource('/', CategoryController::class);
        });
        $this->router->group(['middleware' => 'web', 'prefix' => 'page'], function () {
            $this->router->resource('/', PageController::class);
        });
    }
}

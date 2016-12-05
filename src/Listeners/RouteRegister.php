<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 18:30
 */
namespace Notadd\Content\Listeners;

use Notadd\Content\Controllers\Api\ArticleController as ArticleApiController;
use Notadd\Content\Controllers\Api\ArticleTemplateController as ArticleTemplateApiController;
use Notadd\Content\Controllers\Api\CategoryController as CategoryApiController;
use Notadd\Content\Controllers\Api\CategoryTemplateController as CategoryTemplateApiController;
use Notadd\Content\Controllers\Api\CategoryTypeController as CategoryTypeApiController;
use Notadd\Content\Controllers\Api\PageController as PageApiController;
use Notadd\Content\Controllers\Api\PageTemplateController as PageTemplateApiController;
use Notadd\Content\Controllers\Api\PageTypeController as PageTypeApiController;
use Notadd\Content\Controllers\ArticleController;
use Notadd\Content\Controllers\Api\ArticleTypeController as ArticleTypeApiController;
use Notadd\Content\Controllers\CategoryController;
use Notadd\Content\Controllers\PageController;
use Notadd\Foundation\Routing\Abstracts\RouteRegistrar as AbstractRouteRegistrar;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegistrar
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/article'], function () {
            $this->router->resource('template', ArticleTemplateApiController::class);
            $this->router->resource('type', ArticleTypeApiController::class);
            $this->router->resource('/', ArticleApiController::class);
        });
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/category'], function () {
            $this->router->resource('template', CategoryTemplateApiController::class);
            $this->router->resource('type', CategoryTypeApiController::class);
            $this->router->resource('/', CategoryApiController::class);
        });
        $this->router->group(['middleware' => ['auth:api', 'web'], 'prefix' => 'api/page'], function () {
            $this->router->resource('template', PageTemplateApiController::class);
            $this->router->resource('type', PageTypeApiController::class);
            $this->router->resource('/', PageApiController::class);
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

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 18:30
 */
namespace Notadd\Content\Listeners;

use Notadd\Content\Controllers\Api\Article\ArticleController as ArticleApiController;
use Notadd\Content\Controllers\Api\Article\DraftController as ArticleDraftApiController;
use Notadd\Content\Controllers\Api\Category\CategoryController as CategoryApiController;
use Notadd\Content\Controllers\Api\Page\PageController as PageApiController;
use Notadd\Content\Controllers\Api\Page\CategoryController as PageCategoryApiController;
use Notadd\Content\Controllers\ArticleController;
use Notadd\Content\Controllers\CategoryController;
use Notadd\Content\Controllers\ComponentController;
use Notadd\Content\Controllers\PageController;
use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;

/**
 * Class RouteRegister.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Register.
     */
    public function handle()
    {
        $this->router->group(['middleware' => ['auth:api', 'cross', 'web']], function () {
            $this->router->group(['prefix' => 'api/content/article'], function () {
                $this->router->post('auto', ArticleApiController::class . '@auto');
                $this->router->post('create', ArticleApiController::class . '@create');
                $this->router->post('delete', ArticleApiController::class . '@delete');
                $this->router->post('edit', ArticleApiController::class . '@edit');
                $this->router->group(['prefix' => 'draft'], function () {
                    $this->router->post('create', ArticleDraftApiController::class . '@create');
                    $this->router->post('delete', ArticleDraftApiController::class . '@delete');
                    $this->router->post('find', ArticleDraftApiController::class . '@find');
                    $this->router->post('fetch', ArticleDraftApiController::class . '@fetch');
                });
            });
            $this->router->group(['prefix' => 'api/content/category'], function () {
                $this->router->post('create', CategoryApiController::class . '@create');
                $this->router->post('delete', CategoryApiController::class . '@delete');
                $this->router->post('edit', CategoryApiController::class . '@edit');
                $this->router->post('find', CategoryApiController::class . '@find');
                $this->router->post('fetch', CategoryApiController::class . '@fetch');
                $this->router->post('sort', CategoryApiController::class . '@sort');
            });
            $this->router->group(['prefix' => 'api/content/component'], function () {
                $this->router->post('get', ComponentController::class . '@get');
                $this->router->post('set', ComponentController::class . '@set');
            });
            $this->router->group(['prefix' => 'api/content/page'], function () {
                $this->router->post('create', PageApiController::class . '@create');
                $this->router->post('delete', PageApiController::class . '@delete');
                $this->router->post('edit', PageApiController::class . '@edit');
                $this->router->post('find', PageApiController::class . '@find');
                $this->router->post('fetch', PageApiController::class . '@fetch');
                $this->router->group(['prefix' => 'category'], function () {
                    $this->router->post('create', PageCategoryApiController::class . '@create');
                    $this->router->post('delete', PageCategoryApiController::class . '@delete');
                    $this->router->post('edit', PageCategoryApiController::class . '@edit');
                    $this->router->post('find', PageCategoryApiController::class . '@find');
                    $this->router->post('fetch', PageCategoryApiController::class . '@fetch');
                    $this->router->post('sort', PageCategoryApiController::class . '@sort');
                });
            });
        });
        $this->router->group(['middleware' => ['cross', 'web']], function () {
            $this->router->group(['prefix' => 'api/content/article'], function () {
                $this->router->post('find', ArticleApiController::class . '@find');
                $this->router->post('fetch', ArticleApiController::class . '@fetch');
            });
        });
        $this->router->group(['middleware' => 'web'], function () {
            $this->router->get('/', function () {
                return $this->container->make('view')->make('content::content');
            });
            $this->router->resource('article', ArticleController::class);
            $this->router->resource('category', CategoryController::class);
            $this->router->resource('page', PageController::class);
            $this->router->resource('about', PageController::class);
        });
    }
}

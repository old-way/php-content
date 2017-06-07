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
use Notadd\Content\Controllers\Api\Article\TemplateController as ArticleTemplateApiController;
use Notadd\Content\Controllers\Api\Category\CategoryController as CategoryApiController;
use Notadd\Content\Controllers\Api\Category\TemplateController as CategoryTemplateApiController;
use Notadd\Content\Controllers\Api\Category\TypeController as CategoryTypeApiController;
use Notadd\Content\Controllers\Api\Page\PageController as PageApiController;
use Notadd\Content\Controllers\Api\Page\CategoryController as PageCategoryApiController;
use Notadd\Content\Controllers\Api\Page\TemplateController as PageTemplateApiController;
use Notadd\Content\Controllers\Api\Page\TypeController as PageTypeApiController;
use Notadd\Content\Controllers\ArticleController;
use Notadd\Content\Controllers\Api\Article\TypeController as ArticleTypeApiController;
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
                $this->router->group(['prefix' => 'template'], function () {
                    $this->router->post('create', ArticleTemplateApiController::class . '@create');
                    $this->router->post('delete', ArticleTemplateApiController::class . '@delete');
                    $this->router->post('edit', ArticleTemplateApiController::class . '@edit');
                    $this->router->post('find', ArticleTemplateApiController::class . '@find');
                    $this->router->post('fetch', ArticleTemplateApiController::class . '@fetch');
                });
                $this->router->group(['prefix' => 'type'], function () {
                    $this->router->post('create', ArticleTypeApiController::class . '@create');
                    $this->router->post('delete', ArticleTypeApiController::class . '@delete');
                    $this->router->post('edit', ArticleTypeApiController::class . '@edit');
                    $this->router->post('find', ArticleTypeApiController::class . '@find');
                    $this->router->post('fetch', ArticleTypeApiController::class . '@fetch');
                });
            });
            $this->router->group(['prefix' => 'api/content/category'], function () {
                $this->router->post('create', CategoryApiController::class . '@create');
                $this->router->post('delete', CategoryApiController::class . '@delete');
                $this->router->post('edit', CategoryApiController::class . '@edit');
                $this->router->post('find', CategoryApiController::class . '@find');
                $this->router->post('fetch', CategoryApiController::class . '@fetch');
                $this->router->post('sort', CategoryApiController::class . '@sort');
                $this->router->group(['prefix' => 'template'], function () {
                    $this->router->post('create', CategoryTemplateApiController::class . '@create');
                    $this->router->post('delete', CategoryTemplateApiController::class . '@delete');
                    $this->router->post('edit', CategoryTemplateApiController::class . '@edit');
                    $this->router->post('find', CategoryTemplateApiController::class . '@find');
                    $this->router->post('fetch', CategoryTemplateApiController::class . '@fetch');
                });
                $this->router->group(['prefix' => 'type'], function () {
                    $this->router->post('create', CategoryTypeApiController::class . '@create');
                    $this->router->post('delete', CategoryTypeApiController::class . '@delete');
                    $this->router->post('edit', CategoryTypeApiController::class . '@edit');
                    $this->router->post('find', CategoryTypeApiController::class . '@find');
                    $this->router->post('fetch', CategoryTypeApiController::class . '@fetch');
                });
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
                $this->router->group(['prefix' => 'template'], function () {
                    $this->router->post('create', PageTemplateApiController::class . '@create');
                    $this->router->post('delete', PageTemplateApiController::class . '@delete');
                    $this->router->post('edit', PageTemplateApiController::class . '@edit');
                    $this->router->post('find', PageTemplateApiController::class . '@find');
                    $this->router->post('fetch', PageTemplateApiController::class . '@fetch');
                });
                $this->router->group(['prefix' => 'type'], function () {
                    $this->router->post('create', PageTypeApiController::class . '@create');
                    $this->router->post('delete', PageTypeApiController::class . '@delete');
                    $this->router->post('edit', PageTypeApiController::class . '@edit');
                    $this->router->post('find', PageTypeApiController::class . '@find');
                    $this->router->post('fetch', PageTypeApiController::class . '@fetch');
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

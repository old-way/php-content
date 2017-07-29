<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:34
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class FetchHandler.
 */
class ListHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        if ($this->request->input('with-children')) {
            $categories = ArticleCategory::query()->orderBy('order_id', 'asc')->get();
            $categories->transform(function (ArticleCategory $category) {
                $children = ArticleCategory::query()->where('parent_id',
                    $category->getAttribute('id'))->orderBy('order_id', 'asc')->get();
                $children->count() && $category->setAttribute('children', $children);

                return $category;
            });
            $this->withCode(200)
                ->withData($categories->toArray())
                ->withMessage('content::category.fetch.success');
        } else {
            $this->withCode(200)
                ->withData((new ArticleCategory())->structure())
                ->withMessage('content::category.fetch.success');
        }
    }
}

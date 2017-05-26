<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:34
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\Handler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        if ($this->request->input('with-children')) {
            $categories = Category::query()->orderBy('order_id', 'asc')->get();
            $categories->transform(function (Category $category) {
                $children = Category::query()->where('parent_id',
                    $category->getAttribute('id'))->orderBy('order_id', 'asc')->get();
                $children->count() && $category->setAttribute('children', $children);

                return $category;
            });
            $this->success()
                ->withData($categories->toArray())
                ->withMessage('content::category.fetch.success');
        }
        $this->success()
            ->withData((new Category())->structure())
            ->withMessage('content::category.fetch.success');
    }
}

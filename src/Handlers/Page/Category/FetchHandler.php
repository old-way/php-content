<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:48
 */
namespace Notadd\Content\Handlers\Page\Category;

use Notadd\Content\Models\PageCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;

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
            $categories = PageCategory::query()->orderBy('order_id', 'asc')->get();
            $categories->transform(function (PageCategory $category) {
                $children = PageCategory::query()->where('parent_id', $category->getAttribute('id'))
                    ->orderBy('order_id', 'asc')
                    ->get();
                $children->count() && $category->setAttribute('children', $children);
                return $category;
            });
            $this->withCode(200)->withData($categories->toArray())->withMessage('content::category.fetch.success');
        } else {
            $this->withCode(200)
                ->withData((new PageCategory())->structure())
                ->withMessage('content::category.fetch.success');
        }
    }
}

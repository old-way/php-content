<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:51
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Support\Collection;
use Notadd\Content\Models\Page;
use Notadd\Content\Models\PageCategory;
use Notadd\Foundation\Passport\Abstracts\Handler;

/**
 * Class FindHandler.
 */
class FindHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $page = Page::query()->find($this->request->input('id'));
        $category = $page->getAttribute('category');
        if ($category) {
            $data = new Collection();
            $this->loopCategory($page->getAttribute('category_id'), $data);
            $page->setAttribute('category', $category->getAttributes());
            $page->setAttribute('category_path', $data->toArray());
        }
        $this->success()->withData($page->getAttributes())->withMessage('content::page.find.success');
    }

    /**
     * @param                                $id
     * @param \Illuminate\Support\Collection $data
     */
    protected function loopCategory($id, Collection $data)
    {
        $parent = (new PageCategory())->newQuery()->find($id);
        if ($parent) {
            $data->prepend($parent->getAttribute('id'));
            $parent->getAttribute('parent_id') && $this->loopCategory($parent->getAttribute('parent_id'), $data);
        }
    }
}

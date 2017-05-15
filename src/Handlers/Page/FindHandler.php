<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:51
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Content\Models\Page;
use Notadd\Content\Models\PageCategory;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\Page     $page
     */
    public function __construct(
        Container $container,
        Page $page
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::page.find.fail'));
        $this->messages->push($this->translator->trans('content::page.find.success'));
        $this->model = $page;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $page = $this->model->newQuery()->find($this->request->input('id'));
        $category = $page->getAttribute('category');
        if ($category) {
            $data = new Collection();
            $this->loopCategory($page->getAttribute('category_id'), $data);
            $page->setAttribute('category', $category->getAttributes());
            $page->setAttribute('category_path', $data->toArray());
        }

        return $page->getAttributes();
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

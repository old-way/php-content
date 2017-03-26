<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:51
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Notadd\Content\Models\Page;
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
            $page->setAttribute('category', $category->getAttributes());
        }

        return $page->getAttributes();
    }
}

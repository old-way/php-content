<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Notadd\Content\Models\Category $category
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Category $category,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::category.find.fail'));
        $this->messages->push($this->translator->trans('content::category.find.success'));
        $this->model = $category;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $category = $this->model->newQuery()->find($this->request->input('id'));

        return $category->getAttributes();
    }
}

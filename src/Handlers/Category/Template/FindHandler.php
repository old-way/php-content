<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:22
 */
namespace Notadd\Content\Handlers\Category\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\CategoryTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Notadd\Content\Models\CategoryTemplate $categoryTemplate
     * @param \Illuminate\Container\Container         $container
     */
    public function __construct(
        CategoryTemplate $categoryTemplate,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::category_template.find.fail'));
        $this->messages->push($this->translator->trans('content::category_template.find.success'));
        $this->model = $categoryTemplate;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $categoryTemplate = $this->model->newQuery()->find($this->request->input('id'));

        return $categoryTemplate->getAttributes();
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:23
 */
namespace Notadd\Content\Handlers\Page\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Illuminate\Container\Container     $container
     * @param \Notadd\Content\Models\PageTemplate $pageTemplate
     */
    public function __construct(
        Container $container,
        PageTemplate $pageTemplate
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::page_template.find.fail'));
        $this->messages->push($this->translator->trans('content::page_template.find.success'));
        $this->model = $pageTemplate;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $pageTemplate = $this->model->newQuery()->find($this->request->input('id'));

        return $pageTemplate->getAttributes();
    }
}

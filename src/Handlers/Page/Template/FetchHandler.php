<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:37
 */
namespace Notadd\Content\Handlers\Page\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * FetchHandler constructor.
     *
     * @param \Illuminate\Container\Container     $container
     * @param \Notadd\Content\Models\PageTemplate $pageTemplate
     */
    public function __construct(
        Container $container,
        PageTemplate $pageTemplate
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::page_template.fetch.fail'));
        $this->messages->push($this->translator->trans('content::page_template.fetch.success'));
        $this->model = $pageTemplate;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        if($this->hasFilter) {
            return $this->model->get();
        } else {
            return $this->model->all();
        }
    }
}

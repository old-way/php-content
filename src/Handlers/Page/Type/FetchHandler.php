<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:37
 */
namespace Notadd\Content\Handlers\Page\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * FetchHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\PageType $pageType
     */
    public function __construct(
        Container $container,
        PageType $pageType
    ) {
        parent::__construct($container);
        $this->model = $pageType;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        if ($this->hasFilter) {
            return $this->model->get();
        } else {
            return $this->model->all();
        }
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page_type.fetch.fail'),
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::page_type.fetch.success'),
        ];
    }
}

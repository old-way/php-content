<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:51
 */
namespace Notadd\Content\Handlers\Finders;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Content\Models\Page;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageFindHandler.
 */
class PageFinderHandler extends DataHandler
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Notadd\Content\Models\Page
     */
    protected $page;

    /**
     * PageFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\Page     $page
     * @param \Illuminate\Http\Request        $request
     */
    public function __construct(Container $container, Page $page, Request $request)
    {
        parent::__construct($container);
        $this->page = $page;
        $this->request = $request;
    }

    /**
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * @return array
     */
    public function data()
    {
        $page = $this->page->newQuery()->find($this->request->input('id'));

        return $page->getAttributes();
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

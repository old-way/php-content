<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:37
 */
namespace Notadd\Content\Handlers\Fetchers;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageTypeFetcherHandler.
 */
class PageTypeFetcherHandler extends DataHandler
{
    /**
     * @var \Notadd\Content\Models\PageType
     */
    protected $pageType;

    /**
     * PageTypeFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container    $container
     * @param \Notadd\Content\Models\PageType    $pageType
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Container $container,
        PageType $pageType,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->pageType = $pageType;
    }
}

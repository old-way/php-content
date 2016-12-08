<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:23
 */
namespace Notadd\Content\Controllers\Api;

use Notadd\Content\Handlers\Finders\PageTemplateFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageTemplateController.
 */
class PageTemplateController extends Controller
{
    /**
     * Add a page template show handler.
     *
     * @param \Notadd\Content\Handlers\Finders\PageTemplateFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function show(PageTemplateFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

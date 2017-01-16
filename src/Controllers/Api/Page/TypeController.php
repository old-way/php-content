<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:23
 */
namespace Notadd\Content\Controllers\Api\Page;

use Notadd\Content\Handlers\Finders\PageTypeFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageTypeController.
 */
class TypeController extends Controller
{
    /**
     * Add a page type show handler.
     *
     * @param \Notadd\Content\Handlers\Finders\PageTypeFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function show(PageTypeFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

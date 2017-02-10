<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 19:50
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\ComponentHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ComponentController.
 */
class ComponentController extends Controller
{
    /**
     * Seo handler.
     *
     * @param \Notadd\Content\Handlers\ComponentHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function seo(ComponentHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 19:50
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Component\GetHandler;
use Notadd\Content\Handlers\Component\SetHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ComponentController.
 */
class ComponentController extends Controller
{
    /**
     * Get handler.
     *
     * @param \Notadd\Content\Handlers\Component\GetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function get(GetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Set handler.
     *
     * @param \Notadd\Content\Handlers\Component\SetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function set(SetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

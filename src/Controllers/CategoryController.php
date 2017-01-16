<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:26
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Category\CreateHandler;
use Notadd\Content\Handlers\Category\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Category\CreateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function create(CreateHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Show handler.
     *
     * @param \Notadd\Content\Handlers\Category\FindHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(FindHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

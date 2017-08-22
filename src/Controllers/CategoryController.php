<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:26
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Category\CreateHandler;
use Notadd\Content\Handlers\Category\CategoryHandler;
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
     * @param \Notadd\Content\Handlers\Category\CategoryHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(CategoryHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

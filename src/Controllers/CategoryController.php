<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:26
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Finders\CategoryFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class CategoryController.
 */
class CategoryController extends Controller
{
    /**
     * @param \Notadd\Content\Handlers\Finders\CategoryFinderHandler $handler
     *
     * @return \Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function show(CategoryFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

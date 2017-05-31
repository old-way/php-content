<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-17 18:06
 */
namespace Notadd\Content\Controllers\Api\Article;

use Notadd\Content\Handlers\Article\Draft\CreateHandler;
use Notadd\Content\Handlers\Article\Draft\DeleteHandler;
use Notadd\Content\Handlers\Article\Draft\FetchHandler;
use Notadd\Content\Handlers\Article\Draft\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class DraftController.
 */
class DraftController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Article\Draft\CreateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function create(CreateHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Delete handler.
     *
     * @param \Notadd\Content\Handlers\Article\Draft\DeleteHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeleteHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Fetch handler.
     *
     * @param \Notadd\Content\Handlers\Article\Draft\FetchHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function fetch(FetchHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Find handler.
     *
     * @param \Notadd\Content\Handlers\Article\Draft\FindHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function find(FindHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-28 20:19
 */
namespace Notadd\Content\Controllers\Api\Article;

use Notadd\Content\Handlers\Article\AutoHandler;
use Notadd\Content\Handlers\Article\CreateHandler;
use Notadd\Content\Handlers\Article\DeleteHandler;
use Notadd\Content\Handlers\Article\EditHandler;
use Notadd\Content\Handlers\Article\FetchHandler;
use Notadd\Content\Handlers\Article\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    /**
     * Auto handler.
     *
     * @param \Notadd\Content\Handlers\Article\AutoHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function auto(AutoHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Article\CreateHandler $handler
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
     * @param \Notadd\Content\Handlers\Article\DeleteHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeleteHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Edit handler.
     *
     * @param \Notadd\Content\Handlers\Article\EditHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function edit(EditHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Fetch handler.
     *
     * @param \Notadd\Content\Handlers\Article\FetchHandler $handler
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
     * @param \Notadd\Content\Handlers\Article\FindHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function find(FindHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

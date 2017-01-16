<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:23
 */
namespace Notadd\Content\Controllers\Api\Page;

use Notadd\Content\Handlers\Page\CreatorHandler;
use Notadd\Content\Handlers\Page\DeleterHandler;
use Notadd\Content\Handlers\Page\EditorHandler;
use Notadd\Content\Handlers\Page\FetcherHandler;
use Notadd\Content\Handlers\Page\FinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageController.
 */
class PageController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Page\CreatorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function create(CreatorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Delete handler.
     *
     * @param \Notadd\Content\Handlers\Page\DeleterHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(DeleterHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Edit handler.
     *
     * @param \Notadd\Content\Handlers\Page\EditorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function edit(EditorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Fetch handler.
     *
     * @param \Notadd\Content\Handlers\Page\FetcherHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function fetch(FetcherHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Find handler.
     *
     * @param \Notadd\Content\Handlers\Page\FinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function find(FinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

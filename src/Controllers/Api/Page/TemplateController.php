<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:23
 */
namespace Notadd\Content\Controllers\Api\Page;

use Notadd\Content\Handlers\Page\Template\CreatorHandler;
use Notadd\Content\Handlers\Page\Template\DeleterHandler;
use Notadd\Content\Handlers\Page\Template\EditorHandler;
use Notadd\Content\Handlers\Page\Template\FetcherHandler;
use Notadd\Content\Handlers\Page\Template\FinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageTemplateController.
 */
class TemplateController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Page\Template\CreatorHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\DeleterHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\EditorHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\FetcherHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\FinderHandler $handler
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

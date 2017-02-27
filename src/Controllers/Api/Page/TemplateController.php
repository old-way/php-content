<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:23
 */
namespace Notadd\Content\Controllers\Api\Page;

use Notadd\Content\Handlers\Page\Template\CreateHandler;
use Notadd\Content\Handlers\Page\Template\DeleteHandler;
use Notadd\Content\Handlers\Page\Template\EditHandler;
use Notadd\Content\Handlers\Page\Template\FetchHandler;
use Notadd\Content\Handlers\Page\Template\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageTemplateController.
 */
class TemplateController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Page\Template\CreateHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\DeleteHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\EditHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\FetchHandler $handler
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
     * @param \Notadd\Content\Handlers\Page\Template\FindHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function find(FindHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

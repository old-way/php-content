<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:21
 */
namespace Notadd\Content\Controllers\Api\Category;

use Notadd\Content\Handlers\Creators\CategoryTypeCreatorHandler;
use Notadd\Content\Handlers\Deleters\CategoryTypeDeleterHandler;
use Notadd\Content\Handlers\Editors\CategoryTypeEditorHandler;
use Notadd\Content\Handlers\Fetchers\CategoryTypeFetcherHandler;
use Notadd\Content\Handlers\Finders\CategoryTypeFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class CategoryTypeController.
 */
class TypeController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Creators\CategoryTypeCreatorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function create(CategoryTypeCreatorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Delete handler.
     *
     * @param \Notadd\Content\Handlers\Deleters\CategoryTypeDeleterHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(CategoryTypeDeleterHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Edit handler.
     *
     * @param \Notadd\Content\Handlers\Editors\CategoryTypeEditorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function edit(CategoryTypeEditorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Fetch handler.
     *
     * @param \Notadd\Content\Handlers\Fetchers\CategoryTypeFetcherHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function fetch(CategoryTypeFetcherHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Find handler.
     *
     * @param \Notadd\Content\Handlers\Finders\CategoryTypeFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function find(CategoryTypeFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:21
 */
namespace Notadd\Content\Controllers\Api\Category;

use Notadd\Content\Handlers\Creators\CategoryTemplateCreatorHandler;
use Notadd\Content\Handlers\Deleters\CategoryTemplateDeleterHandler;
use Notadd\Content\Handlers\Editors\CategoryTemplateEditorHandler;
use Notadd\Content\Handlers\Fetchers\CategoryTemplateFetcherHandler;
use Notadd\Content\Handlers\Finders\CategoryTemplateFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class CategoryTemplateController.
 */
class TemplateController extends Controller
{
    /**
     * Create handler.
     *
     * @param \Notadd\Content\Handlers\Creators\CategoryTemplateCreatorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function create(CategoryTemplateCreatorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Delete handler.
     *
     * @param \Notadd\Content\Handlers\Deleters\CategoryTemplateDeleterHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function delete(CategoryTemplateDeleterHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Edit handler.
     *
     * @param \Notadd\Content\Handlers\Editors\CategoryTemplateEditorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function edit(CategoryTemplateEditorHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Fetch handler.
     *
     * @param \Notadd\Content\Handlers\Fetchers\CategoryTemplateFetcherHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     * @throws \Exception
     */
    public function fetch(CategoryTemplateFetcherHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Find handler.
     *
     * @param \Notadd\Content\Handlers\Finders\CategoryTemplateFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function find(CategoryTemplateFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

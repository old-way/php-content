<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 14:14
 */
namespace Notadd\Content\Controllers\Api\Article;

use Notadd\Content\Handlers\Article\Information\CreateHandler;
use Notadd\Content\Handlers\Article\Information\EditHandler;
use Notadd\Content\Handlers\Article\Information\InformationHandler;
use Notadd\Content\Handlers\Article\Information\ListHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ArticleInformationController.
 */
class ArticleInformationController extends Controller
{
    /**
     * @param \Notadd\Content\Handlers\Article\Information\CreateHandler $handler
     */
    public function create(CreateHandler $handler)
    {
        $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Content\Handlers\Article\Information\EditHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function edit(EditHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Content\Handlers\Article\Information\InformationHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function information(InformationHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Content\Handlers\Article\Information\ListHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function list(ListHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

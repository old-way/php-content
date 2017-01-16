<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:26
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Article\CreateHandler;
use Notadd\Content\Handlers\Article\DeleteHandler;
use Notadd\Content\Handlers\Article\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    /**
     * Article create.
     *
     * @param \Notadd\Content\Handlers\Article\CreateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function create(CreateHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Article destroy.
     *
     * @param \Notadd\Content\Handlers\Article\DeleteHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function destroy(DeleteHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }

    /**
     * Article show.
     *
     * @param \Notadd\Content\Handlers\Article\FindHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(FindHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

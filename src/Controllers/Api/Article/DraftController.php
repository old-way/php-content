<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 18:06
 */
namespace Notadd\Content\Controllers\Api\Article;

use Notadd\Content\Handlers\Article\Draft\CreateHandler;
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
}

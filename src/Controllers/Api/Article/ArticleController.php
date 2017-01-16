<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:19
 */
namespace Notadd\Content\Controllers\Api\Article;

use Notadd\Content\Handlers\Finders\ArticleFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    /**
     * Add a article show handler.
     *
     * @param \Notadd\Content\Handlers\Finders\ArticleFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function show(ArticleFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

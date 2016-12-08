<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:16
 */
namespace Notadd\Content\Controllers\Api;

use Notadd\Content\Handlers\Finders\ArticleTemplateFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class ArticleTemplateController.
 */
class ArticleTemplateController extends Controller
{
    /**
     * Add a article template show handler.
     *
     * @param \Notadd\Content\Handlers\Finders\ArticleTemplateFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function show(ArticleTemplateFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

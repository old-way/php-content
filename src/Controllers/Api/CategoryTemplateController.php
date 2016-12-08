<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-28 20:21
 */
namespace Notadd\Content\Controllers\Api;

use Notadd\Content\Handlers\Finders\CategoryTemplateFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class CategoryTemplateController.
 */
class CategoryTemplateController extends Controller
{
    /**
     * Add a category template show handler.
     *
     * @param \Notadd\Content\Handlers\Finders\CategoryTemplateFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse * @throws \Exception
     * @throws \Exception
     */
    public function show(CategoryTemplateFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

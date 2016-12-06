<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Creators\PageCreatorHandler;
use Notadd\Content\Handlers\Deleters\PageDeleterHandler;
use Notadd\Content\Handlers\Finders\PageFinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageController.
 */
class PageController extends Controller
{
    /**
     * Page create.
     *
     * @param \Notadd\Content\Handlers\Creators\PageCreatorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function create(PageCreatorHandler $handler)
    {
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }

    /**
     * Page destroy.
     *
     * @param \Notadd\Content\Handlers\Deleters\PageDeleterHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function destroy(PageDeleterHandler $handler)
    {
        return $handler->toResponse($this->request)->generateHttpResponse();
    }

    /**
     * Page show.
     *
     * @param \Notadd\Content\Handlers\Finders\PageFinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(PageFinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

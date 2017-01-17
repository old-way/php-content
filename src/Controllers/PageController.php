<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Page\CreateHandler;
use Notadd\Content\Handlers\Page\DeleteHandler;
use Notadd\Content\Handlers\Page\FindHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageController.
 */
class PageController extends Controller
{
    /**
     * Page create.
     *
     * @param \Notadd\Content\Handlers\Page\CreateHandler $handler
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
     * Page destroy.
     *
     * @param \Notadd\Content\Handlers\Page\DeleteHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function destroy(DeleteHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Page show.
     *
     * @param \Notadd\Content\Handlers\Page\FindHandler $handler
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

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Page\CreatorHandler;
use Notadd\Content\Handlers\Page\DeleterHandler;
use Notadd\Content\Handlers\Page\FinderHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageController.
 */
class PageController extends Controller
{
    /**
     * Page create.
     *
     * @param \Notadd\Content\Handlers\Page\CreatorHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function create(CreatorHandler $handler)
    {
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }

    /**
     * Page destroy.
     *
     * @param \Notadd\Content\Handlers\Page\DeleterHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function destroy(DeleterHandler $handler)
    {
        return $handler->toResponse($this->request)->generateHttpResponse();
    }

    /**
     * Page show.
     *
     * @param \Notadd\Content\Handlers\Page\FinderHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(FinderHandler $handler)
    {
        $response = $handler->toResponse();

        return $response->generateHttpResponse();
    }
}

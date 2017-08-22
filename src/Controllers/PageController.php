<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Controllers;

use Notadd\Content\Handlers\Page\CreateHandler;
use Notadd\Content\Handlers\Page\RemoveHandler;
use Notadd\Content\Handlers\Page\PageHandler;
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
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Page destroy.
     *
     * @param \Notadd\Content\Handlers\Page\RemoveHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function destroy(RemoveHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * Index handler.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->view('content::content');
    }

    /**
     * Page show.
     *
     * @param \Notadd\Content\Handlers\Page\PageHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function show(PageHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}

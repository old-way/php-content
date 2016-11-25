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
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class PageController.
 */
class PageController extends Controller
{
    public function create(PageCreatorHandler $handler)
    {
        $response = $handler->toResponse($this->request);

        return $response->generateHttpResponse();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        return $this->view('');
    }
}

<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Controllers;
use Notadd\Foundation\Routing\Abstracts\AbstractController;
/**
 * Class PageController
 * @package Notadd\Content\Controllers
 */
class PageController extends AbstractController {
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
        return $this->view('');
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id) {
        return $this->view('');
    }
}
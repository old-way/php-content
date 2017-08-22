<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:34
 */
namespace Notadd\Content\Handlers\Page;

use Notadd\Content\Models\Page;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class DeleteHandler.
 */
class RemoveHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $id = $this->request->input('id');
        if (($page = Page::query()->find($id)) && $page->delete()) {
            $this->withCode(200)->withMessage('content::page.delete.success');
        } else {
            $this->withCode(500)->withError('content::page.delete.fail');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:46
 */
namespace Notadd\Content\Handlers\Page\Category;

use Notadd\Content\Models\PageCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class DeleteHandler.
 */
class DeleteHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $id = $this->request->input('id');
        if (($category = PageCategory::query()->find($id)) && $category->delete()) {
            $this->withCode(200)->withMessage('content::category.delete.success');
        } else {
            $this->withCode(500)->withError('content::category.delete.fail');
        }
    }
}

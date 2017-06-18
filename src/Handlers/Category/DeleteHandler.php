<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:33
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
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
        if (($category = ArticleCategory::query()->find($id)) && $category->delete()) {
            $this->withCode(200)->withMessage('content::category.delete.success');
        } else {
            $this->withCode(500)->withError('content::category.delete.fail');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class FindHandler.
 */
class FindHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->withCode(200)
            ->withData(ArticleCategory::query()->find($this->request->input('id'))->getAttributes())
            ->withMessage('content::category.find.success');
    }
}

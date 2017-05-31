<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:49
 */
namespace Notadd\Content\Handlers\Page\Category;

use Notadd\Content\Models\PageCategory;
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
        $this->success()
            ->withData(PageCategory::query()->find($this->request->input('id'))->getAttributes())
            ->withMessage('content::category.find.success');
    }
}

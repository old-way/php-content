<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-17 19:20
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Passport\Abstracts\Handler;

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
            ->withData(ArticleDraft::query()->find($this->request->input('id'))->getAttributes())
            ->withMessage('content::article.find.success');
    }
}

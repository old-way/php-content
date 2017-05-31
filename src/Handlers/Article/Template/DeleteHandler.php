<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:14
 */
namespace Notadd\Content\Handlers\Article\Template;

use Notadd\Content\Models\ArticleTemplate;
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
        if (($articleTemplate = ArticleTemplate::query()->find($id)) && $articleTemplate->delete()) {
            $this->withCode(200)->withMessage('');
        } else {
            $this->withCode(500)->withError('');
        }
    }
}

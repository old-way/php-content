<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:19
 */
namespace Notadd\Content\Handlers\Article\Type;

use Notadd\Content\Models\ArticleType;
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
        if (($articleType = ArticleType::query()->find($id)) && $articleType->delete()) {
            $this->withCode(200)->withMessage('content::article_type.delete.success');
        } else {
            $this->withCode(500)->withError('content::article_type.delete.fail');
        }
    }
}

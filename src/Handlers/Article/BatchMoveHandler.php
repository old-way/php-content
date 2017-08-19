<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:34
 */
namespace Notadd\Content\Handlers\Article;

use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class DeleteHandler.
 */
class BatchMoveHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $id = $this->request->input('id');
        $data = array('category_id' => $this->request->input('category_id'));
        if ($Article = Article::whereIn('id', $id)->update($data)) {
            $this->withCode(200)->withMessage('content::article.batchMove.success');
        } else {
            $this->withCode(500)->withError('content::article.batchMove.fail');
        }
    }
}

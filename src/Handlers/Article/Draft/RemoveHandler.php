<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-17 19:02
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Notadd\Content\Models\ArticleDraft;
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
        $article = ArticleDraft::query()->withTrashed()->find($this->request->input('id'));
        if ($article) {
            $force = $this->request->input('force');
            $restore = $this->request->input('restore');
            if ($force) {
                $article->forceDelete();
                $message = 'content::article.force.success';
            } elseif ($restore) {
                $article->restore();
                $message = 'content::article.restore.success';
            } else {
                $article->delete();
                $message = 'content::article.delete.success';
            }
            $this->withCode(200)->withMessage($message);
        } else {
            $this->withCode(500)->withError('');
        }
    }
}

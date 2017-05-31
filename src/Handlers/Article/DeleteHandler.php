<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:32
 */
namespace Notadd\Content\Handlers\Article;

use Notadd\Content\Models\Article;
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
        $article = Article::query()->withTrashed()->find($this->request->input('id'));
        if ($article) {
            $force = $this->request->input('force');
            $restore = $this->request->input('restore');
            if ($force) {
                $article->forceDelete();
                $message = 'content::article.force.success';
            } elseif ($restore) {
                $article->restore();
                $message = 'content::article.force.success';
            } else {
                $article->delete();
                $message = 'content::article.force.success';
            }
            $this->withCode(200)->withMessage($message);
        } else {
            $this->withCode(500)->withError('');
        }
    }
}

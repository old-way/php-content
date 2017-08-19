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
use Notadd\Foundation\Validation\Rule;

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
        $this->validate($this->request, [
            'forced'  => Rule::boolean(),
            'id'      => [
                Rule::exists('content_articles'),
                Rule::numeric(),
                Rule::required(),
            ],
            'restore' => Rule::boolean(),
        ], [
            'forced.boolean'  => '强制性标识必须为布尔值',
            'id.exists'       => '没有对应的文章信息',
            'id.numeric'      => '文章 ID 必须为数值',
            'id.required'     => '文章 ID 必须填写',
            'restore.boolean' => '恢复标识必须为布尔值',
        ]);
        $this->beginTransaction();
        $article = Article::query()->withTrashed()->find($this->request->input('id'));
        $result = false;
        $message = '';
        if ($article instanceof Article) {
            if ($this->request->input('forced') && $article->forceDelete()) {
                $result = true;
                $message = '强制删除文章信息成功！';
            } else if ($this->request->input('restore') && $article->restore()) {
                $result = true;
                $message = '恢复已删除文章成功！';
            } else if ($article->delete()) {
                $result = true;
                $message = '删除文章信息成功！';
            }
        }
        if ($result) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage($message);
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('删除文章信息失败！');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:31
 */
namespace Notadd\Content\Handlers\Article;

use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'category_id' => Rule::numeric(),
            'content'     => Rule::required(),
            'id'          => [
                Rule::exists('content_articles'),
                Rule::numeric(),
                Rule::required(),
            ],
            'is_hidden'   => Rule::boolean(),
            'is_sticky'   => Rule::boolean(),
            'source_link' => Rule::url(),
            'title'       => Rule::required(),
        ], [
            'category_id.numeric' => '分类 ID 必须为数值',
            'content.required'    => '必须填写文章内容',
            'id.exists'           => '没有对应的文章信息',
            'id.numeric'          => '文章 ID 必须为数值',
            'id.required'         => '文章 ID 必须填写',
            'is_hidden.boolean'   => '是否隐藏标识必须为布尔值',
            'is_sticky.boolean'   => '是否置顶标识必须为布尔值',
            'source_link.url'     => '来源链接不是合法的URL',
            'title.required'      => '必须填写文章标题',
        ]);
        $this->beginTransaction();
        $data = $this->request->only([
            'category_id',
            'content',
            'created_at',
            'description',
            'is_hidden',
            'is_sticky',
            'keyword',
            'source_author',
            'source_link',
            'title',
        ]);
        $article = Article::query()->find($this->request->input('id'));
        if ($article && $article->update($data)) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Article;

use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class FindHandler.
 */
class ArticleHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'id' => [
                Rule::exists('content_articles'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的文章信息',
            'id.numeric'  => '文章 ID 必须为数值',
            'id.required' => "文章 ID 必须填写",
        ]);
        $article = Article::query()->with('category.parent.parent')->find($this->request->input('id'));
        if ($article instanceof Article) {
            $this->withCode(200)->withData($article)->withMessage('content::article.find.success');
        } else {
            $this->withCode(500)->withError('获取文章信息失败！');
        }
    }
}

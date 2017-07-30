<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Article;

use Carbon\Carbon;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
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
            'content'     => 'required',
            'source_link' => 'url',
            'title'       => 'required',
        ], [
            'content.required' => '必须填写文章内容',
            'source_link.url'  => '来源链接不是合法的URL',
            'title.required'   => '必须填写文章标题',
        ]);
        $this->container->make('log')->info('create article:', $this->request->all());
        if ($article = Article::query()->create([
            'category_id'   => $this->request->input('category_id', 0),
            'content'       => $this->request->input('content'),
            'is_hidden'     => $this->request->input('hidden', false),
            'is_sticky'     => $this->request->input('sticky', false),
            'source_author' => $this->request->input('source_author'),
            'source_link'   => $this->request->input('source_link'),
            'description'   => $this->request->input('summary'),
            'keyword'       => $this->request->input('tags'),
            'title'         => $this->request->input('title'),
        ])
        ) {
            $this->request->has('date') && $article->update([
                'created_at' => new Carbon($this->request->input('date')),
            ]);
            $this->withCode(200)->withMessage('创建文章信息成功！');
        } else {
            $this->withCode(500)->withError('创建文章信息失败！');
        }
    }
}

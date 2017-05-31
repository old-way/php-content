<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:31
 */
namespace Notadd\Content\Handlers\Article;

use Carbon\Carbon;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;

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
            'content'     => 'required',
            'source_link' => 'url',
            'title'       => 'required',
        ], [
            'content.required' => '必须填写文章内容',
            'source_link.url'  => '来源链接不是合法的URL',
            'title.required'   => '必须填写文章标题',
        ]);
        $article = Article::query()->find($this->request->input('id'));
        if ($article && $article->update([
                'category_id'   => $this->request->input('category_id'),
                'content'       => $this->request->input('content'),
                'is_hidden'     => $this->request->input('hidden'),
                'is_sticky'     => $this->request->input('sticky'),
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
            $this->withCode(200)->withMessage('');
        } else {
            $this->withCode(500)->withError('');
        }
    }
}

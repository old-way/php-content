<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:31
 */
namespace Notadd\Content\Handlers\Article;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * EditHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Article $article, Container $container)
    {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.update.fail'));
        $this->messages->push($this->translator->trans('content::article.update.success'));
        $this->model = $article;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'content' => 'required',
            'title'   => 'required',
        ], [
            'content.required' => '必须填写文章内容',
            'title.required'   => '必须填写文章标题',
        ]);
        $article = $this->model->newQuery()->find($this->request->input('id'));
        $article->update([
            'category_id'   => $this->request->input('category_id'),
            'content'       => $this->request->input('content'),
            'is_hidden'     => $this->request->input('hidden'),
            'is_sticky'     => $this->request->input('sticky'),
            'source_author' => $this->request->input('source_author'),
            'source_link'   => $this->request->input('source_link'),
            'description'   => $this->request->input('summary'),
            'keyword'       => $this->request->input('tags'),
            'title'         => $this->request->input('title'),
        ]);

        $this->request->has('date') && $article->update([
            'created_at' => new Carbon($this->request->input('date')),
        ]);

        return true;
    }
}

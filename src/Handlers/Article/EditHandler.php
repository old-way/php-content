<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:31
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Container\Container;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleEditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * ArticleEditorHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Article $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->model = $article;
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.update.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
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

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::article.update.success'),
        ];
    }
}

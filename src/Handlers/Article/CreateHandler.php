<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Container\Container;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * ArticleCreatorHandler constructor.
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
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return [
            'id' => $this->id,
        ];
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.create.fail'),
        ];
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
            'title' => 'required',
        ], [
            'content.required' => '必须填写文章内容',
            'title.required' => '必须填写文章标题',
        ]);
        $this->model = $this->model->create([
            'category_id'   => $this->request->input('category_id', 0),
            'content'       => $this->request->input('content'),
            'is_hidden'     => $this->request->input('hidden'),
            'is_sticky'     => $this->request->input('sticky'),
            'source_author' => $this->request->input('source_author'),
            'source_link'   => $this->request->input('source_link'),
            'description'   => $this->request->input('summary'),
            'keyword'       => $this->request->input('tags'),
            'title'         => $this->request->input('title'),
        ]);
        $this->id = $this->model->getAttribute('id');

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
            $this->translator->trans('content::article.create.success'),
        ];
    }
}

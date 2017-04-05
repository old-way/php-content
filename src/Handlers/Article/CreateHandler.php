<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Article;

use function Couchbase\fastlzDecompress;
use Illuminate\Container\Container;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * CreateHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Article $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.create.fail'));
        $this->messages->push($this->translator->trans('content::article.create.success'));
        $this->model = $article;
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
        $this->container->make('log')->info('create article:', $this->request->all());
        $this->model = $this->model->newQuery()->create([
            'category_id'   => $this->request->input('category_id', 0),
            'content'       => $this->request->input('content'),
            'is_hidden'     => $this->request->input('hidden', false),
            'is_sticky'     => $this->request->input('sticky', false),
            'source_author' => $this->request->input('source_author'),
            'source_link'   => $this->request->input('source_link'),
            'description'   => $this->request->input('summary'),
            'keyword'       => $this->request->input('tags'),
            'title'         => $this->request->input('title'),
        ]);
        $this->id = $this->model->getAttribute('id');

        return true;
    }
}

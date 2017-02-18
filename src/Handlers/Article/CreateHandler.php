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
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
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
     * @param \Notadd\Content\Models\Article     $article
     * @param \Illuminate\Container\Container    $container
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Article $article,
        Container $container,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
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
     */
    public function execute()
    {
        $this->model = $this->model->create([
            'category_id' => 0,
            'content' => $this->request->input('content'),
            'is_hidden' => $this->request->input('hidden'),
            'is_sticky' => $this->request->input('sticky'),
            'source_author' => $this->request->input('source_author'),
            'source_link' => $this->request->input('source_link'),
            'description' => $this->request->input('summary'),
            'keyword' => $this->request->input('tags'),
            'title' => $this->request->input('title'),
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

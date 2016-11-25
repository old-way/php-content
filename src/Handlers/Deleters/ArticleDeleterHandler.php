<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:32
 */
namespace Notadd\Content\Handlers\Deleters;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleDeleteHandler.
 */
class ArticleDeleterHandler extends SetHandler
{
    /**
     * @var \Notadd\Content\Models\Article
     */
    protected $article;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * ArticleDeleterHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Article $article, Container $container, Request $request)
    {
        parent::__construct($container);
        $this->article = $article;
        $this->request = $request;
    }

    /**
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * @return array
     */
    public function data()
    {
        return [
            'id' => $this->request->input('id'),
        ];
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function execute(Request $request)
    {
        $article = $this->article->newQuery()->find($this->request->input('id'));
        if ($article === null) {
            return false;
        }
        $article->delete();

        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

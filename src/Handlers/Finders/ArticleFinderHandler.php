<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Finders;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class ArticleFindHandler.
 */
class ArticleFinderHandler extends DataHandler
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
     * ArticleFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Http\Request        $request
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
        $article = $this->article->newQuery()->find($this->request->input('id'));
        return $article->getAttributes();
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
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

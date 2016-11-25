<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Creators;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleHandler.
 */
class ArticleCreatorHandler extends SetHandler
{
    /**
     * @var \Notadd\Content\Models\Article
     */
    protected $article;

    /**
     * @var int
     */
    protected $id = 0;

    /**
     * ArticleCreatorHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->article = new Article();
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
            'id' => $this->id,
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
        $this->article = $this->article->create($request->all());
        $this->id = $this->article->getAttribute('id');
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

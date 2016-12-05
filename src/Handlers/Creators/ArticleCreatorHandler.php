<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Creators;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
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
        $this->article = $article;
    }

    /**
     * TODO: Method code Description
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * TODO: Method data Description
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
     * TODO: Method errors Description
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * TODO: Method execute Description
     *
     * @return bool
     */
    public function execute()
    {
        $this->article = $this->article->create($this->request->all());
        $this->id = $this->article->getAttribute('id');

        return true;
    }

    /**
     * TODO: Method messages Description
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

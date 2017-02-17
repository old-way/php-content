<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 19:20
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class ArticleFindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * ArticleFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     * @param \Illuminate\Container\Container     $container
     * @param \Illuminate\Http\Request            $request
     * @param \Illuminate\Translation\Translator  $translator
     */
    public function __construct(
        ArticleDraft $article,
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
        $article = $this->model->newQuery()->find($this->request->input('id'));

        return $article->getAttributes();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.find.fail'),
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::article.find.success'),
        ];
    }
}

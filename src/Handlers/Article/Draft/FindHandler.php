<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-17 19:20
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     * @param \Illuminate\Container\Container     $container
     */
    public function __construct(
        ArticleDraft $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->model = $article;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $article = $this->model->newQuery()->find($this->request->input('id'));
        $this->messages = [
            $this->translator->trans('content::article.find.success'),
        ];

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
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:13
 */
namespace Notadd\Content\Handlers\Article\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleTemplate;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * EditHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleTemplate $articleTemplate
     * @param \Illuminate\Container\Container        $container
     */
    public function __construct(
        ArticleTemplate $articleTemplate,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article_template.update.fail'));
        $this->messages->push($this->translator->trans('content::article_template.update.success'));
        $this->model = $articleTemplate;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $articleTemplate = $this->model->newQuery()->find($this->request->input('id'));
        if ($articleTemplate === null) {
            return false;
        }
        $articleTemplate->update($this->request->all());

        return true;
    }
}

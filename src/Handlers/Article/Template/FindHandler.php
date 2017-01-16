<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:21
 */
namespace Notadd\Content\Handlers\Article\Template;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\ArticleTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class ArticleTemplateFindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * ArticleTemplateFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleTemplate $articleTemplate
     * @param \Illuminate\Container\Container        $container
     * @param \Illuminate\Http\Request               $request
     * @param \Illuminate\Translation\Translator     $translator
     */
    public function __construct(
        ArticleTemplate $articleTemplate,
        Container $container,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = $articleTemplate;
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
        $articleTemplate = $this->model->newQuery()->find($this->request->input('id'));

        return $articleTemplate->getAttributes();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article_template.find.fail'),
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
            $this->translator->trans('content::article_template.find.success'),
        ];
    }
}

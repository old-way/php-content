<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:13
 */
namespace Notadd\Content\Handlers\Editors;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\ArticleTemplate;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleTemplateEditHandler.
 */
class ArticleTemplateEditorHandler extends SetHandler
{
    /**
     * @var \Notadd\Content\Models\ArticleTemplate
     */
    protected $articleTemplate;

    /**
     * ArticleTemplateEditorHandler constructor.
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
        $this->articleTemplate = $articleTemplate;
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
        $articleTemplate = $this->articleTemplate->newQuery()->find($this->request->input('id'));
        if ($articleTemplate === null) {
            return false;
        }
        $articleTemplate->update($this->request->all());

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

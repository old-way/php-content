<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:16
 */
namespace Notadd\Content\Handlers\Editors;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageTemplate;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class PageTemplateEditHandler.
 */
class PageTemplateEditorHandler extends SetHandler
{
    /**
     * @var \Notadd\Content\Models\PageTemplate
     */
    protected $pageTemplate;

    /**
     * PageTemplateEditorHandler constructor.
     *
     * @param \Illuminate\Container\Container     $container
     * @param \Notadd\Content\Models\PageTemplate $pageTemplate
     * @param \Illuminate\Http\Request            $request
     * @param \Illuminate\Translation\Translator  $translator
     */
    public function __construct(
        Container $container,
        PageTemplate $pageTemplate,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->pageTemplate = $pageTemplate;
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
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $pageTemplate = $this->pageTemplate->newQuery()->find($this->request->input('id'));
        if ($pageTemplate === null) {
            return false;
        }
        $pageTemplate->update($this->request->all());

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

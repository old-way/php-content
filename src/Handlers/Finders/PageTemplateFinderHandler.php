<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:23
 */
namespace Notadd\Content\Handlers\Finders;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageTemplateFindHandler.
 */
class PageTemplateFinderHandler extends DataHandler
{
    /**
     * @var \Notadd\Content\Models\PageTemplate
     */
    protected $pageTemplate;

    /**
     * PageTemplateFinderHandler constructor.
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
        $pageTemplate = $this->pageTemplate->newQuery()->find($this->request->input('id'));

        return $pageTemplate->getAttributes();
    }

    /**
     * Errors for handler.
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
     * Messages for handler.
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

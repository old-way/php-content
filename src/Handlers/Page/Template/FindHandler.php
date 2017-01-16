<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:23
 */
namespace Notadd\Content\Handlers\Page\Template;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageTemplate;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageTemplateFindHandler.
 */
class FindHandler extends DataHandler
{
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
        $this->model = $pageTemplate;
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
        $pageTemplate = $this->model->newQuery()->find($this->request->input('id'));

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
            $this->translator->trans('content::page_template.find.fail'),
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
            $this->translator->trans('content::page_template.find.success'),
        ];
    }
}

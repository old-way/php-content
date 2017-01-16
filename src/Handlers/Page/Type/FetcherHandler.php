<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:37
 */
namespace Notadd\Content\Handlers\Page\Type;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageTypeFetcherHandler.
 */
class FetcherHandler extends DataHandler
{
    /**
     * PageTypeFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container    $container
     * @param \Notadd\Content\Models\PageType    $pageType
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Container $container,
        PageType $pageType,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = $pageType;
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
        if($this->hasFilter) {
            return $this->model->get();
        } else {
            return $this->model->all();
        }
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page_type.fetch.fail'),
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
            $this->translator->trans('content::page_type.fetch.success'),
        ];
    }
}

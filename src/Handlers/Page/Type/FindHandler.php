<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:23
 */
namespace Notadd\Content\Handlers\Page\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageTypeFindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * PageTypeFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\PageType $pageType
     */
    public function __construct(
        Container $container,
        PageType $pageType
    ) {
        parent::__construct($container);
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
        $pageType = $this->model->newQuery()->find($this->request->input('id'));

        return $pageType->getAttributes();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page_type.find.fail'),
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
            $this->translator->trans('content::page_type.find.success'),
        ];
    }
}

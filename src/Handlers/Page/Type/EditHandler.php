<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:20
 */
namespace Notadd\Content\Handlers\Page\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * EditHandler constructor.
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
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page_type.update.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $pageType = $this->model->newQuery()->find($this->request->input('id'));
        if ($pageType === null) {
            return false;
        }
        $pageType->update($this->request->all());

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::page_type.update.success'),
        ];
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:21
 */
namespace Notadd\Content\Handlers\Page\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class DeleteHandler.
 */
class DeleteHandler extends SetHandler
{
    /**
     * DeleteHandler constructor.
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
            $this->translator->trans('content::page_type.delete.fail'),
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
        $pageType->delete();

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
            $this->translator->trans('content::page_type.delete.success'),
        ];
    }
}

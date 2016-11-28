<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:16
 */
namespace Notadd\Content\Handlers\Deleters;

use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CategoryTemplateDeleteHandler.
 */
class CategoryTemplateDeleterHandler extends SetHandler
{
    /**
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * @return bool
     */
    public function execute()
    {
        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

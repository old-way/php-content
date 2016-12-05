<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:20
 */
namespace Notadd\Content\Handlers\Creators;

use Illuminate\Http\Request;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class PageTypeCreateHandler.
 */
class PageTypeCreatorHandler extends SetHandler
{
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

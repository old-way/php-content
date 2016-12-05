<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:21
 */
namespace Notadd\Content\Handlers\Deleters;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\PageType;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class PageTypeDeleteHandler.
 */
class PageTypeDeleterHandler extends SetHandler
{
    /**
     * @var \Notadd\Content\Models\PageType
     */
    protected $pageType;

    /**
     * PageTypeDeleterHandler constructor.
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
        $this->pageType = $pageType;
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
        $pageType = $this->pageType->newQuery()->find($this->request->input('id'));
        if ($pageType === null) {
            return false;
        }
        $pageType->delete();

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

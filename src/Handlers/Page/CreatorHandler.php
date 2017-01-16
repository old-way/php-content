<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:28
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\Page;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class PageHandler.
 */
class CreatorHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * PageCreatorHandler constructor.
     *
     * @param \Illuminate\Container\Container    $container
     * @param \Notadd\Content\Models\Page        $page
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Container $container,
        Page $page,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = $page;
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
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page.create.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->id = $this->model->create($this->request->all());

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
            $this->translator->trans('content::page.create.success'),
        ];
    }
}

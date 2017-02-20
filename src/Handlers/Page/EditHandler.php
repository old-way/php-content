<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:34
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\Page;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class PageEditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * PageEditorHandler constructor.
     *
     * @param \Illuminate\Container\Container    $container
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Container $container,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = new Page();
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
            $this->translator->trans('content::page.update.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $page = $this->model->newQuery()->find($this->request->input('id'));
        $page->update([
            'alias' => $this->request->input('alias'),
            'category_id' => $this->request->input('category_id'),
            'content' => $this->request->input('content'),
            'enabled' => $this->request->input('enabled'),
            'parent_id' => 0,
            'title' => $this->request->input('title'),
            'order_id' => 0,
        ]);

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
            $this->translator->trans('content::page.update.success'),
        ];
    }
}

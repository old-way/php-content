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
use Notadd\Content\Models\Page;
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
     */
    public function __construct(
        Container $container
    ) {
        parent::__construct($container);
        $this->model = new Page();
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'title' => 'required',
            'alias' => 'required|alpha_dash|unique:pages,id,' . $this->request->input('id'),
        ], [
            'alias.required' => '必须填写页面别名',
            'alias.alpha_dash' => '页面别名只能由字母、数字和斜杠组成',
            'alias.unique' => '页面别名已被占用',
            'title.required' => '必须填写页面标题',
        ]);
        $page = $this->model->newQuery()->find($this->request->input('id'));
        $page->update([
            'alias'       => $this->request->input('alias'),
            'category_id' => $this->request->input('category_id', 0),
            'content'     => $this->request->input('content'),
            'enabled'     => $this->request->input('enabled'),
            'order_id'    => $this->request->input('order_id', 0),
            'parent_id'   => $this->request->input('parent_id', 0),
            'title'       => $this->request->input('title'),
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

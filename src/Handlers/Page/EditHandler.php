<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:34
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Illuminate\Validation\Rule;
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
        $this->errors->push($this->translator->trans('content::page.update.fail'));
        $this->messages->push($this->translator->trans('content::page.update.success'));
        $this->model = new Page();
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
            'alias' => [
                'required',
                'regex:/^[a-zA-Z\pN_-]+$/u',
                Rule::unique('pages')->ignore($this->request->input('id'), 'id'),
            ],
            'title' => 'required',
        ], [
            'alias.required' => '必须填写页面别名',
            'alias.regex' => '页面别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
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
}

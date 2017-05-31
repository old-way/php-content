<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:28
 */
namespace Notadd\Content\Handlers\Page;

use Notadd\Content\Models\Page;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'alias' => 'required|regex:/^[a-zA-Z\pN_-]+$/u|unique:pages',
            'title' => 'required',
        ], [
            'alias.required' => '必须填写页面别名',
            'alias.regex' => '页面别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.unique' => '页面别名已被占用',
            'title.required' => '必须填写页面标题',
        ]);
        $data = [
            'alias'       => $this->request->input('alias'),
            'category_id' => $this->request->input('category_id', 0),
            'content'     => $this->request->input('content'),
            'enabled'     => $this->request->input('enabled'),
            'order_id'    => $this->request->input('order_id', 0),
            'parent_id'   => $this->request->input('parent_id', 0),
            'title'       => $this->request->input('title'),
        ];
        if (Page::query()->create($data)) {
            $this->withCode(200)->withMessage('content::page.create.success');
        } else {
            $this->withCode(500)->withError('content::page.create.fail');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:33
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Validation\Rule;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
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
            'alias' => [
                'required',
                'regex:/^[a-zA-Z\pN_-]+$/u',
                Rule::unique('categories')->ignore($this->request->input('id'), 'id'),
            ],
            'title' => 'required',
        ], [
            'alias.required' => '必须填写分类别名',
            'alias.regex' => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.unique' => '分类别名已被占用',
            'title.required' => '必须填写分类标题',
        ]);
        $this->container->make('log')->info('edit category', $this->request->all());
        $data = [
            'alias'            => $this->request->input('alias'),
            'background_color' => $this->request->input('background_color'),
            'background_image' => $this->request->input('background_image'),
            'description'      => $this->request->input('description'),
            'enabled'          => $this->request->input('enabled'),
            'pagination'       => $this->request->input('pagination'),
            'seo_title'        => $this->request->input('seo_title'),
            'seo_keyword'      => $this->request->input('seo_keyword'),
            'seo_description'  => $this->request->input('seo_description'),
            'top_image'        => $this->request->input('top_image'),
            'title'            => $this->request->input('name'),
            'type'             => $this->request->input('type') ?: 'normal',
        ];
        $id = $this->request->input('id');
        if (($category = Category::query()->find($id)) && $category->update($data)) {
            $this->withCode(200)->withMessage('content::category.update.success');
        } else {
            $this->withCode(500)->withError('content::category.update.fail');
        }
    }
}

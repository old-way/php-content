<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:45
 */
namespace Notadd\Content\Handlers\Page\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageCategory;
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
            'alias' => 'required|regex:/^[a-zA-Z\pN_-]+$/u|unique:content_page_categories',
            'title' => 'required',
        ], [
            'alias.required' => '必须填写分类别名',
            'alias.regex'    => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.unique'   => '分类别名已被占用',
            'title.required' => '必须填写分类标题',
        ]);
        $data = [
            'alias'            => $this->request->input('alias'),
            'background_color' => $this->request->input('background_color'),
            'background_image' => $this->request->input('background_image'),
            'description'      => $this->request->input('description'),
            'enabled'          => 1,
            'order_id'         => 0,
            'pagination'       => $this->request->input('pagination'),
            'parent_id'        => 0,
            'seo_title'        => $this->request->input('seo_title'),
            'seo_keyword'      => $this->request->input('seo_keyword'),
            'seo_description'  => $this->request->input('seo_description'),
            'title'            => $this->request->input('name'),
            'type'             => $this->request->input('type', 'normal'),
            'top_image'        => $this->request->input('top_image'),
        ];
        if (PageCategory::query()->create($data)) {
            $this->withCode(200)->withMessage('content::category.create.success');
        } else {
            $this->withCode(500)->withError('content::category.create.fail');
        }
    }
}

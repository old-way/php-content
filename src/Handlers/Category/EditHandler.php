<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:33
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

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
            'alias'   => [
                Rule::regex('/^[a-zA-Z\pN_-]+$/u'),
                Rule::required(),
                Rule::unique('content_article_categories')->ignore($this->request->input('id'), 'id'),
            ],
            'enabled' => Rule::boolean(),
            'id'      => [
                Rule::exists('content_article_categories'),
                Rule::numeric(),
                Rule::required(),
            ],
            'title'   => Rule::required(),
            'type'    => Rule::in([
                'normal',
            ]),
        ], [
            'alias.regex'     => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.required'  => '必须填写分类别名',
            'alias.unique'    => '分类别名已被占用',
            'enabled.boolean' => '开启状态必须为布尔值',
            'id.exist'        => '没有对应的文章分类信息',
            'id.numeric'      => '文章分类 ID 必须为数值',
            'id.required'     => '文章分类 ID 必须填写',
            'title.required'  => '必须填写分类标题',
            'type.in'         => '分类类型必须为 normal',
        ]);
        $this->beginTransaction();
        $data = $this->request->only([
            'alias',
            'background_color',
            'background_image',
            'description',
            'enabled',
            'pagination',
            'parent_id',
            'seo_title',
            'seo_keyword',
            'seo_description',
            'title',
            'top_image',
            'type',
        ]);
        $category = ArticleCategory::query()->find($this->request->input('id'));
        if ($category instanceof ArticleCategory && $category->update($data)) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('content::category.update.success');
        } else {
            $this->commitTransaction();
            $this->withCode(500)->withError('content::category.update.fail');
        }
    }
}

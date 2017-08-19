<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

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
            'alias'   => [
                Rule::regex('/^[a-zA-Z\pN_-]+$/u'),
                Rule::required(),
                Rule::unique('content_article_categories'),
            ],
            'enabled' => Rule::boolean(),
            'title'   => Rule::required(),
            'type'    => Rule::in([
                'normal',
            ]),
        ], [
            'alias.regex'     => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.required'  => '必须填写分类别名',
            'alias.unique'    => '分类别名已被占用',
            'enabled.boolean' => '开启状态必须为布尔值',
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
            'seo_title',
            'seo_keyword',
            'seo_description',
            'title',
            'top_image',
        ]);
        if (ArticleCategory::query()->create($data)) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('content::article.find.success');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('content::article.find.fail');
        }
    }
}

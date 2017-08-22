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
 * Class DeleteHandler.
 */
class RemoveHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $this->validate($this->request, [
            'id' => [
                Rule::exists('content_article_categories'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exist'    => '没有对应的文章分类信息',
            'id.numeric'  => '文章分类 ID 必须为数值',
            'id.required' => '文章分类 ID 必须填写',
        ]);
        $this->beginTransaction();
        $category = ArticleCategory::query()->find($this->request->input('id'));
        if ($category instanceof ArticleCategory && $category->delete()) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('content::category.delete.success');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('content::category.delete.fail');
        }
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-14 18:01
 */

namespace Notadd\Content\Handlers\Article\Information;

use Illuminate\Support\Collection;
use Notadd\Content\Models\ArticleCategory;
use Notadd\Content\Models\ArticleInformation;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class InformationHandler.
 */
class InformationHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'id' => [
                Rule::exists('content_article_informations'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的信息项信息',
            'id.numeric'  => '信息项 ID 必须为数值',
            'id.required' => '信息项 ID　必须填写',
        ]);
        $builder = ArticleInformation::query();
        $builder->with('categories');
        $information = $builder->find($this->request->input('id'));
        if ($information instanceof ArticleInformation) {
            $exists = $information->getRelation('categories');
            $exists instanceof Collection && $exists = $exists->keyBy('id');
            $categories = ArticleCategory::query()->with('children.children.children')->whereNull('parent_id')->get();
            $categories->transform(function (ArticleCategory $category) use ($exists) {
                if ($exists->has($category->getAttribute('id'))) {
                    $category->setAttribute('exists', true);
                } else {
                    $category->setAttribute('exists', false);
                }
                $children = $category->getRelation('children');
                $children instanceof Collection && $category->setRelation('children', $children->transform(function (ArticleCategory $category) use ($exists) {
                    if ($exists->has($category->getAttribute('id'))) {
                        $category->setAttribute('exists', true);
                    } else {
                        $category->setAttribute('exists', false);
                    }
                    $children = $category->getRelation('children');
                    $children instanceof Collection && $category->setRelation('children', $children->transform(function (ArticleCategory $category) use ($exists) {
                        if ($exists->has($category->getAttribute('id'))) {
                            $category->setAttribute('exists', true);
                        } else {
                            $category->setAttribute('exists', false);
                        }

                        return $category;
                    }));

                    return $category;
                }));

                return $category;
            });
            $this->withCode(200)->withData($information)->withExtra([
                'categories' => $categories->toArray(),
            ])->withMessage('获取信息项信息成功！');
        } else {
            $this->withCode(500)->withError('获取信息项信息失败！');
        }
    }
}

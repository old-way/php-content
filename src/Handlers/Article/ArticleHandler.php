<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Notadd\Content\Models\Article;
use Notadd\Content\Models\ArticleCategory;
use Notadd\Content\Models\ArticleInformation;
use Notadd\Content\Models\ArticleInformationValue;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class FindHandler.
 */
class ArticleHandler extends Handler
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
                Rule::exists('content_articles'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists'   => '没有对应的文章信息',
            'id.numeric'  => '文章 ID 必须为数值',
            'id.required' => "文章 ID 必须填写",
        ]);
        $article = Article::query()->with('category.parent.parent')->find($this->request->input('id'));
        if ($article instanceof Article) {
            $builder = ArticleCategory::query();
            $builder->with('children.children.children');
            $builder->with('informations');
            $builder->with('children.informations');
            $builder->with('children.children.informations');
            $builder->with('children.children.children.informations');
            $builder->whereNull('parent_id');
            $builder->orderBy('lft', $this->request->input('order', 'asc'));
            $this->withCode(200)->withData($article)->withExtra([
                'categories' => $this->formatData($builder->get()),
            ])->withMessage('content::article.find.success');
        } else {
            $this->withCode(500)->withError('获取文章信息失败！');
        }
    }

    /**
     * @param \Illuminate\Support\Collection $collection
     *
     * @return \Illuminate\Support\Collection
     */
    protected function formatData(Collection $collection)
    {
        return $collection->transform(function (Model $model) {
            $model->has('children') && $model->setRelation('children', $this->formatData($model->getRelation('children')));
            $model->has('informations') && $model->setRelation('informations', $model->getRelation('informations')->transform(function (ArticleInformation $information) {
                switch ($information->getAttribute('type')) {
                    case 'radio':
                        $information->setAttribute('opinions', explode(PHP_EOL, $information->getAttribute('opinions')));
                        break;
                }
                $builder = ArticleInformationValue::query();
                $builder->where('information_id', $information->getAttribute('id'));
                $builder->where('article_id', $this->request->input('id'));
                $information->setAttribute('value', $builder->first() instanceof ArticleInformationValue ?: '');

                return $information;
            }));

            return $model;
        });
    }
}

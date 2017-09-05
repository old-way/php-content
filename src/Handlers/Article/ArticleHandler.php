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
        $builder = Article::query();
        $builder->with('category.informations');
        $article = $builder->find($this->request->input('id'));
        if ($article instanceof Article) {
            $category = $article->getRelation('category');
            if ($category instanceof Model) {
                $informations = $category->getRelation('informations');
                if ($informations instanceof Collection) {
                    $category->setRelation('informations', $informations->transform(function (ArticleInformation $information) {
                        switch ($information->getAttribute('type')) {
                            case 'radio':
                                $information->setAttribute('opinions', explode(PHP_EOL, $information->getAttribute('opinions')));
                                break;
                        }
                        $rules = [];
                        if ($information->getAttribute('required')) {
                            $rules['required'] = true;
                            $rules['message'] = '请输入' . $information->getAttribute('name');
                            $rules['trigger'] = 'change';
                            if (in_array($information->getAttribute('type'), ['date', 'datetime'])) {
                                $rules['type'] = 'date';
                            } else {
                                $rules['type'] = 'string';
                            }
                        }
                        $information->setAttribute('rules', $rules);
                        $builder = ArticleInformationValue::query();
                        $builder->where('information_id', $information->getAttribute('id'));
                        $builder->where('article_id', $this->request->input('id'));
                        $value = $builder->first();
                        $information->setAttribute('value', $value instanceof ArticleInformationValue ? $value->getAttribute('value') : '');

                        return $information;
                    })->keyBy('id'));
                }
                $article->setRelation('category', $category);
            }
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
            $model->setAttribute('label', $model->getAttribute('title'));
            $model->setAttribute('value', $model->getAttribute('id'));
            $model->getRelation('children') instanceof Collection && $model->setRelation('children', $this->formatData($model->getRelation('children')));
            $model->getRelation('informations') instanceof Collection && $model->setRelation('informations', $model->getRelation('informations')->transform(function (ArticleInformation $information) {
                switch ($information->getAttribute('type')) {
                    case 'radio':
                        $information->setAttribute('opinions', explode(PHP_EOL, $information->getAttribute('opinions')));
                        break;
                }
                $rules = [];
                if ($information->getAttribute('required')) {
                    $rules['required'] = true;
                    $rules['message'] = '请输入' . $information->getAttribute('name');
                    $rules['trigger'] = 'change';
                    if (in_array($information->getAttribute('type'), ['date', 'datetime'])) {
                        $rules['type'] = 'date';
                    } else {
                        $rules['type'] = 'string';
                    }
                }
                $information->setAttribute('rules', $rules);
                $builder = ArticleInformationValue::query();
                $builder->where('information_id', $information->getAttribute('id'));
                $builder->where('article_id', $this->request->input('id'));
                $value = $builder->first();
                $information->setAttribute('value', $value instanceof ArticleInformationValue ? $value->getAttribute('value') : '');

                return $information;
            })->keyBy('id'));

            return $model;
        });
    }
}

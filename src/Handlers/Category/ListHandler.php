<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:34
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Notadd\Content\Models\ArticleCategory;
use Notadd\Content\Models\ArticleInformation;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class ListHandler.
 */
class ListHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'order'     => Rule::in([
                'asc',
                'desc',
            ]),
            'parent_id' => Rule::numeric(),
        ], [
            'parent_id.numeric' => '父级 ID 必须为数值',
        ]);
        $builder = ArticleCategory::query();
        $builder->with('children.children.children');
        $builder->with('informations');
        $builder->with('children.informations');
        $builder->with('children.children.informations');
        $builder->with('children.children.children.informations');
        $builder->whereNull('parent_id');
        $builder->orderBy('lft', $this->request->input('order', 'asc'));
        $this->withCode(200)->withData($this->formatData($builder->get()))->withMessage('content::category.fetch.success');
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
            $model->has('children') && $model->setRelation('children', $this->formatData($model->getRelation('children')));
            $model->has('informations') && $model->setRelation('informations', $model->getRelation('informations')->transform(function (ArticleInformation $information) {
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
                $information->setAttribute('value', '');

                return $information;
            })->keyBy('id'));

            return $model;
        });
    }
}

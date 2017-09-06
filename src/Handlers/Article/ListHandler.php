<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:31
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
 * Class FetchHandler.
 */
class ListHandler extends Handler
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'category_id'    => Rule::numeric(),
            'category_level' => Rule::boolean(),
            'order'          => Rule::in([
                'asc',
                'desc',
            ]),
            'page'           => Rule::numeric(),
            'paginate'       => Rule::numeric(),
            'trashed'        => Rule::boolean(),
        ], [
            'category_id.numeric'    => '分类 ID 必须为数值',
            'category_level.boolean' => '分类层级标识必须为数值',
            'order.in'               => '排序规则错误',
            'page.numeric'           => '当前页面必须为数值',
            'paginate.numeric'       => '分页数必须为数值',
            'trashed.boolean'        => '仅删除标识必须为布尔值',
        ]);
        $builder = Article::query();
        $builder->with('category.informations');
        $builder->with('category.parent.parent');
        if ($this->request->input('category_level', true)) {
            $id = $this->request->input('category_id', 0);
            $categories = collect([(int)$id]);

            if ($id == 4) {
                $categories = ArticleCategory::query()->where('parent_id', $id)->pluck('id')->toArray();
                array_push($categories, $id);
                $builder->whereIn('category_id', $categories);
            }elseif ($id == 0){
                ArticleCategory::query()
                    ->whereNull('parent_id')
                    ->get()
                    ->each(function (ArticleCategory $category) use ($categories) {
                        $categories->push($category->getAttribute('id'));
                        $children = ArticleCategory::query()
                            ->where('parent_id', $category->getAttribute('id'))
                            ->get();
                        $children->count() && $children->each(function (ArticleCategory $category) use ($categories) {
                            $categories->push($category->getAttribute('id'));
                            $children = ArticleCategory::query()
                                ->where('parent_id', $category->getAttribute('id'))
                                ->get();
                            $children->count() && $children->each(function (ArticleCategory $category) use ($categories) {
                                $categories->push($category->getAttribute('id'));
                            });
                        });
                    });
                $builder->whereIn('category_id', $categories->unique()->toArray());
            }else{
                $builder->whereIn('category_id', $categories->unique()->toArray());
            }
        } else {
            $builder->whereNull('category_id');
        }

        if ($this->request->has('keyword')) {
            $keyword = $this->request->input('keyword');
            $builder->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('content', 'like', '%' . $keyword . '%');
        }
        $builder->orderBy('is_sticky', 'desc')
            ->orderBy($this->request->input('sort', 'created_at'), $this->request->input('order', 'desc'));
        if ($this->request->input('trashed', false)) {
            $builder->onlyTrashed();
        }
        $pagination = $builder->paginate($this->request->input('paginate', 20));
        $this->withCode(200)->withData(collect($pagination->items())->transform(function (Article $article) {
            $category = $article->getRelation('category');
            if ($category instanceof Model) {
                $informations = $category->getRelation('informations');
                if ($informations instanceof Collection) {
                    $category->setRelation('informations', $informations->transform(function (ArticleInformation $information) use ($article) {
                        $builder = ArticleInformationValue::query();
                        $builder->where('information_id', $information->getAttribute('id'));
                        $builder->where('article_id', $article->getAttribute('id'));
                        $value = $builder->first();
                        $information->setAttribute('value', $value instanceof ArticleInformationValue ? $value->getAttribute('value') : '');

                        return $information;
                    })->keyBy('id'));
                }
                $article->setRelation('category', $category);
            }

            return $article;
        }))->withExtra([
            'pagination' => [
                'total'         => $pagination->total(),
                'per_page'      => $pagination->perPage(),
                'current_page'  => $pagination->currentPage(),
                'last_page'     => $pagination->lastPage(),
                'next_page_url' => $pagination->nextPageUrl(),
                'prev_page_url' => $pagination->previousPageUrl(),
                'from'          => $pagination->firstItem(),
                'to'            => $pagination->lastItem(),
            ],
        ])->withMessage('content::article.fetch.success');
    }
}

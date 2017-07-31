<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:31
 */
namespace Notadd\Content\Handlers\Article;

use Notadd\Content\Models\Article;
use Notadd\Content\Models\ArticleCategory;
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
        if ($this->request->has('category_id') && $this->request->input('category_level', true)) {
            $id = $this->request->input('category_id', 0);
            $categories = collect([(int)$id]);
            ArticleCategory::query()
                ->where('parent_id', $id)
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
        } else {
            $builder->where('category_id', $this->request->input('category_id', 0));
        }
        if ($this->request->has('keyword')) {
            $keyword = $this->request->input('keyword');
            $builder->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('content', 'like', '%' . $keyword . '%');
        }
        $builder->orderBy($this->request->input('sort', 'created_at'), $this->request->input('order', 'desc'));
        if ($this->request->input('trashed', false)) {
            $builder->onlyTrashed();
        }
        $pagination = $builder->paginate($this->request->input('paginate', 20));
        $this->withCode(200)->withData($pagination->items())->withExtra([
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

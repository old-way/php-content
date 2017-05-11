<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:31
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Container\Container;
use Notadd\Content\Models\Article;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * FetchHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Article $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.fetch.fail'));
        $this->messages->push($this->translator->trans('content::article.fetch.success'));
        $this->model = $article;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $pagination = $this->request->input('pagination') ?: 10;
        if ($this->request->input('only-no-category')) {
            $this->pagination = $this->model->newQuery()->where('category_id', 0)->paginate($pagination);
        } elseif ($id = $this->request->input('category')) {
            $categories = collect([(int)$id]);
            $this->container->make('log')->info('has category', $categories->toArray());
            (new Category())->newQuery()->where('parent_id', $id)->get()->each(function (Category $category) use (
                $categories
            ) {
                $categories->push($category->getAttribute('id'));
                $children = (new Category())->newQuery()->where('parent_id', $category->getAttribute('id'))->get();
                $children->count() && $children->each(function (Category $category) use ($categories) {
                    $categories->push($category->getAttribute('id'));
                    $children = (new Category())->newQuery()->where('parent_id', $category->getAttribute('id'))->get();
                    $children->count() && $children->each(function (Category $category) use ($categories) {
                        $categories->push($category->getAttribute('id'));
                    });
                });
            });
            $this->container->make('log')->info('get categories', $categories->toArray());
            $categories = $categories->unique();
            $this->container->make('log')->info('get categories', $categories->toArray());
            $this->pagination = $this->model->newQuery()->whereIn('category_id',
                $categories->toArray())->orderBy('created_at', 'desc')->paginate($pagination);
        } else {
            $search = $this->request->input('search');
            $trashed = $this->request->input('trashed');
            if ($trashed) {
                $this->pagination = $this->model->newQuery()->onlyTrashed()->orderBy('deleted_at',
                    'desc')->paginate($pagination);
            } else {
                if ($search) {
                    $this->pagination = $this->model->newQuery()->where('title', 'like',
                        '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')->orderBy('created_at',
                        'desc')->paginate($pagination);
                } else {
                    $this->pagination = $this->model->newQuery()->orderBy('created_at', 'desc')->paginate($pagination);
                }
            }
        }

        return $this->pagination->items();
    }

    /**
     * Make data to response with errors or messages.
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function toResponse()
    {
        $response = parent::toResponse();

        return $response->withParams([
            'pagination' => [
                'total'         => $this->pagination->total(),
                'per_page'      => $this->pagination->perPage(),
                'current_page'  => $this->pagination->currentPage(),
                'last_page'     => $this->pagination->lastPage(),
                'next_page_url' => $this->pagination->nextPageUrl(),
                'prev_page_url' => $this->pagination->previousPageUrl(),
                'from'          => $this->pagination->firstItem(),
                'to'            => $this->pagination->lastItem(),
            ],
        ]);
    }
}

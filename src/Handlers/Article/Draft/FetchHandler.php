<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 18:57
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleDraft;
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
     * ArticleFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     * @param \Illuminate\Container\Container     $container
     */
    public function __construct(
        ArticleDraft $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->model = $article;
    }

    /**
     * Http code.
     *
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $pagination = $this->request->input('pagination') ?: 10;
        $search = $this->request->input('search');
        $trashed = $this->request->input('trashed');
        if($trashed) {
            $this->pagination = $this->model->newQuery()->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($pagination);
        } else {
            if($search) {
                $this->pagination = $this->model->newQuery()->where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate($pagination);
            } else {
                $this->pagination = $this->model->newQuery()->orderBy('created_at', 'desc')->paginate($pagination);
            }
        }

        return $this->pagination->items();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::article.fetch.fail'),
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::article.fetch.success'),
        ];
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
                'total' => $this->pagination->total(),
                'per_page' => $this->pagination->perPage(),
                'current_page' => $this->pagination->currentPage(),
                'last_page' => $this->pagination->lastPage(),
                'next_page_url' => $this->pagination->nextPageUrl(),
                'prev_page_url' => $this->pagination->previousPageUrl(),
                'from' => $this->pagination->firstItem(),
                'to' => $this->pagination->lastItem(),
            ]
        ]);
    }
}

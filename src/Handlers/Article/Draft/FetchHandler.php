<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-17 18:57
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class FetchHandler.
 */
class FetchHandler extends Handler
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
        $pagination = $this->request->input('pagination') ?: 10;
        $search = $this->request->input('search');
        $trashed = $this->request->input('trashed');
        if($trashed) {
            $this->pagination = ArticleDraft::query()->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($pagination);
        } else {
            if($search) {
                $this->pagination = ArticleDraft::query()->where('title', 'like', '%' . $search . '%')->orWhere('content', 'like', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate($pagination);
            } else {
                $this->pagination = ArticleDraft::query()->orderBy('created_at', 'desc')->paginate($pagination);
            }
        }
        if ($this->pagination) {
            $this->success()
                ->withData($this->pagination->items())
                ->withMessage('content::article.fetch.success')
                ->withExtra([
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
}

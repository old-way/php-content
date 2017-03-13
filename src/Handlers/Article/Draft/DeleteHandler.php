<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 19:02
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class DeleteHandler.
 */
class DeleteHandler extends SetHandler
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * DeleteHandler constructor.
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
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $force = $this->request->input('force');
        $pagination = $this->request->input('pagination') ?: 10;
        $restore = $this->request->input('restore');
        if ($restore || $force) {
            $this->pagination = $this->model->newQuery()->onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($pagination);
        } else {
            $this->pagination = $this->model->newQuery()->orderBy('created_at', 'desc')->paginate($pagination);
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
        if ($this->request->input('force')) {
            return [
                $this->translator->trans('content::article.force.fail')
            ];
        } elseif ($this->request->input('restore')) {
            return [
                $this->translator->trans('content::article.restore.fail')
            ];
        } else {
            return [
                $this->translator->trans('content::article.delete.fail'),
            ];
        }
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $article = $this->model->newQuery()->withTrashed()->find($this->request->input('id'));
        if ($article === null) {
            return false;
        }
        $force = $this->request->input('force');
        $restore = $this->request->input('restore');
        if ($force) {
            $article->forceDelete();
            $this->messages = [
                $this->translator->trans('content::article.force.success')
            ];
        } elseif ($restore) {
            $article->restore();
            $this->messages = [
                $this->translator->trans('content::article.restore.success')
            ];
        } else {
            $article->delete();
            $this->messages = [
                $this->translator->trans('content::article.delete.success'),
            ];
        }

        return true;
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

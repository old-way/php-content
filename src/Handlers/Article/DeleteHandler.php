<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:32
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class ArticleDeleteHandler.
 */
class DeleteHandler extends SetHandler
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * ArticleDeleterHandler constructor.
     *
     * @param \Notadd\Content\Models\Article     $article
     * @param \Illuminate\Container\Container    $container
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Article $article,
        Container $container,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
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
        } elseif ($restore) {
            $article->restore();
        } else {
            $article->delete();
        }

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        if ($this->request->input('force')) {
            return [
                $this->translator->trans('content::article.force.success')
            ];
        } elseif ($this->request->input('restore')) {
            return [
                $this->translator->trans('content::article.restore.success')
            ];
        } else {
            return [
                $this->translator->trans('content::article.delete.success'),
            ];
        }
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

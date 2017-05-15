<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:34
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Notadd\Content\Models\Page;
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
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\Page     $page
     */
    public function __construct(
        Container $container,
        Page $page
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::page.delete.fail'));
        $this->messages->push($this->translator->trans('content::page.delete.success'));
        $this->model = $page;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $pagination = $this->request->input('pagination') ?: 10;
        $this->pagination = $this->model->newQuery()->orderBy('created_at', 'desc')->paginate($pagination);

        return $this->pagination->items();
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $page = $this->model->newQuery()->find($this->request->input('id'));
        if ($page === null) {
            return false;
        }
        $page->delete();

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
        if ($this->pagination) {
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
        } else {
            return $response;
        }
    }
}

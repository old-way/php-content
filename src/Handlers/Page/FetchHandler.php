<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:36
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\Page;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class PageFetcherHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * PageFinderHandler constructor.
     *
     * @param \Illuminate\Container\Container    $container
     * @param \Notadd\Content\Models\Page        $page
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        Container $container,
        Page $page,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->model = $page;
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
        $this->pagination = $this->model->newQuery()->orderBy('created_at', 'desc')->paginate($pagination);

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
            $this->translator->trans('content::page.fetch.fail'),
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
            $this->translator->trans('content::page.fetch.success'),
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

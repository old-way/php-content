<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 14:14
 */
namespace Notadd\Content\Handlers\Article\Information;

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
            'order'    => Rule::in([
                'asc',
                'desc',
            ]),
            'page'     => Rule::numeric(),
            'paginate' => Rule::numeric(),
        ], [
            'order.in'         => '排序规则错误',
            'page.numeric'     => '当前页面必须为数值',
            'paginate.numeric' => '分页数必须为数值',
        ]);
        $builder = ArticleInformation::query();
        if ($withs = $this->request->input('with', [])) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        $builder->orderBy($this->request->input('sort', 'order'), $this->request->input('order', 'desc'));
        $pagination = $builder->paginate($this->request->input('paginate', 20));
        $this->withCode(200)->withData($pagination->items())->withMessage('')->withExtra([
            'pagination' => [
                'count'    => $pagination->total(),
                'current'  => $pagination->currentPage(),
                'from'     => $pagination->firstItem(),
                'next'     => $pagination->nextPageUrl(),
                'paginate' => $this->request->input('paginate', 20),
                'prev'     => $pagination->previousPageUrl(),
                'to'       => $pagination->lastItem(),
                'total'    => $pagination->lastPage(),
            ],
        ]);
    }
}

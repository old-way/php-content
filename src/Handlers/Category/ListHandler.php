<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-15 20:34
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
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
            'order'     => Rule::in([
                'asc',
                'desc',
            ]),
            'parent_id' => Rule::numeric(),
        ], [
            'parent_id.numeric' => '父级 ID 必须为数值',
        ]);
        $builder = ArticleCategory::query();
        $builder->with('children.children.children');
        // $builder->where('parent_id', $this->request->input('parent_id', 0));
        $builder->whereNull('parent_id');
        $builder->orderBy($this->request->input('sort', 'order_id'), $this->request->input('order', 'asc'));
        $this->withCode(200)->withData($builder->get())->withMessage('content::category.fetch.success');
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-09 16:51
 */
namespace Notadd\Content\Handlers\Category;

use Notadd\Content\Models\ArticleCategory;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class SortHandler.
 */
class SortHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        $data = collect($this->request->input('data'));
        $data->each(function ($item, $key) {
            $id = $item['id'];
            $category = ArticleCategory::query()->find($id);
            $category->update([
                'parent_id' => 0,
                'order_id'  => $key,
            ]);
            $children = collect($item['children']);
            if ($children->count()) {
                $children->each(function ($item, $key) use ($id) {
                    $parentId = $id;
                    $id = $item['id'];
                    $category = ArticleCategory::query()->find($id);
                    $category->update([
                        'parent_id' => $parentId,
                        'order_id'  => $key,
                    ]);
                    $children = collect($item['children']);
                    if ($children->count()) {
                        $children->each(function ($item, $key) use ($id) {
                            $parentId = $id;
                            $id = $item['id'];
                            $category = ArticleCategory::query()->find($id);
                            $category->update([
                                'parent_id' => $parentId,
                                'order_id'  => $key,
                            ]);
                        });
                    }
                });
            }
        });
        $this->withCode(200)->withMessage('content::category.sort.success');
    }
}

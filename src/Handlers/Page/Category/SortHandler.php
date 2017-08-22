<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:50
 */
namespace Notadd\Content\Handlers\Page\Category;

use Notadd\Content\Models\PageCategory;
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
        $this->beginTransaction();
        try{
            $data->each(function ($item, $key) {
                $id = $item['id'];
                $category = PageCategory::query()->find($id);
                $category->makeRoot();
                $children = collect($item['children']);
                if ($children->count()) {
                    $children->each(function ($item, $key) use ($id) {
                        $parentId = $id;
                        $id = $item['id'];
                        $parent_category = PageCategory::query()->find($parentId);
                        $child_category = PageCategory::query()->find($id);
                        $child_category->makeChildOf($parent_category);
                        $children = collect($item['children']);
                        if ($children->count()) {
                            $children->each(function ($item, $key) use ($id) {
                                $parentId = $id;
                                $id = $item['id'];
                                $parent_category = PageCategory::query()->find($parentId);
                                $child_category = PageCategory::query()->find($id);
                                $child_category->makeChildOf($parent_category);
                            });
                        }
                    });
                }
            });
        }catch(Exception $e){
            $this->rollBackTransaction();
            $message = $e->getMessage();
            $this->withCode(500)->withMessage($message);
        }
        $this->commitTransaction();
        $this->withCode(200)->withMessage('content::category.sort.success');
    }
}

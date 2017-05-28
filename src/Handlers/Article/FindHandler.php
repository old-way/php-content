<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Support\Collection;
use Notadd\Content\Models\Article;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\Handler;

/**
 * Class FindHandler.
 */
class FindHandler extends Handler
{
    /**
     * @param                                $id
     * @param \Illuminate\Support\Collection $data
     */
    protected function loopCategory($id, Collection $data)
    {
        $parent = (new Category())->newQuery()->find($id);
        if ($parent) {
            $data->prepend($parent->getAttribute('id'));
            $parent->getAttribute('parent_id') && $this->loopCategory($parent->getAttribute('parent_id'), $data);
        }
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $article = Article::query()->with('category')->find($this->request->input('id'));
        $category = $article->getAttribute('category');
        if ($category) {
            $data = new Collection();
            $this->loopCategory($article->getAttribute('category_id'), $data);
            $article->setAttribute('category', $category->getAttributes());
            $article->setAttribute('category_path', $data->toArray());
        }
        $this->success()->withData($article->getAttributes())->withMessage('content::article.find.success');
    }
}

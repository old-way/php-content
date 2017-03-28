<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Article;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Notadd\Content\Models\Article;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class FindHandler.
 */
class FindHandler extends DataHandler
{
    /**
     * FindHandler constructor.
     *
     * @param \Notadd\Content\Models\Article  $article
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Article $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.find.fail'));
        $this->messages->push($this->translator->trans('content::article.find.success'));
        $this->model = $article;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        $article = $this->model->newQuery()->with('category')->find($this->request->input('id'));
        $category = $article->getAttribute('category');
        if ($category) {
            $data = new Collection();
            $this->loopCategory($article->getAttribute('category_id'), $data);
            $article->setAttribute('category', $category->getAttributes());
            $article->setAttribute('category_path', $data->toArray());
        }

        return $article->getAttributes();
    }

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
}

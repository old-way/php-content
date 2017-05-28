<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * CreateHandler constructor.
     *
     * @param \Notadd\Content\Models\Category $category
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Category $category,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.find.fail'));
        $this->messages->push($this->translator->trans('content::article.find.success'));
        $this->model = $category;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return $this->model->structure();
    }

    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'alias' => 'required|regex:/^[a-zA-Z\pN_-]+$/u|unique:categories',
            'title' => 'required',
        ], [
            'alias.required' => '必须填写分类别名',
            'alias.regex' => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.unique' => '分类别名已被占用',
            'title.required' => '必须填写分类标题',
        ]);
        $this->model->newQuery()->create([
            'alias'            => $this->request->input('alias'),
            'background_color' => $this->request->input('background_color'),
            'background_image' => $this->request->input('background_image'),
            'description'      => $this->request->input('description'),
            'enabled'          => $this->request->input('enabled', 1),
            'order_id'         => $this->request->input('order_id', 0),
            'pagination'       => $this->request->input('pagination'),
            'parent_id'        => $this->request->input('parent_id', 0),
            'seo_title'        => $this->request->input('seo_title'),
            'seo_keyword'      => $this->request->input('seo_keyword'),
            'seo_description'  => $this->request->input('seo_description'),
            'title'            => $this->request->input('name'),
            'top_image'        => $this->request->input('top_image'),
            'type'             => $this->request->input('type') ?: 'normal',
        ]);

        return true;
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-24 18:33
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Container\Container;
use Illuminate\Validation\Rule;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * EditHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::category.update.fail'));
        $this->messages->push($this->translator->trans('content::category.update.success'));
        $this->model = new Category();
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
            'alias' => [
                'required',
                'regex:/^[a-zA-Z\pN_-]+$/u',
                Rule::unique('categories')->ignore($this->request->input('id'), 'id'),
            ],
            'title' => 'required',
        ], [
            'alias.required' => '必须填写分类别名',
            'alias.regex' => '分类别名只能包含英文字母、数字、破折号（ - ）以及下划线（ _ ）',
            'alias.unique' => '分类别名已被占用',
            'title.required' => '必须填写分类标题',
        ]);
        $this->container->make('log')->info('edit category', $this->request->all());
        $category = $this->model->newQuery()->find($this->request->input('id'));
        if ($category) {
            $category->update([
                'alias'            => $this->request->input('alias'),
                'background_color' => $this->request->input('background_color'),
                'background_image' => $this->request->input('background_image'),
                'description'      => $this->request->input('description'),
                'enabled'          => $this->request->input('enabled'),
                'pagination'       => $this->request->input('pagination'),
                'seo_title'        => $this->request->input('seo_title'),
                'seo_keyword'      => $this->request->input('seo_keyword'),
                'seo_description'  => $this->request->input('seo_description'),
                'top_image'        => $this->request->input('top_image'),
                'title'            => $this->request->input('name'),
                'type'             => $this->request->input('type') ?: 'normal',
            ]);

            return true;
        }

        return false;
    }
}

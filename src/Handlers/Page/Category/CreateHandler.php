<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-15 14:45
 */
namespace Notadd\Content\Handlers\Page\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\PageCategory;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CategoryHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * CategoryCreatorHandler constructor.
     *
     * @param \Illuminate\Container\Container     $container
     * @param \Notadd\Content\Models\PageCategory $category
     */
    public function __construct(
        Container $container,
        PageCategory $category
    ) {
        parent::__construct($container);
        $this->model = $category;
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
        return $this->model->structure();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::category.create.fail'),
        ];
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
            'title' => 'required',
            'alias' => 'required|alpha_dash|unique:page_categories',
        ]);
        $this->id = $this->model->create([
            'alias'            => $this->request->input('alias'),
            'background_color' => $this->request->input('background_color'),
            'background_image' => $this->request->input('background_image'),
            'description'      => $this->request->input('description'),
            'enabled'          => 1,
            'order_id'         => 0,
            'pagination'       => $this->request->input('pagination'),
            'parent_id'        => 0,
            'seo_title'        => $this->request->input('seo_title'),
            'seo_keyword'      => $this->request->input('seo_keyword'),
            'seo_description'  => $this->request->input('seo_description'),
            'title'            => $this->request->input('name'),
            'type'             => $this->request->input('type', 'normal'),
            'top_image'        => $this->request->input('top_image'),
        ]);

        return true;
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::category.create.success'),
        ];
    }
}

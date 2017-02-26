<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Category;

use Illuminate\Container\Container;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CategoryHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * CategoryCreatorHandler constructor.
     *
     * @param \Notadd\Content\Models\Category $category
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(
        Category $category,
        Container $container
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
     */
    public function execute()
    {
        $this->model->create([
            'title'            => $this->request->input('name'),
            'alias'            => $this->request->input('alias'),
            'description'      => $this->request->input('description'),
            'type'             => $this->request->input('type') ?: 'normal',
            'background_color' => $this->request->input('background_color'),
            'seo_title'        => $this->request->input('seo_title'),
            'seo_keyword'      => $this->request->input('seo_keyword'),
            'seo_description'  => $this->request->input('seo_description'),
            'background_image' => $this->request->input('background_image'),
            'top_image'        => $this->request->input('top_image'),
            'pagination'       => $this->request->input('pagination'),
            'parent_id'        => 0,
            'enabled'          => 1,
            'order_id'         => 0,
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

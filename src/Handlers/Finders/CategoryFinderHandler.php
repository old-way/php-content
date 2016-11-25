<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-24 18:50
 */
namespace Notadd\Content\Handlers\Finders;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Notadd\Content\Models\Category;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class CategoryFindHandler.
 */
class CategoryFinderHandler extends DataHandler
{
    /**
     * @var \Notadd\Content\Models\Category
     */
    protected $category;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * CategoryFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\Category $category
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Http\Request        $request
     */
    public function __construct(Category $category, Container $container, Request $request)
    {
        parent::__construct($container);
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * @return array
     */
    public function data()
    {
        $category = $this->category->newQuery()->find($this->request->input('id'));

        return $category->getAttributes();
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

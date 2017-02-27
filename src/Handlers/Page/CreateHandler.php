<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:28
 */
namespace Notadd\Content\Handlers\Page;

use Illuminate\Container\Container;
use Notadd\Content\Models\Page;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * CreateHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Models\Page     $page
     */
    public function __construct(
        Container $container,
        Page $page
    ) {
        parent::__construct($container);
        $this->model = $page;
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
        return [
            'id' => $this->id,
        ];
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::page.create.fail'),
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
            'alias' => 'required|alpha_dash|unique:pages',
        ], [
            'alias.required' => '必须填写页面别名',
            'alias.alpha_dash' => '页面别名只能由字母、数字和斜杠组成',
            'alias.unique' => '页面别名已被占用',
            'title.required' => '必须填写页面标题',
        ]);
        $this->model = $this->model->create([
            'alias'       => $this->request->input('alias'),
            'category_id' => $this->request->input('category_id', 0),
            'content'     => $this->request->input('content'),
            'enabled'     => $this->request->input('enabled'),
            'order_id'    => $this->request->input('order_id', 0),
            'parent_id'   => $this->request->input('parent_id', 0),
            'title'       => $this->request->input('title'),
        ]);
        $this->id = $this->model->getAttribute('id');

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
            $this->translator->trans('content::page.create.success'),
        ];
    }
}

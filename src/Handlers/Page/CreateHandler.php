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
 * Class PageHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * PageCreatorHandler constructor.
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
        ]);
        $this->model = $this->model->create([
            'alias'       => $this->request->input('alias'),
            'category_id' => $this->request->input('category_id'),
            'content'     => $this->request->input('content'),
            'enabled'     => $this->request->input('enabled'),
            'parent_id'   => 0,
            'title'       => $this->request->input('title'),
            'order_id'    => 0,
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

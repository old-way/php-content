<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:14
 */
namespace Notadd\Content\Handlers\Category\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\CategoryTemplate;
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
     * @param \Notadd\Content\Models\CategoryTemplate $categoryTemplate
     * @param \Illuminate\Container\Container         $container
     */
    public function __construct(
        CategoryTemplate $categoryTemplate,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::category_template.create.fail'));
        $this->messages->push($this->translator->trans('content::category_template.create.success'));
        $this->model = $categoryTemplate;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->id = $this->model->newQuery()->create($this->request->all());

        return true;
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:19
 */
namespace Notadd\Content\Handlers\Category\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\CategoryType;
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
     * @param \Notadd\Content\Models\CategoryType $categoryType
     * @param \Illuminate\Container\Container     $container
     */
    public function __construct(
        CategoryType $categoryType,
        Container $container
    ) {
        parent::__construct($container);
        $this->model = $categoryType;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::category_type.create.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->id = $this->model->create($this->request->all());

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
            $this->translator->trans('content::category_type.create.success'),
        ];
    }
}

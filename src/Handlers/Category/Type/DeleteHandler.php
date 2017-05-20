<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:20
 */
namespace Notadd\Content\Handlers\Category\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\CategoryType;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class DeleteHandler.
 */
class DeleteHandler extends SetHandler
{
    /**
     * DeleteHandler constructor.
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
            $this->translator->trans('content::category_type.delete.fail'),
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $categoryType = $this->model->newQuery()->find($this->request->input('id'));
        if ($categoryType === null) {
            return false;
        }
        $categoryType->delete();

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
            $this->translator->trans('content::category_type.delete.success'),
        ];
    }
}

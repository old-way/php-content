<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-15 20:35
 */
namespace Notadd\Content\Handlers\Category\Type;

use Illuminate\Container\Container;
use Notadd\Content\Models\CategoryType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class CategoryTypeFetcherHandler.
 */
class FetchHandler extends DataHandler
{
    /**
     * CategoryTypeFinderHandler constructor.
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
        if($this->hasFilter) {
            return $this->model->get();
        } else {
            return $this->model->all();
        }
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans('content::category_type.fetch.fail'),
        ];
    }

    /**
     * Messages for handler.
     *
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans('content::category_type.fetch.success'),
        ];
    }
}

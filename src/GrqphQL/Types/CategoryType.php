<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-11-07 18:21
 */
namespace Notadd\Content\GrqphQL\Types;

use Notadd\Foundation\GraphQL\Abstracts\Type as AbstractType;

/**
 * Class CategoryType.
 */
class CategoryType extends AbstractType
{
    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * @return string
     */
    public function name()
    {
        return 'category';
    }
}

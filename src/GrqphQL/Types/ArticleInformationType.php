<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-11-08 14:03
 */
namespace Notadd\Content\GrqphQL\Types;

use Notadd\Foundation\GraphQL\Abstracts\Type;

/**
 * Class ArticleInformationType.
 */
class ArticleInformationType extends Type
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
        return 'articleInformation';
    }
}

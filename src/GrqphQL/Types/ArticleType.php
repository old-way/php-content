<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-11-07 17:14
 */
namespace Notadd\Content\GrqphQL\Types;

use Notadd\Foundation\GraphQL\Abstracts\Type as AbstractType;

/**
 * Class ArticleType.
 */
class ArticleType extends AbstractType
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
        return 'article';
    }
}

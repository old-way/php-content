<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:42
 */
namespace Notadd\Content\Entities;

use Notadd\Foundation\Flow\Abstracts\Entity;

/**
 * Class ArticleCategory.
 */
class ArticleCategory extends Entity
{
    /**
     * @return string
     */
    public function name()
    {
        return 'content.article.category';
    }

    /**
     * @return array
     */
    public function places()
    {
        return [];
    }

    /**
     * @return array
     */
    public function transitions()
    {
        return [];
    }
}
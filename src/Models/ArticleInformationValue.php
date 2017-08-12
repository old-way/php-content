<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 13:26
 */

namespace Notadd\Content\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class ArticleInformationValue.
 */
class ArticleInformationValue extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'article_id',
        'category_id',
        'information_id',
        'value',
    ];

    /**
     * @var string
     */
    protected $table = 'content_article_information_values';
}

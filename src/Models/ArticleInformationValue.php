<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 13:26
 */

namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Database\Model;

/**
 * Class ArticleInformationValue.
 */
class ArticleInformationValue extends Model
{
    use SoftDeletes;

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

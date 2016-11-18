<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 15:31
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category.
 */
class Category extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'alias',
        'description',
        'type',
        'background_color',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'background_image',
        'top_image',
        'pagination',
        'enabled',
        'deleted_at'
    ];
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 15:30
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Page.
 */
class Page extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'thumb_image',
        'alias',
        'keyword',
        'description',
        'template',
        'content',
        'enabled',
        'order_id',
        'hits',
        'deleted_at'
    ];
}

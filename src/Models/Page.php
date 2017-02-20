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
        'alias',
        'category_id',
        'content',
        'deleted_at',
        'description',
        'enabled',
        'hits',
        'keyword',
        'order_id',
        'parent_id',
        'thumb_image',
        'template',
        'title',
    ];

    /**
     * Relation of category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(PageCategory::class);
    }
}

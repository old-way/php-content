<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:30
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Database\Model;

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
     * @var string
     */
    protected $table = 'content_pages';

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

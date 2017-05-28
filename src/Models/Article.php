<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:30
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Article.
 */
class Article extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'created_at',
        'title',
        'author',
        'source_author',
        'source_link',
        'content',
        'keyword',
        'description',
        'thumb_image',
        'user_id',
        'hits',
        'is_hidden',
        'is_sticky',
    ];

    /**
     * Relation of category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

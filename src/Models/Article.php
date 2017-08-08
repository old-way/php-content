<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:30
 */
namespace Notadd\Content\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Database\Model;

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
        'author',
        'category_id',
        'content',
        'created_at',
        'description',
        'flow_marketing',
        'hits',
        'is_hidden',
        'is_sticky',
        'keyword',
        'source_author',
        'source_link',
        'thumb_image',
        'title',
        'user_id',
    ];

    /**
     * @var array
     */
    protected $setters = [
        'category_id' => 'null|0',
        'is_hidden'   => 'null|0',
        'is_sticky'   => 'null|0',
    ];

    /**
     * @var string
     */
    protected $table = 'content_articles';

    /**
     * Relation of category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    /**
     * @param $value
     */
    public function setCreatedAtAttribute($value)
    {
        if ($value) {
            $this->attributes['created_at'] = Carbon::createFromTimestamp(strtotime($value));
        }
    }
}

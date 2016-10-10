<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 15:30
 */
namespace Notadd\Content\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Article
 * @package Notadd\Content\Models
 */
class Article extends Model {
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'from_author',
        'from_url',
        'content',
        'keyword',
        'description',
        'thumb_image',
        'user_id',
        'hits',
        'is_sticky',
        'deleted_at'
    ];
}
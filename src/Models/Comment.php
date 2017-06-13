<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-18 16:24
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment.
 */
class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'log_id',
        'user_id',
        'action',
        'date',
        'post_id',
        'thread_id',
        'thread_key',
        'author_id',
        'author_name',
        'author_email',
        'author_url',
        'author_key',
        'ip',
        'created_at',
        'message',
        'parent_id',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'content_comments';
}

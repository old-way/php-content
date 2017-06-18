<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-18 16:24
 */
namespace Notadd\Content\Models;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Flow\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class Comment.
 */
class ArticleComment extends Model
{
    use HasFlow;

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

    /**
     * Definition of name for flow.
     *
     * @return string
     */
    public function name()
    {
        // TODO: Implement name() method.
    }

    /**
     * Definition of places for flow.
     *
     * @return array
     */
    public function places()
    {
        // TODO: Implement places() method.
    }

    /**
     * Definition of transitions for flow.
     *
     * @return array
     */
    public function transitions()
    {
        // TODO: Implement transitions() method.
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    public function guardTransition(GuardEvent $event)
    {
        // TODO: Implement guardTransition() method.
    }
}

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
use Notadd\Foundation\Database\Traits\HasFlow;
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
        'action',
        'author_email',
        'author_id',
        'author_key',
        'author_name',
        'author_url',
        'created_at',
        'date',
        'flow_marketing',
        'ip',
        'log_id',
        'message',
        'parent_id',
        'user_id',
        'post_id',
        'thread_id',
        'thread_key',
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

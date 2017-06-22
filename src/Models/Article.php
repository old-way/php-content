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
use Notadd\Foundation\Database\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;

/**
 * Class Article.
 */
class Article extends Model
{
    use HasFlow, SoftDeletes;

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
     * Definition of name for flow.
     *
     * @return string
     */
    public function name()
    {
        return 'content.article';
    }

    /**
     * Definition of places for flow.
     *
     * @return array
     */
    public function places()
    {
        return [
            'create',
            'created',
            'edit',
            'edited',
            'publish',
            'published',
            'remove',
            'removed',
            'review',
            'reviewed',
        ];
    }

    /**
     * Definition of transitions for flow.
     *
     * @return array
     */
    public function transitions()
    {
        return [
            new Transition('create', 'create', 'created'),
            new Transition('need_to_edit', ['created', 'edited'], 'edit'),
            new Transition('edit', 'edit', 'edited'),
            new Transition('need_to_remove', ['created', 'edited'], 'remove'),
            new Transition('remove', 'remove', 'removed'),
            new Transition('wait_to_review', ['created', 'edit'], 'review'),
            new Transition('review', 'review', 'reviewed'),
            new Transition('need_to_publish', 'reviewed', 'publish'),
            new Transition('publish', 'publish', 'publish'),
        ];
    }

    /**
     * Guard a transition.
     *
     * @param \Symfony\Component\Workflow\Event\GuardEvent $event
     */
    public function guardTransition(GuardEvent $event)
    {
        switch ($event->getTransition()->getName()) {
            case 'create':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'need_to_edit':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'edit':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'need_to_remove':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'remove':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'wait_to_review':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'review':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'need_to_publish':
                $this->blockTransition($event, $this->permission(''));
                break;
            case 'publish':
                $this->blockTransition($event, $this->permission(''));
                break;
            default:
                $event->setBlocked(true);
        }
    }
}

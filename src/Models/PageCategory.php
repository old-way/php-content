<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-15 14:41
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Database\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;
use Baum\Node;

/**
 * Class PageCategory.
 */
class PageCategory extends Node
{
    use HasFlow, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'alias',
        'background_color',
        'background_image',
        'deleted_at',
        'description',
        'enabled',
        'flow_marketing',
        'order_id',
        'parent_id',
        'pagination',
        'title',
        'type',
        'seo_description',
        'seo_keyword',
        'seo_title',
        'top_image',
    ];

    /**
     * @var string
     */
    protected $table = 'content_page_categories';

    /**
     * Get category structure list.
     *
     * @return array
     */
    public function structure() {
        $list = $this->newQuery()->whereNull('parent_id')->orderBy('lft', 'desc')->get();
        $list->transform(function (PageCategory $category) {
            $children = $category->newQuery()->where('parent_id', $category->getAttribute('id'))->orderBy('lft', 'desc')->get();
            $children->transform(function (PageCategory $category) {
                $children = $category->newQuery()->where('parent_id', $category->getAttribute('id'))->orderBy('lft', 'desc')->get();
                $category->setAttribute('children', $children);

                return $category;
            });
            $category->setAttribute('children', $children);

            return $category;
        });

        return $list->toArray();
    }

    /**
     * Definition of name for flow.
     *
     * @return string
     */
    public function name()
    {
        return 'content.page.category';
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
            'remove',
            'removed',
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
            default:
                $event->setBlocked(true);
        }
    }
}

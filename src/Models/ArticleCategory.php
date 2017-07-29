<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:31
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Database\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\Transition;

/**
 * Class Category.
 */
class ArticleCategory extends Model
{
    use HasFlow, SoftDeletes;

    /**
     * @var array
     */
    protected $appends = [
        'breadcrumb',
        'path',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'alias',
        'background_color',
        'background_image',
        'enabled',
        'deleted_at',
        'description',
        'flow_marketing',
        'order_id',
        'pagination',
        'parent_id',
        'seo_description',
        'seo_keyword',
        'seo_title',
        'title',
        'top_image',
        'type',
    ];

    /**
     * @param $value
     *
     * @return string
     */
    public function getBreadcrumbAttribute($value)
    {
        $paths = new Collection([$this]);
        $one = static::query()->find($this->attributes['parent_id']);
        if ($this->attributes['parent_id'] && $one instanceof ArticleCategory) {
            $paths->prepend($one);
            $two = static::query()->find($one->getAttribute('parent_id'));
            if ($one->getAttribute('parent_id') && $two instanceof ArticleCategory) {
                $paths->prepend($two);
            }
        }
        $paths->transform(function (ArticleCategory $category) {
            return $category->getAttribute('name');
        });

        return $paths->implode(' / ');
    }

    /**
     * @param $value
     *
     * @return array
     */
    public function getPathAttribute($value)
    {
        $paths = new Collection([$this]);
        $one = static::query()->find($this->attributes['parent_id']);
        if ($this->attributes['parent_id'] && $one instanceof ArticleCategory) {
            $paths->prepend($one);
            $two = static::query()->find($one->getAttribute('parent_id'));
            if ($one->getAttribute('parent_id') && $two instanceof ArticleCategory) {
                $paths->prepend($two);
            }
        }

        return $paths->toArray();
    }

    /**
     * @var string
     */
    protected $table = 'content_article_categories';

    /**
     * Get category structure list.
     *
     * @return array
     */
    public function structure() {
        $list = $this->newQuery()->where('parent_id', 0)->orderBy('order_id', 'asc')->get();
        $list->transform(function (ArticleCategory $category) {
            $children = $category->newQuery()->where('parent_id', $category->getAttribute('id'))->orderBy('order_id', 'asc')->get();
            $children->transform(function (ArticleCategory $category) {
                $children = $category->newQuery()->where('parent_id', $category->getAttribute('id'))->orderBy('order_id', 'asc')->get();
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
        return 'content.article.category';
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

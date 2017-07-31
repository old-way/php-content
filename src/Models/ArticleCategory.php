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
     * @var array
     */
    protected $setters = [
        'enabled'    => 'empty|1',
        'order_id'   => 'empty|0',
        'parent_id'  => 'empty|0',
        'pagination' => 'empty|20',
        'type'       => 'empty|normal',
    ];

    /**
     * @var string
     */
    protected $table = 'content_article_categories';

    /**
     * @param $value
     *
     * @return string
     */
    public function getBreadcrumbAttribute($value)
    {
        $paths = new Collection([$this]);
        if ($this->attributes['parent_id'] && ($one = static::query()->find($this->attributes['parent_id'])) instanceof ArticleCategory) {
            $paths->prepend($one);
            if ($one->getAttribute('parent_id') && ($two = static::query()->find($one->getAttribute('parent_id'))) instanceof ArticleCategory) {
                $paths->prepend($two);
            }
        }
        $paths->transform(function (ArticleCategory $category) {
            return $category->getAttribute('title');
        });

        return $paths->implode(' / ');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(ArticleCategory::class, 'parent_id');
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
}

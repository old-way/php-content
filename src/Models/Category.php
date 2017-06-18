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
use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Flow\Traits\HasFlow;
use Symfony\Component\Workflow\Event\GuardEvent;

/**
 * Class Category.
 */
class Category extends Model
{
    use HasFlow, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'alias',
        'description',
        'type',
        'background_color',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'background_image',
        'top_image',
        'pagination',
        'enabled',
        'order_id',
        'deleted_at'
    ];

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
        $list->transform(function (Category $category) {
            $children = $category->newQuery()->where('parent_id', $category->getAttribute('id'))->orderBy('order_id', 'asc')->get();
            $children->transform(function (Category $category) {
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

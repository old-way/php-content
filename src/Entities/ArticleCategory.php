<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:42
 */
namespace Notadd\Content\Entities;

use Notadd\Foundation\Flow\Abstracts\Entity;
use Symfony\Component\Workflow\Transition;

/**
 * Class ArticleCategory.
 */
class ArticleCategory extends Entity
{
    /**
     * @return string
     */
    public function name()
    {
        return 'content.article.category';
    }

    /**
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
     * @return array
     */
    public function transitions()
    {
        return [
            new Transition('create', 'create', 'created'),
            new Transition('edit', 'edit', 'edited'),
            new Transition('remove', 'remove', 'removed'),
        ];
    }

    /**
     * Announce a transition.
     */
    public function announce()
    {
        // TODO: Implement announce() method.
    }

    /**
     * Enter a place.
     */
    public function enter()
    {
        // TODO: Implement enter() method.
    }

    /**
     * Entered a place.
     */
    public function entered()
    {
        // TODO: Implement entered() method.
    }

    /**
     * Guard a transition.
     */
    public function guard()
    {
        // TODO: Implement guard() method.
    }

    /**
     * Leave a place.
     */
    public function leave()
    {
        // TODO: Implement leave() method.
    }

    /**
     * Into a transition.
     */
    public function transition()
    {
        // TODO: Implement transition() method.
    }
}
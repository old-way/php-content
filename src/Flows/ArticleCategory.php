<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-06-01 18:42
 */
namespace Notadd\Content\Flows;

use Notadd\Foundation\Flow\Abstracts\Entity;
use Symfony\Component\Workflow\Event\GuardEvent;
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
    public function guard(GuardEvent $event)
    {
        switch ($event->getTransition()->getName()) {
            case 'create':
                $this->block($event, $this->permission(''));
                break;
            case 'need_to_edit':
                $this->block($event, $this->permission(''));
                break;
            case 'edit':
                $this->block($event, $this->permission(''));
                break;
            case 'need_to_remove':
                $this->block($event, $this->permission(''));
                break;
            case 'remove':
                $this->block($event, $this->permission(''));
                break;
            default:
                $event->setBlocked(true);
        }
    }
}
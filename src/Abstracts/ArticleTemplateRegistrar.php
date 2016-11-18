<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-10 16:53
 */
namespace Notadd\Content\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Content\Events\RegisterArticleTemplate as RegisterTemplateEvent;
use Notadd\Content\Managers\ArticleManager;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;

/**
 * Class AbstractArticleTemplateRegistrar.
 */
abstract class ArticleTemplateRegistrar extends EventSubscriber
{
    /**
     * @var \Notadd\Content\Managers\ArticleManager
     */
    protected $manager;

    /**
     * AbstractArticleTemplateRegistrar constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Illuminate\Events\Dispatcher           $events
     * @param \Notadd\Content\Managers\ArticleManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, ArticleManager $manager)
    {
        parent::__construct($container, $events);
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    protected function getEvent()
    {
        return RegisterTemplateEvent::class;
    }

    /**
     * @return void
     */
    abstract public function handle();
}

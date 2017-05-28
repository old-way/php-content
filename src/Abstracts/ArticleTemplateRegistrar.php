<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
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
     * Name of event.
     *
     * @return mixed
     */
    protected function getEvent()
    {
        return RegisterTemplateEvent::class;
    }

    /**
     * Registrar handler.
     *
     * @return void
     */
    abstract public function handle();
}

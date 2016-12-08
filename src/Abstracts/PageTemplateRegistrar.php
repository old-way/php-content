<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-10 17:12
 */
namespace Notadd\Content\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Content\Events\RegisterPageTemplate as RegisterTemplateEvent;
use Notadd\Content\Managers\PageManager;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;

/**
 * Class PageTemplateRegistrar.
 */
abstract class PageTemplateRegistrar extends EventSubscriber
{
    /**
     * @var \Notadd\Content\Managers\PageManager
     */
    protected $manager;

    /**
     * AbstractPageTemplateRegistrar constructor.
     *
     * @param \Illuminate\Container\Container      $container
     * @param \Illuminate\Events\Dispatcher        $events
     * @param \Notadd\Content\Managers\PageManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, PageManager $manager)
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

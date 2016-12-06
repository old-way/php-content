<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-10 17:22
 */
namespace Notadd\Content\Abstracts;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Notadd\Content\Events\RegisterCategoryType as RegisterTypeEvent;
use Notadd\Content\Managers\CategoryManager;
use Notadd\Foundation\Event\Abstracts\EventSubscriber;

/**
 * Class CategoryTypeRegistrar.
 */
abstract class CategoryTypeRegistrar extends EventSubscriber
{
    /**
     * @var \Notadd\Content\Managers\CategoryManager
     */
    protected $manager;

    /**
     * CategoryTypeRegistrar constructor.
     *
     * @param \Illuminate\Container\Container          $container
     * @param \Illuminate\Events\Dispatcher            $events
     * @param \Notadd\Content\Managers\CategoryManager $manager
     */
    public function __construct(Container $container, Dispatcher $events, CategoryManager $manager)
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
        return RegisterTypeEvent::class;
    }

    /**
     * TODO: Method handle Description
     *
     * @return void
     */
    abstract public function handle();
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 15:38
 */
namespace Notadd\Content\Managers;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Support\Collection;
use Notadd\Content\Templates\PageTemplate;
use Notadd\Content\Types\PageType;

/**
 * Class PageManager.
 */
class PageManager
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $templates;
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $type;

    /**
     * Article constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher   $events
     */
    public function __construct(Container $container, EventsDispatcher $events)
    {
        $this->container = $container;
        $this->events = $events;
        $this->templates = new Collection();
        $this->type = new Collection();
    }

    /**
     * @param string                                 $name
     * @param \Notadd\Content\Templates\PageTemplate $template
     */
    public function registerTemplate($name, PageTemplate $template)
    {
        $this->templates->put($name, $template);
    }

    /**
     * @param string                         $name
     * @param \Notadd\Content\Types\PageType $type
     */
    public function registerType($name, PageType $type)
    {
        $this->type->put($name, $type);
    }
}

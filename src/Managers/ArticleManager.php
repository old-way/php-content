<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:38
 */
namespace Notadd\Content\Managers;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Support\Collection;
use Notadd\Content\Templates\ArticleTemplate;
use Notadd\Content\Types\ArticleType;

/**
 * Class ArticleManager.
 */
class ArticleManager
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
     * ArticleManager constructor.
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
     * Register a article template.
     *
     * @param                                           $name
     * @param \Notadd\Content\Templates\ArticleTemplate $template
     */
    public function registerTemplate($name, ArticleTemplate $template)
    {
        $this->templates->put($name, $template);
    }

    /**
     * Register a article type.
     *
     * @param                                   $name
     * @param \Notadd\Content\Types\ArticleType $type
     */
    public function registerType($name, ArticleType $type)
    {
        $this->type->put($name, $type);
    }
}

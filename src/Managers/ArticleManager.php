<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 15:38
 */
namespace Notadd\Content\Managers;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher as EventsDispatcher;
use Illuminate\Support\Collection;
use Notadd\Content\Templates\ArticleTemplate;
use Notadd\Content\Types\ArticleType;
/**
 * Class ArticleManager
 * @package Notadd\Content\Managers
 */
class ArticleManager {
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
     * @param \Illuminate\Container\Container $container
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function __construct(Container $container, EventsDispatcher $events) {
        $this->container = $container;
        $this->events = $events;
        $this->templates = new Collection();
        $this->type = new Collection();
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Templates\ArticleTemplate $template
     */
    public function registerTemplate($name, ArticleTemplate $template) {
        $this->templates->put($name, $template);
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Types\ArticleType $type
     */
    public function registerType($name, ArticleType $type) {
        $this->type->put($name, $type);
    }
}
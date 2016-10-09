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
use Notadd\Content\Events\RegisterCategoryTemplate;
use Notadd\Content\Events\RegisterCategoryType;
use Notadd\Content\Templates\CategoryTemplate;
use Notadd\Content\Types\CategoryType;
/**
 * Class CategoryManager
 * @package Notadd\Content\Managers
 */
class CategoryManager {
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
        $this->events->fire(new RegisterCategoryTemplate($container, $this));
        $this->events->fire(new RegisterCategoryType($container, $this));
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Templates\CategoryTemplate $template
     */
    public function registerTemplate($name, CategoryTemplate $template) {
        $this->templates->put($name, $template);
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Types\CategoryType $type
     */
    public function registerType($name, CategoryType $type) {
        $this->type->put($name, $type);
    }
}
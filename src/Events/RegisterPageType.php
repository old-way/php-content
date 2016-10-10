<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 17:41
 */
namespace Notadd\Content\Events;
use Illuminate\Container\Container;
use Notadd\Content\Managers\PageManager;
use Notadd\Content\Types\PageType;
/**
 * Class RegisterPageType
 * @package Notadd\Content\Events
 */
class RegisterPageType {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Notadd\Content\Managers\PageManager
     */
    protected $manager;
    /**
     * RegisterPageTemplate constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Managers\PageManager $manager
     */
    public function __construct(Container $container, PageManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Types\PageType $type
     */
    public function registerTemplate($name, PageType $type) {
        $this->manager->registerType($name, $type);
    }
}
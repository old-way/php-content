<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 17:44
 */
namespace Notadd\Content\Events;
use Illuminate\Container\Container;
use Notadd\Content\Managers\CategoryManager;
use Notadd\Content\Types\CategoryType;
/**
 * Class RegisterCategoryType
 * @package Notadd\Content\Events
 */
class RegisterCategoryType {
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;
    /**
     * @var \Notadd\Content\Managers\PageManager
     */
    protected $manager;
    /**
     * RegisterCategoryType constructor.
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Managers\CategoryManager $manager
     */
    public function __construct(Container $container, CategoryManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Types\CategoryType $type
     */
    public function registerTemplate($name, CategoryType $type) {
        $this->manager->registerType($name, $type);
    }
}
<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 17:43
 */
namespace Notadd\Content\Events;

use Illuminate\Container\Container;
use Notadd\Content\Managers\ArticleManager;
use Notadd\Content\Types\ArticleType;

/**
 * Class RegisterArticleType.
 */
class RegisterArticleType
{
    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var \Notadd\Content\Managers\PageManager
     */
    protected $manager;

    /**
     * RegisterArticleTemplate constructor.
     *
     * @param \Illuminate\Container\Container         $container
     * @param \Notadd\Content\Managers\ArticleManager $manager
     */
    public function __construct(Container $container, ArticleManager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
    }

    /**
     * Register a article type.
     *
     * @param                                   $name
     * @param \Notadd\Content\Types\ArticleType $type
     */
    public function registerType($name, ArticleType $type)
    {
        $this->manager->registerType($name, $type);
    }
}

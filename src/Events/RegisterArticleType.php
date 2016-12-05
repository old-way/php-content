<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
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
     * TODO: Method registerTemplate Description
     *
     * @param                                   $name
     * @param \Notadd\Content\Types\ArticleType $type
     */
    public function registerTemplate($name, ArticleType $type)
    {
        $this->manager->registerType($name, $type);
    }
}

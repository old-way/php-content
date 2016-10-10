<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 17:43
 */
namespace Notadd\Content\Events;
use Illuminate\Container\Container;
use Notadd\Content\Managers\ArticleManager;
use Notadd\Content\Templates\ArticleTemplate;
/**
 * Class RegisterArticleTemplate
 * @package Notadd\Content\Events
 */
class RegisterArticleTemplate {
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
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Content\Managers\ArticleManager $manager
     */
    public function __construct(Container $container, ArticleManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }
    /**
     * @param string $name
     * @param \Notadd\Content\Templates\ArticleTemplate $template
     */
    public function registerTemplate($name, ArticleTemplate $template) {
        $this->manager->registerTemplate($name, $template);
    }
}
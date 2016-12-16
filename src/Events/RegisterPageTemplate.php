<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-09 17:38
 */
namespace Notadd\Content\Events;

use Illuminate\Container\Container;
use Notadd\Content\Managers\PageManager;
use Notadd\Content\Templates\PageTemplate;

/**
 * Class RegisterPageTemplate.
 */
class RegisterPageTemplate
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
     * RegisterPageTemplate constructor.
     *
     * @param \Illuminate\Container\Container      $container
     * @param \Notadd\Content\Managers\PageManager $manager
     */
    public function __construct(Container $container, PageManager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
    }

    /**
     * Register a page template.
     *
     * @param                                        $name
     * @param \Notadd\Content\Templates\PageTemplate $template
     */
    public function registerTemplate($name, PageTemplate $template)
    {
        $this->manager->registerTemplate($name, $template);
    }
}

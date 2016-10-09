<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-08 17:12
 */
namespace Notadd\Content;
use Notadd\Content\Listeners\RouteRegister;
use Notadd\Extension\Abstracts\ExtensionRegistrar;
/**
 * Class Module
 * @package Notadd\Content
 */
class Extension extends ExtensionRegistrar  {
    /**
     * @return string
     */
    protected function getExtensionName() {
        return 'notadd/content';
    }
    /**
     * @return string
     */
    protected function getExtensionPath() {
        return realpath(__DIR__ . '/../');
    }
    /**
     * @return void
     */
    public function register() {
        $this->events->subscribe(RouteRegister::class);
    }
}
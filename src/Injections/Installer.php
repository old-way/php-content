<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Content\Injections;

use Illuminate\Container\Container;
use Notadd\Foundation\Module\Abstracts\Installer as AbstractInstaller;

/**
 * Class Installer.
 */
class Installer extends AbstractInstaller
{
    /**
     * Installer constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->info->put('errors', $this->translator->trans('安装文章模块失败！'));
        $this->info->put('messages', $this->translator->trans('安装文章模块成功！'));
    }

    /**
     * @return bool
     */
    public function handle()
    {
        return true;
    }

    /**
     * @return array
     */
    public function require ()
    {
        return [];
    }
}

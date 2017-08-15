<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-07-01 15:49
 */
namespace Notadd\Content;

use Notadd\Foundation\Module\Abstracts\Definition as AbstractDefinition;

/**
 * Class Definition.
 */
class Definition extends AbstractDefinition
{
    /**
     * Description of module.
     *
     * @return string
     */
    public function description()
    {
        return 'Notadd 内容管理模块';
    }

    /**
     * Entries for module.
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function entries()
    {
        return [
            'administration' => [
                'notadd/content'   => [
                    'permissions' => '',
                    'scripts'     => asset('assets/content/administration/js/module.min.js'),
                    'stylesheets' => asset('assets/content/administration/css/module.min.css'),
                ],
            ],
        ];
    }

    /**
     * Name of module.
     *
     * @return string
     */
    public function name()
    {
        return '文章CMS';
    }

    /**
     * Version of module.
     *
     * @return string
     */
    public function version()
    {
        return '2.0.0';
    }

    /**
     * Setting data definition.
     *
     * @return array
     */
    public function settings()
    {
        return [];
    }

    /**
     * Requires of module.
     *
     * @return array
     */
    public function requires()
    {
        return [];
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-10 19:49
 */
namespace Notadd\Content\Handlers;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class ComponentHandler.
 */
class ComponentHandler extends SetHandler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * ComponentHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(
        Container $container,
        SettingsRepository $settings
    ) {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return $this->settings->all()->toArray();
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            '修改设置失败！',
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->settings->set('content.seo.article.description', $this->request->input('articleDescription'));
        $this->settings->set('content.seo.article.keyword', $this->request->input('articleKeyword'));
        $this->settings->set('content.seo.article.title', $this->request->input('articleTitle'));
        $this->settings->set('content.seo.category.description', $this->request->input('categoryDescription'));
        $this->settings->set('content.seo.category.keyword', $this->request->input('categoryKeyword'));
        $this->settings->set('content.seo.category.title', $this->request->input('categoryTitle'));
        $this->settings->set('content.seo.page.description', $this->request->input('pageDescription'));
        $this->settings->set('content.seo.page.keyword', $this->request->input('pageKeyword'));
        $this->settings->set('content.seo.page.title', $this->request->input('pageTitle'));
        $this->messages = [
            '修改设置成功!',
        ];

        return true;
    }
}
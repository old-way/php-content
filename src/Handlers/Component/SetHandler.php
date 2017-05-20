<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-02-10 19:49
 */
namespace Notadd\Content\Handlers\Component;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler as AbstractSetHandler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class ComponentHandler.
 */
class SetHandler extends AbstractSetHandler
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
        $this->errors->push($this->translator->trans('修改设置失败！'));
        $this->messages->push($this->translator->trans('修改设置成功！'));
        $this->settings = $settings;
    }

    /**
     * Errors for handler.
     *
     * @return array
     */
    public function errors()
    {
        return [
            '',
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->container->make('log')->info('input', $this->request->all());
        $this->container->make('log')->info('input one', [$this->request->input('article.description')]);
        $this->settings->set('content.seo.article.description', $this->request->input('article.description'));
        $this->settings->set('content.seo.article.keyword', $this->request->input('article.keyword'));
        $this->settings->set('content.seo.article.title', $this->request->input('article.title'));
        $this->settings->set('content.seo.category.description', $this->request->input('category.description'));
        $this->settings->set('content.seo.category.keyword', $this->request->input('category.keyword'));
        $this->settings->set('content.seo.category.title', $this->request->input('category.title'));
        $this->settings->set('content.seo.page.description', $this->request->input('page.description'));
        $this->settings->set('content.seo.page.keyword', $this->request->input('page.keyword'));
        $this->settings->set('content.seo.page.title', $this->request->input('page.title'));

        return true;
    }
}
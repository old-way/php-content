<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/26
 * Time: 下午11:51
 */
namespace Notadd\Content\Handlers\Component;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Setting\Contracts\SettingsRepository;

/**
 * Class GetHandler.
 */
class GetHandler extends Handler
{
    /**
     * @var \Notadd\Foundation\Setting\Contracts\SettingsRepository
     */
    protected $settings;

    /**
     * GetHandler constructor.
     *
     * @param \Illuminate\Container\Container                         $container
     * @param \Notadd\Foundation\Setting\Contracts\SettingsRepository $settings
     */
    public function __construct(Container $container, SettingsRepository $settings)
    {
        parent::__construct($container);
        $this->settings = $settings;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->withCode(200)->withData([
            'articleDescription' => $this->settings->get('content.seo.article.description', ''),
            'articleKeyword' => $this->settings->get('content.seo.article.keyword', ''),
            'articleTitle' => $this->settings->get('content.seo.article.title', ''),
            'categoryDescription' => $this->settings->get('content.seo.category.description', ''),
            'categoryKeyword' => $this->settings->get('content.seo.category.keyword', ''),
            'categoryTitle' => $this->settings->get('content.seo.category.title', ''),
            'pageDescription' => $this->settings->get('content.seo.page.description', ''),
            'pageKeyword' => $this->settings->get('content.seo.page.keyword', ''),
            'pageTitle' => $this->settings->get('content.seo.page.title', ''),
        ])->withMessage('获取组件配置成功！');
    }
}

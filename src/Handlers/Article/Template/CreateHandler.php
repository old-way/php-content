<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:13
 */
namespace Notadd\Content\Handlers\Article\Template;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleTemplate;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * CreateHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleTemplate $articleTemplate
     * @param \Illuminate\Container\Container        $container
     */
    public function __construct(
        ArticleTemplate $articleTemplate,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article_template.create.fail'));
        $this->messages->push($this->translator->trans('content::article_template.create.success'));
        $this->model = $articleTemplate;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->id = $this->model->create($this->request->all());

        return true;
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 18:06
 */
namespace Notadd\Content\Handlers\Article\Draft;

use Illuminate\Container\Container;
use Notadd\Content\Models\ArticleDraft;
use Notadd\Foundation\Passport\Abstracts\SetHandler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id = 0;

    /**
     * CreatorHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     * @param \Illuminate\Container\Container     $container
     */
    public function __construct(
        ArticleDraft $article,
        Container $container
    ) {
        parent::__construct($container);
        $this->errors->push($this->translator->trans('content::article.create.fail'));
        $this->messages->push($this->translator->trans('content::article.create.success'));
        $this->model = $article;
    }

    /**
     * Data for handler.
     *
     * @return array
     */
    public function data()
    {
        return [
            'id' => $this->id,
        ];
    }

    /**
     * Execute Handler.
     *
     * @return bool
     */
    public function execute()
    {
        $this->model = $this->model->create([
            'content'       => $this->request->input('content'),
            'is_hidden'     => $this->request->input('hidden'),
            'is_sticky'     => $this->request->input('sticky'),
            'source_author' => $this->request->input('source_author'),
            'source_link'   => $this->request->input('source_link'),
            'description'   => $this->request->input('summary'),
            'keyword'       => $this->request->input('tags'),
            'title'         => $this->request->input('title'),
        ]);
        $this->id = $this->model->getAttribute('id');

        return true;
    }
}

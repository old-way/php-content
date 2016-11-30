<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-11-25 15:22
 */
namespace Notadd\Content\Handlers\Finders;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Translation\Translator;
use Notadd\Content\Models\ArticleType;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

/**
 * Class ArticleTypeFindHandler.
 */
class ArticleTypeFinderHandler extends DataHandler
{
    /**
     * @var \Notadd\Content\Models\ArticleType
     */
    protected $articleType;

    /**
     * ArticleTypeFinderHandler constructor.
     *
     * @param \Notadd\Content\Models\ArticleType $articleType
     * @param \Illuminate\Container\Container    $container
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Translation\Translator $translator
     */
    public function __construct(
        ArticleType $articleType,
        Container $container,
        Request $request,
        Translator $translator
    ) {
        parent::__construct($container, $request, $translator);
        $this->articleType = $articleType;
    }

    /**
     * @return int
     */
    public function code()
    {
        return 200;
    }

    /**
     * @return array
     */
    public function data()
    {
        $articleType = $this->articleType->newQuery()->find($this->request->input('id'));

        return $articleType->getAttributes();
    }

    /**
     * @return array
     */
    public function errors()
    {
        return [
            $this->translator->trans(''),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            $this->translator->trans(''),
        ];
    }
}

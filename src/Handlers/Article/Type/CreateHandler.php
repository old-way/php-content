<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-11-25 15:18
 */
namespace Notadd\Content\Handlers\Article\Type;

use Notadd\Content\Models\ArticleType;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     */
    public function execute()
    {
        if (ArticleType::query()->create($this->request->all())) {
            $this->withCode(200)->withMessage('content::article_type.create.success');
        } else {
            $this->withCode(500)->withError('content::article_type.create.fail');
        }
    }
}

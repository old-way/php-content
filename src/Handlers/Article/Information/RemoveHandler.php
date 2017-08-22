<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-15 10:09
 */
namespace Notadd\Content\Handlers\Article\Information;

use Notadd\Content\Models\ArticleInformation;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'id' => [
                Rule::exists('content_article_informations'),
                Rule::numeric(),
                Rule::required(),
            ],
        ], [
            'id.exists' => '没有对应的信息项信息',
            'id.numeric' => '信息项 ID 必须为数值',
            'id.required' => '信息项 ID 必须填写',
        ]);
        $this->beginTransaction();
        $information = ArticleInformation::query()->find($this->request->input('id'));
        if ($information instanceof ArticleInformation && $information->delete()) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('删除信息项成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('删除信息项失败！');
        }
    }
}

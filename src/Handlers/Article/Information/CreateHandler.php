<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-14 16:51
 */
namespace Notadd\Content\Handlers\Article\Information;

use Notadd\Content\Models\ArticleInformation;
use Notadd\Foundation\Routing\Abstracts\Handler;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'name' => 'required',
        ], [
            'name.required' => $this->translator->trans('必须填写信息项名称！'),
        ]);
        $this->beginTransaction();
        $data = $this->request->only([
            'description',
            'length',
            'name',
            'order',
            'opinions',
            'required',
            'type',
        ]);
        $information = ArticleInformation::query()->create($data);
        if ($information instanceof ArticleInformation) {
            $information->categories()->sync($this->request->input('categories'));
            $this->commitTransaction();
            $this->withCode(200)->withMessage('创建文章信息项成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('创建文章信息项失败！');
        }
    }
}

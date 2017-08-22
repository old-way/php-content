<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-14 18:22
 */

namespace Notadd\Content\Handlers\Article\Information;

use Notadd\Content\Models\ArticleInformation;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'id'     => [
                Rule::exists('content_article_informations'),
                Rule::numeric(),
                Rule::required(),
            ],
            'groups' => Rule::array(),
            'name'   => Rule::required(),
        ], [
            'id.exists'     => '没有对应的信息项信息',
            'id.numeric'    => '信息项 ID 必须为数值',
            'id.required'   => '信息项 ID 必须填写',
            'name.required' => '信息项名称必须填写',
        ]);
        $this->beginTransaction();
        $builder = ArticleInformation::query();
        $builder->with('categories');
        $information = $builder->find($this->request->input('id'));
        $data = $this->request->only([
            'description',
            'length',
            'name',
            'order',
            'opinions',
            'required',
            'type',
        ]);
        if ($information instanceof ArticleInformation) {
            $information->update($data);
            $this->request->has('categories') && $information->categories()->sync((array)$this->request->input('categories'));
            $this->commitTransaction();
            $this->withCode(200)->withMessage('更新信息项数据成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('更新信息项数据失败！');
        }
    }
}

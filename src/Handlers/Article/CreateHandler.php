<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-08 17:27
 */
namespace Notadd\Content\Handlers\Article;

use Carbon\Carbon;
use Notadd\Content\Models\Article;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute()
    {
        $this->validate($this->request, [
            'category_id' => Rule::numeric(),
            'content'     => Rule::required(),
            'created_at'  => Rule::dateFormat('Y-m-d H:i:s'),
            'is_hidden'   => Rule::boolean(),
            'is_sticky'   => Rule::boolean(),
            'source_link' => Rule::url(),
            'title'       => Rule::required(),
        ], [
            'category_id.numeric'    => '分类 ID 必须为数值',
            'content.required'       => '必须填写文章内容',
            'created_at.date_format' => '创建时间格式错误',
            'is_hidden.boolean'      => '是否隐藏标识必须为布尔值',
            'is_sticky.boolean'      => '是否置顶标识必须为布尔值',
            'source_link.url'        => '来源链接不是合法的URL',
            'title.required'         => '必须填写文章标题',
        ]);
        $this->beginTransaction();
        $data = $this->request->only([
            'category_id',
            'content',
            'created_at',
            'description',
            'is_hidden',
            'is_sticky',
            'keyword',
            'source_author',
            'source_link',
            'thumb_image',
            'title',
        ]);
        if ($data['created_at']) {
            $data['created_at'] = Carbon::createFromTimestamp(strtotime($data['created_at']));
        } else {
            unset($data['created_at']);
        }
        if (Article::query()->create($data)) {
            $this->commitTransaction();
            $this->withCode(200)->withMessage('创建文章信息成功！');
        } else {
            $this->rollBackTransaction();
            $this->withCode(500)->withError('创建文章信息失败！');
        }
    }
}

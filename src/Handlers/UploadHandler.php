<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-08 17:47
 */

namespace Notadd\Content\Handlers;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Foundation\Validation\Rule;

/**
 * Class UploadHandler.
 */
class UploadHandler extends Handler
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * UploadHandler constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(Container $container, Filesystem $filesystem)
    {
        parent::__construct($container);
        $this->filesystem = $filesystem;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->validate($this->request, [
            'file' => [
                Rule::image(),
                Rule::required(),
            ],
        ], [
            'file.image'    => '上传文件格式必须为图片格式！',
            'file.required' => '必须上传一个文件！',
        ]);
        $file = $this->request->file('file');
        $hash = hash_file('md5', $file->getPathname(), false);
        $dictionary = $this->pathSplit($hash, '12', Collection::make([
            'uploads',
        ]))->implode(DIRECTORY_SEPARATOR);
        $name = Str::substr($hash, 12, 20) . '.' . $file->getClientOriginalExtension();
        if (!$this->filesystem->exists($dictionary . DIRECTORY_SEPARATOR . $name)) {
            $file->move($dictionary, $name);
        }
        $this->withCode(200)->withData([
            'path' => $this->pathSplit($hash, '12,20', Collection::make([
                    'uploads',
                ]))->implode('/') . '.' . $file->getClientOriginalExtension(),
        ])->withMessage('上传图片成功！');
    }

    /**
     * String split handler.
     *
     * @param string $path
     * @param string $dots
     * @param null   $data
     *
     * @return \Illuminate\Support\Collection|null
     */
    protected function pathSplit($path, $dots, $data = null)
    {
        $dots = explode(',', $dots);
        $data = $data ? $data : new Collection();
        $offset = 0;
        foreach ($dots as $dot) {
            $data->push(Str::substr($path, $offset, $dot));
            $offset += $dot;
        }

        return $data;
    }
}

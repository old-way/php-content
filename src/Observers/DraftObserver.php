<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-17 18:08
 */
namespace Notadd\Content\Observers;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Notadd\Content\Models\ArticleDraft;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class DraftObserver.
 */
class DraftObserver
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * ArticleObserver constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Illuminate\Filesystem\Filesystem $file
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(Container $container, Filesystem $file)
    {
        $this->container = $container;
        $this->file = $file;
        $this->request = $container->make('request');
    }

    /**
     * Article creating handler.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function creating(ArticleDraft $article)
    {
        $thumbImage = $this->request->file('image');
        if ($thumbImage) {
            if ($thumbImage instanceof UploadedFile) {
                $hash = hash_file('md5', $thumbImage->getPathname(), false);
                $dictionary = $this->pathSplit($hash, '12', Collection::make([
                    'uploads',
                ]))->implode(DIRECTORY_SEPARATOR);
                if (!$this->file->isDirectory(app_path($dictionary))) {
                    $this->file->makeDirectory(app_path($dictionary), 0777, true, true);
                }
                $file = Str::substr($hash, 12, 20) . '.' . $thumbImage->getClientOriginalExtension();
                if (!$this->file->exists($dictionary . DIRECTORY_SEPARATOR . $file)) {
                    $thumbImage->move($dictionary, $file);
                }
                $article->setAttribute('thumb_image', $this->pathSplit($hash, '12,20', Collection::make([
                        'uploads',
                    ]))->implode('/') . '.' . $thumbImage->getClientOriginalExtension());
            }
        }
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

    /**
     * Article updating handler.
     *
     * @param \Notadd\Content\Models\ArticleDraft $article
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updating(ArticleDraft $article)
    {
        $thumbImage = $this->request->file('image');
        if ($thumbImage) {
            if ($thumbImage instanceof UploadedFile) {
                $hash = hash_file('md5', $thumbImage->getPathname(), false);
                $dictionary = $this->pathSplit($hash, '12', Collection::make([
                    'uploads',
                ]))->implode(DIRECTORY_SEPARATOR);
                if (!$this->file->isDirectory(app_path($dictionary))) {
                    $this->file->makeDirectory(app_path($dictionary), 0777, true, true);
                }
                $file = Str::substr($hash, 12, 20) . '.' . $thumbImage->getClientOriginalExtension();
                if (!$this->file->exists($dictionary . DIRECTORY_SEPARATOR . $file)) {
                    $thumbImage->move($dictionary, $file);
                }
                $article->setAttribute('thumb_image', $this->pathSplit($hash, '12,20', Collection::make([
                        'uploads',
                    ]))->implode('/') . '.' . $thumbImage->getClientOriginalExtension());
            }
        }
    }
}

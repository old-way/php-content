<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:31
 */
namespace Notadd\Content\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Notadd\Foundation\Database\Model;
use Baum\Node;

/**
 * Class Category.
 */
class ArticleCategory extends Node
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $appends = [
        'breadcrumb',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'alias',
        'background_color',
        'background_image',
        'enabled',
        'deleted_at',
        'description',
        'flow_marketing',
        'pagination',
        'seo_description',
        'seo_keyword',
        'seo_title',
        'title',
        'top_image',
        'type',
    ];

    /**
     * @var array
     */
    protected $setters = [
        'enabled'    => 'empty|1',
        'type'       => 'empty|normal',
        'pagination' => 'empty|20',
        'type'       => 'empty|normal',
    ];

    /**
     * @var string
     */
    protected $table = 'content_article_categories';

    /**
     * @param $value
     *
     * @return string
     */
    public function getBreadcrumbAttribute($value)
    {
        $paths = new Collection([$this]);
        if ($this->attributes['parent_id'] && ($one = static::query()->find($this->attributes['parent_id'])) instanceof ArticleCategory) {
            $paths->prepend($one);
            if ($one->getAttribute('parent_id') && ($two = static::query()->find($one->getAttribute('parent_id'))) instanceof ArticleCategory) {
                $paths->prepend($two);
            }
        }
        $paths->transform(function (ArticleCategory $category) {
            return $category->getAttribute('title');
        });

        return $paths->implode(' / ');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(ArticleCategory::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function informations()
    {
        return $this->belongsToMany(ArticleInformation::class, 'content_article_information_relations', 'category_id', 'information_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(ArticleCategory::class, 'parent_id');
    }
}

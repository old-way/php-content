<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 13:18
 */

namespace Notadd\Content\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class ArticleInformation.
 */
class ArticleInformation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'details',
        'length',
        'name',
        'order',
        'opinions',
        'privacy',
        'register',
        'required',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'content_article_informations';

    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'member_information_relations', 'information_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(ArticleInformationValue::class, 'information_id');
    }
}

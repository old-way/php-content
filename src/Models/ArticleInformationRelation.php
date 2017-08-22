<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-12 13:23
 */

namespace Notadd\Content\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class ArticleInformationRelation.
 */
class ArticleInformationRelation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'information_id',
    ];

    /**
     * @var string
     */
    protected $table = 'content_article_information_relations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function information()
    {
        return $this->belongsTo(ArticleInformation::class);
    }
}

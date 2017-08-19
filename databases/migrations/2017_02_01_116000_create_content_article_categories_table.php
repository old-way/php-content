<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-09 17:05:14
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateCategoriesTable.
 */
class CreateContentArticleCategoriesTable extends Migration
{

    // 'parent_id' column name
    protected $parentColumn = 'parent_id';

    // 'lft' column name
    protected $leftColumn = 'lft';

    // 'rgt' column name
    protected $rightColumn = 'rgt';

    // 'depth' column name
    protected $depthColumn = 'depth';

    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('content_article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('title');
            $table->string('alias')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->default('normal');
            $table->string('seo_title')->nullable();
            $table->string('seo_keyword')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('background_color')->nullable();
            $table->string('background_image')->nullable();
            $table->string('top_image')->nullable();
            $table->tinyInteger('pagination')->default(30);
            $table->boolean('enabled')->default(true);
            $table->string('flow_marketing')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // 添加无限级分类
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('content_article_categories');
    }
}

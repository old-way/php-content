<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-15 14:31:43
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateTablePageCategories.
 */
class CreateTablePageCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('page_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
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
            $table->tinyInteger('order_id')->default(0);
            $table->tinyInteger('pagination')->default(30);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('page_categories');
    }
}

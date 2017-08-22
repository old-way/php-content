<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-08-12 13:22:20
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateContentArticleInformationValuesTable.
 */
class CreateContentArticleInformationValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('content_article_information_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->comment('文章 ID');
            $table->integer('category_id')->comment('分类 ID');
            $table->integer('information_id')->comment('信息项 ID');
            $table->text('value')->nullable()->comment('信息值');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('content_article_information_values');
    }
}

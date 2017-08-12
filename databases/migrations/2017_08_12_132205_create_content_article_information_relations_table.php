<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-08-12 13:22:05
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateContentArticleInformationRelationsTable.
 */
class CreateContentArticleInformationRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('content_article_information_relations', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('information_id');
            $table->primary([
                'category_id',
                'information_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->drop('content_article_information_relations');
    }
}

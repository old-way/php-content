<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-17 17:58:19
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateTableArticleDrafts.
 */
class CreateTableArticleDrafts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('article_drafts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('source_author')->nullable();
            $table->string('source_link')->nullable();
            $table->mediumText('content')->nullable();
            $table->string('keyword')->nullable();
            $table->string('description')->nullable();
            $table->integer('hits')->default(0);
            $table->boolean('is_hidden')->default(0);
            $table->boolean('is_sticky')->default(0);
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
        $this->schema->drop('article_drafts');
    }
}

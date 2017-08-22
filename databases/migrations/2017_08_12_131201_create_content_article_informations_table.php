<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-08-12 13:12:01
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateContentArticleInformationsTable.
 */
class CreateContentArticleInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('content_article_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->tinyInteger('length')->default(0);
            $table->string('name');
            $table->tinyInteger('order')->default(0);
            $table->string('opinions')->nullable();
            $table->tinyInteger('privacy')->default(0);
            $table->tinyInteger('required')->default(0);
            $table->enum('type', [
                'checkbox',
                'date',
                'daterange',
                'dropdown',
                'datetime',
                'file',
                'input',
                'picture',
                'radio',
                'select',
                'textarea',
            ]);
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
        $this->schema->drop('content_article_informations');
    }
}

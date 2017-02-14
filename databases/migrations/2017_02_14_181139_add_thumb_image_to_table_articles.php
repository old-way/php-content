<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-14 18:11:39
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class AddThumbImageToTableArticles.
 */
class AddThumbImageToTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('articles', function (Blueprint $table) {
            $table->string('thumb_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('articles', function (Blueprint $table) {
            $table->dropColumn('thumb_image');
        });
    }
}

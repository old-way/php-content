<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-20 19:19:56
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class AddFieldToTablePages.
 */
class AddFieldToTablePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('pages', function (Blueprint $table) {
            $table->string('category_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('pages', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}

<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-02-11 23:32:44
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class AddOrderIdToCategories.
 */
class AddOrderIdToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('categories', function (Blueprint $table) {
            $table->tinyInteger('order_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('categories', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}

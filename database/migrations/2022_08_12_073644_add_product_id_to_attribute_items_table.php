<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToAttributeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_items', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_items', function (Blueprint $table) {
            $table->dropForeign('attribute_items_product_id_foreign');
            $table->dropColumn('product_id');
        });
    }
}

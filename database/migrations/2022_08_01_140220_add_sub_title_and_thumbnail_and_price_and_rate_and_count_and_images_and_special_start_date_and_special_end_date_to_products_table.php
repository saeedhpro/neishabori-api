<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubTitleAndThumbnailAndPriceAndRateAndCountAndImagesAndSpecialStartDateAndSpecialEndDateToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sub_title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('rate')->default(0);
            $table->unsignedBigInteger('count')->default(0);
            $table->longText('images')->nullable();
            $table->dateTime('special_start_date')->nullable();
            $table->dateTime('special_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sub_title');
            $table->dropColumn('thumbnail');
            $table->dropColumn('price');
            $table->dropColumn('rate');
            $table->dropColumn('count');
            $table->dropColumn('images');
            $table->dropColumn('special_start_date');
            $table->dropColumn('special_end_date');
        });
    }
}

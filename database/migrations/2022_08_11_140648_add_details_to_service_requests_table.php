<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('plate');
            $table->text('address');
            $table->dateTime('time')->nullable();
            $table->foreignId('service_id')->nullable()->references('id')->on('services')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->references('id')->on('services')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('full_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('plate');
            $table->dropColumn('address');
            $table->dropColumn('time');
            $table->dropForeign('service_requests_service_id_foreign');
            $table->dropColumn('service_id');
            $table->dropForeign('service_requests_city_id_foreign');
            $table->dropColumn('city_id');
        });
    }
}

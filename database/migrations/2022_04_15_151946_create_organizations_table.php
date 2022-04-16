<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('tel')->nullable();
            $table->string('economic_code')->nullable();
            $table->string('national_code')->nullable();
            $table->string('register_id')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('province_id')->nullable()->references('id')->on('provinces')->onDelete('set null');
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}

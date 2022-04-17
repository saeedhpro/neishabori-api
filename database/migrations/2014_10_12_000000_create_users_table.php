<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->string('email')->nullable()->unique();
            $table->string('sheba')->nullable();
            $table->string('national_code')->nullable();
            $table->string('job')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_legal')->default(false);
            $table->timestamp('phone_number_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

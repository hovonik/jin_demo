<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('mobile_verify_code')->nullable();
            $table->timestamp('mobile_verify_code_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_courier')->default(false);
            $table->string('address')->nullable();
            $table->string('town')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('lang')->default('en')->nullable();
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
        Schema::dropIfExists('masters');
    }
};

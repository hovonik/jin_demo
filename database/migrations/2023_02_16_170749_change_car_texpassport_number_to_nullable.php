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
        Schema::table('master_verification_request_files', function (Blueprint $table) {
            $table->string('car_texpassport_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_verification_request_files', function (Blueprint $table) {
            $table->string('car_texpassport_number')->nullable(false)->change();
        });
    }
};

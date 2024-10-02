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
        Schema::table('shopping_carts', function (Blueprint $table) {
            $table->string('address')->after('status')->nullable();
            $table->string('lat')->after('address')->nullable();
            $table->string('lng')->after('lat')->nullable();
            $table->string('driver_id')->after('lng')->nullable();
            $table->integer('shop_id')->after('driver_id')->nullable();
            $table->string('state')->after('shop_id')->default('pending')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shopping_carts', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('driver_id');
            $table->dropColumn('shop_id');
            $table->dropColumn('driver_id');
            $table->dropColumn('state');
        });
    }
};

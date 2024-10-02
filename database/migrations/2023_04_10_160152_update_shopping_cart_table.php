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
            $table->dateTime('place_in_date')->after('state')->nullable();
            $table->dateTime('end_date')->after('place_in_date')->nullable();
            $table->decimal('start_lat',10,8)->after('end_date')->nullable();
            $table->decimal('start_long',11,8)->after('start_lat')->nullable();
            $table->decimal('end_lat',10,8)->after('start_long')->nullable();
            $table->decimal('end_long',11,8)->after('end_lat')->nullable();
            $table->decimal('distance_km')->after('end_long')->nullable();
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
            $table->dropColumn('place_in_date');
            $table->dropColumn('end_date');
            $table->dropColumn('start_lat');
            $table->dropColumn('start_long');
            $table->dropColumn('end_lat');
            $table->dropColumn('end_long');
            $table->dropColumn('distance_km');
        });
    }
};

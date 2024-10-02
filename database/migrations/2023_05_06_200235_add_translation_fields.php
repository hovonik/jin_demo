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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('title_ru')->after('title')->nullable();
            $table->string('title_en')->after('title')->nullable();
            $table->string('description_ru')->after('description')->nullable();
            $table->string('description_en')->after('description')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('title_ru')->after('title')->nullable();
            $table->string('title_en')->after('title')->nullable();
            $table->string('description_ru')->after('description')->nullable();
            $table->string('description_en')->after('description')->nullable();
        });

        Schema::table('professions', function (Blueprint $table) {
            $table->string('title_ru')->after('title')->nullable();
            $table->string('title_en')->after('title')->nullable();
            $table->string('description_ru')->after('description')->nullable();
            $table->string('description_en')->after('description')->nullable();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('title_ru')->after('title')->nullable();
            $table->string('title_en')->after('title')->nullable();
            $table->string('description_ru')->after('description')->nullable();
            $table->string('description_en')->after('description')->nullable();
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->string('name_ru')->after('name')->nullable();
            $table->string('name_en')->after('name')->nullable();
        });

        Schema::table('custom_fields', function (Blueprint $table) {
            $table->string('name_ru')->after('name')->nullable();
            $table->string('name_en')->after('name')->nullable();
        });

        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->string('value_ru')->after('value')->nullable();
            $table->string('value_en')->after('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ru');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ru');
        });

        Schema::table('professions', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ru');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
            $table->dropColumn('description_ru');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('name_ru');
            $table->dropColumn('name_en');
        });

        Schema::table('custom_fields', function (Blueprint $table) {
            $table->dropColumn('name_ru');
            $table->dropColumn('name_en');
        });

        Schema::table('product_custom_fields', function (Blueprint $table) {
            $table->dropColumn('value_en');
            $table->dropColumn('value_ru');
        });
    }
};

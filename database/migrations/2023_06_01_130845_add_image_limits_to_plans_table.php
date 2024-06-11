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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('image_limit')->default(10);
            $table->integer('image_search_limit')->default(10);
        });

        Schema::table('users', function (Blueprint $table){
            $table->integer('remaining_image_search')->default(10);
            $table->integer('remaining_image')->default(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->removeColumn('image_limit');
            $table->removeColumn('image_search_limit');
        });

        Schema::table('users', function (Blueprint $table){
            $table->removeColumn('remaining_image_search');
            $table->removeColumn('remaining_image');
        });
    }
};

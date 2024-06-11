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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('category_slug');
            $table->string('category_name');
            $table->string('category_title');
            $table->string('meta_poster')->nullable();
            $table->string('meta_description')->nullable();
            $table->unsignedInteger('data_id')->nullable();
            $table->foreign('data_id')
                ->references('id')
                ->on('items');
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
        Schema::dropIfExists('categories');
    }
};

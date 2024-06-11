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
        Schema::create('items', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('data_id');
            $table->string('parent_id')->nullable();
            $table->timestamps();
            $table->string('language');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('author_id')->nullable();
            $table->string('publish_at')->nullable();
            $table->string('expire_at')->nullable();
            $table->string('order')->nullable();
            $table->string('public');
            $table->string('active')->nullable();
            $table->integer('version')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};

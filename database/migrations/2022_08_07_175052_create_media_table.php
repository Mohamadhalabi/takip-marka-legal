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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('media_id')->nullable();
            $table->timestamps();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('mime')->nullable();
            $table->integer('size')->nullable();
            $table->string('extension')->nullable();
            $table->integer('version')->nullable();
            $table->string('path')->nullable();
            $table->unsignedInteger('data_id')->nullable();
            $table->foreign('data_id')
                ->references('id')
                ->on('items');
            $table->boolean('is_official')->nullable()->default(0);
            $table->boolean('is_saved')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
};

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
        Schema::create('meta', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->string('tags')->nullable();
            $table->longText('content')->nullable();
            $table->string('link_type')->nullable();
            $table->string('variables')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('meta');
    }
};

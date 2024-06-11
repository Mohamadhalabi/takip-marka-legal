<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('trademarks', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->string('application_date');
            $table->string('register_no');
            $table->string('register_date');
            $table->string('intreg_no');
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->text('nice_classes');
            $table->text('vienna_classes');
            $table->string('type');
            $table->string('pub_type');
            $table->string('image_path')->nullable();
            $table->integer('bulletin_id')->nullable();
            // Attorney table
            $table->text('attorney_no')->nullable();
            $table->text('attorney_name')->nullable();
            $table->text('attorney_title')->nullable();
            
            // Goods table
            $table->text('good_class_id')->nullable();
            $table->text('good_subclass_id')->nullable();
            $table->text('good_description')->nullable();

            // Extracted Goods table
            $table->text('extracted_good_class_id')->nullable();
            $table->text('extracted_good_subclass_id')->nullable();
            $table->text('extracted_good_description')->nullable();

            // Holder table
            $table->text('holder_tpec_client_id')->nullable();
            $table->text('holder_title')->nullable();
            $table->text('holder_address')->nullable();
            $table->text('holder_city')->nullable();
            $table->text('holder_state')->nullable();
            $table->text('holder_postal_code')->nullable();
            $table->text('holder_country_no')->nullable();
            
            $table->timestamps();
        });

        // Add indexes
        DB::statement('ALTER TABLE trademarks ADD FULLTEXT (name,slug)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trademarks');
    }
};

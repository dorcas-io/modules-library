<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdaVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('dorcas-api')->create('mda_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->char('partner_id','50');
            $table->uuid('resource_uuid');
            $table->integer('resource_category');
            $table->integer('resource_subcategory');
            $table->string('resource_type');
            $table->string('resource_subtype');
            $table->text('resource_thumb');
            $table->text('resource_image');
            $table->text('resource_video');
            $table->text('resource_title','255');
            $table->text('resource_description');
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
        Schema::connection('dorcas-api')->dropIfExists('mda_videos');
    }
}

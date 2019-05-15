<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_library_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('partner_id');
            $table->string('resource_uuid');
            $table->string('resource_category');
            $table->string('resource_subcategory');
            $table->string('resource_type');
            $table->string('resource_subtype');
            $table->string('resource_thumb');
            $table->string('resource_source');
            $table->string('resource_title');
            $table->string('resource_description');
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
        Schema::dropIfExists('modules_library_resources');
    }
}

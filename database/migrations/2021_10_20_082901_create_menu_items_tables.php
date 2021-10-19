<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemsTables extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            // feel free to modify the name of this column, but title is supported by default (you would need to specify the name of the column Twill should consider as your "title" column in your module controller if you change it)
            $table->string('title', 200)->nullable();

            // your generated model and form include a description field, to get you started, but feel free to get rid of it if you don't need it
            $table->text('description')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->string('suptitle')->default('object')->nullable();
            $table->enum('link_target', array('_parent','_blank'))->default('_parent')->nullable();
            $table->text('url')->nullable();
            $table->text('route_path')->nullable();

            $table->nestedSet();

            $table->unsignedBigInteger('menu_id')->index()->nullable()->unsigned();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade')
            ;

            // add those 2 columns to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();
        });

        Schema::create('menu_item_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'menu_item');
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_revisions');
        Schema::dropIfExists('menu_items');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("remote_id")->nullable()->default(null);
            $table->string("name")->nullable()->default(null);
            $table->string("alias")->nullable()->default(null);
            $table->string("teaser_append")->nullable()->default(null);
            $table->string("chain_append")->nullable()->default(null);
            $table->text("description")->nullable()->default(null);
            $table->text("image")->nullable()->default(null);
            $table->boolean("status")->nullable()->default(null);
            $table->boolean("front")->nullable()->default(null);
            $table->integer("order")->nullable()->default(null);
            $table->integer("filter_group_id")->nullable()->default(null);
            $table->json("data")->nullable()->default(null);
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
        Schema::dropIfExists('filters');
    }
}

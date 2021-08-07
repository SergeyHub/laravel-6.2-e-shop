<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("remote_id")->nullable()->default(null);
            $table->string("name")->nullable()->default(null);
            $table->string("alias")->nullable()->default(null);
            $table->string("chain_append")->nullable()->default(null);
            $table->text("description")->nullable()->default(null);
            $table->text("image")->nullable()->default(null);
            $table->boolean("status")->nullable()->default(null);
            $table->boolean("chained")->nullable()->default(null);
            $table->boolean("excluding")->nullable()->default(null);
            $table->integer("order")->nullable()->default(null);
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
        Schema::dropIfExists('filter_groups');
    }
}

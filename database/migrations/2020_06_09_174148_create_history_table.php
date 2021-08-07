<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("model")->nullable()->default(null);
            $table->integer("model_id")->nullable()->default(null);
            $table->string("type")->nullable()->default(null);
            $table->string("description")->nullable()->default(null);
            $table->json("old")->nullable()->default(null);
            $table->json("new")->nullable()->default(null);
            $table->json("fields")->nullable()->default(null);
            $table->integer("user_id")->nullable()->default(null);
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
        Schema::dropIfExists('history');
    }
}

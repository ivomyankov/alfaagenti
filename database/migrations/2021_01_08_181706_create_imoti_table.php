<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImotiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imoti', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->nullable();
            $table->string('text')->nullable();
            $table->string('status')->default('Чернова');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('owner')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('top')->default(0);
            $table->string('city')->nullable();
            $table->tinyInteger('area_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->integer('price')->unsigned()->nullable();
            $table->integer('size')->unsigned()->nullable();
            $table->tinyInteger('floor')->nullable();
            $table->tinyInteger('floors')->nullable();
            $table->string('material')->nullable();
            $table->string('view')->nullable();
            $table->string('options')->nullable();
            $table->tinyInteger('agent_id')->nullable();
            $table->boolean('private')->default(0);
            $table->boolean('deleted')->default(0);
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
        Schema::dropIfExists('imoti');
    }
}

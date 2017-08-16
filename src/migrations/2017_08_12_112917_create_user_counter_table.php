<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_counter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name');
            $table->integer('object_id');
            $table->integer('user_id');
            $table->string('action');
            
            $table->index('class_name');
            $table->index('object_id');
            $table->index('user_id');
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
        Schema::dropIfExists('user_counter');
    }
}

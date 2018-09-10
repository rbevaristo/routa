<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->default('default.png');
            $table->boolean('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('contact')->nullable();
            $table->integer('man_id')->unsigned()->nullable();
            $table->integer('emp_id')->unsigned()->nullable();
            
            $table->foreign('man_id')->references('id')->on('managers');
            $table->foreign('emp_id')->references('id')->on('employees');
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
        Schema::dropIfExists('profiles');
    }
}

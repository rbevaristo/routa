<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->boolean('is_reset')->default(false);
            $table->integer('manager_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->integer('role_id')->unsigned()->default(3);
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('manager_id')->references('id')->on('managers');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Quality_of_Work');
            $table->integer('Efficiency_of_Work');
            $table->integer('Dependability');
            $table->integer('Job_Knowledge');
            $table->integer('Attitude');
            $table->integer('Housekeeping');
            $table->integer('Reliability');
            $table->integer('Personal_Care');
            $table->integer('Judgement');
            $table->integer('emp_id')->unsigned()->nullable();
            $table->integer('manager_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('emp_id')->references('id')->on('employees');
            $table->foreign('manager_id')->references('id')->on('managers');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('evaluation_results');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->mediumText('address')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');

            $table->integer('zipcode')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('date_hired')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('department_id')->references('id')->on('departments');
            // $table->foreign('country_id')->references('id')->on('countries');
            // $table->foreign('city_id')->references('id')->on('cities');
            // $table->foreign('state_id')->references('id')->on('states');

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('student_trip', function (Blueprint $table) {
            $table->id();
            $table->time('main_time',0);
            $table->time('time_desire_1',0);
            $table->time('time_desire_2',0);
            $table->text('status');//0 default  //1 exist     //-1 not exist(same cancel after 9) 
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
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
        Schema::dropIfExists('student_brokes');
    }
};

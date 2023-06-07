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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('gender');
            $table->text('phone_number');
            $table->text('date_reg');
            $table->text('data_reg_end');
            $table->text('age');
            $table->text('vehicle_number');
            $table->text('vehicle_type');
            $table->text('portfolio');
            $table->text('status');
            $table->text('num_stu');
            $table->text('financial')->nullable();;
            $table->string('alert_count');
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
        Schema::dropIfExists('drivers');
    }
};

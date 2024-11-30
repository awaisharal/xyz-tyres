<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateShopSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('shop_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Assuming the shopkeeper is stored in the 'users' table
            $table->boolean('monday_enabled')->default(false);
            $table->time('monday_start_time')->nullable();
            $table->time('monday_end_time')->nullable();

            $table->boolean('tuesday_enabled')->default(false);
            $table->time('tuesday_start_time')->nullable();
            $table->time('tuesday_end_time')->nullable();

            $table->boolean('wednesday_enabled')->default(false);
            $table->time('wednesday_start_time')->nullable();
            $table->time('wednesday_end_time')->nullable();

            $table->boolean('thursday_enabled')->default(false);
            $table->time('thursday_start_time')->nullable();
            $table->time('thursday_end_time')->nullable();

            $table->boolean('friday_enabled')->default(false);
            $table->time('friday_start_time')->nullable();
            $table->time('friday_end_time')->nullable();

            $table->boolean('saturday_enabled')->default(false);
            $table->time('saturday_start_time')->nullable();
            $table->time('saturday_end_time')->nullable();

            $table->boolean('sunday_enabled')->default(false);
            $table->time('sunday_start_time')->nullable();
            $table->time('sunday_end_time')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_schedules');
    }
}

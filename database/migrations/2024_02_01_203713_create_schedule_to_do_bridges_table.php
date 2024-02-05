<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_to_do_bridges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id')->index('schedule_id')->comment('Id of the schedule');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->unsignedBigInteger('to_do_id')->index('to_do_id')->comment('Id of the to do');
            $table->foreign('to_do_id')->references('id')->on('to_dos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_to_do_bridges');
    }
};

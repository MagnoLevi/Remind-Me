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
        Schema::create('to_do_weeklies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('to_do_id')->index('to_do_id')->comment('Id of the to do');
            $table->foreign('to_do_id')->references('id')->on('to_dos')->onDelete('cascade');
            $table->integer("weekday")->comment("Day of the week of the to do");
            $table->time("time")->comment("To do time");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_do_weeklies');
    }
};

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
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id')->comment('Id of the user');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("description")->comment("Brief descrciption about what must be done");
            $table->date("due_date")->nullable()->comment("Due date of the to do");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_dos');
    }
};

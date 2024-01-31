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
        Schema::table('to_dos', function (Blueprint $table) {
            $table->enum("type", ["DAILY", "WEEKLY", "MONTHLY"])->nullable()->after("due_date")->comment("Type of to do");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('to_dos', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};

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
        Schema::table('category', function (Blueprint $table) {
            $table->text('icon');
            $table->text('id_icon');
            $table->text('background');
            $table->text('id_background');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('id_icon');
            $table->dropColumn('background');
            $table->dropColumn('id_background');
        });
    }
};

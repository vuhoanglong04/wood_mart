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
        Schema::table('products_variant', function (Blueprint $table) {
                $table->unsignedInteger('color_id')->change();
                $table->foreign('color_id')->references('id')->on('colors');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_variant', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
        });
    }
};

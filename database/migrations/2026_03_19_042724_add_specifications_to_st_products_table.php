<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('st_products', function (Blueprint $table) {
            // Menambahkan kolom JSON untuk fleksibilitas spesifikasi
            $table->json('specifications')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_products', function (Blueprint $table) {
            //
        });
    }
};

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
        // Update tabel st_product_transactions untuk menambahkan kolom status
        if (!Schema::hasColumn('st_product_transactions', 'status')) {
            Schema::table('st_product_transactions', function (Blueprint $table) {
                $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'completed', 'canceled'])
                    ->default('pending')
                    ->after('is_paid');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

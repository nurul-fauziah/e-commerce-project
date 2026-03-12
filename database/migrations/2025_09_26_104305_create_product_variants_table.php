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
        Schema::create('st_product_variants', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke produk
            $table->foreignId('st_product_id')->constrained('st_products')->onDelete('cascade');

            $table->string('name');  // Contoh: 'RAM', 'Storage', 'Color'
            $table->string('value'); // Contoh: '16GB', '512GB', 'Midnight Black'
            $table->softDeletes();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_product_variants');
    }
};

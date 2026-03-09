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
            $table->string('variant_name'); // Misal: "RAM", "Warna", "Storage"
            $table->string('variant_value'); // Misal: "16GB", "Midnight Black", "512GB SSD"
            $table->foreignId('st_product_id')->constrained()->cascadeOnDelete();
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

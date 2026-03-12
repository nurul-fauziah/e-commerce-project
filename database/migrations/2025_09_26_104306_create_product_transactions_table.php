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
        Schema::create('st_product_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('booking_trx_id');
            $table->string('city');
            $table->string('post_code');
            $table->string('proof')->nullable(); // Bukti transfer

            $table->string('variant_details')->nullable(); // Nyimpen varian yang dipilih (misal: "RAM 16GB, Blue")
            $table->text('address');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('sub_total_amount');
            $table->unsignedBigInteger('grand_total_amount');
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->boolean('is_paid')->default(false);

            $table->foreignId('st_product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('st_promo_code_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_product_transactions');
    }
};

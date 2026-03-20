<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Bersihkan tabel HEADER (st_product_transactions)
        Schema::table('st_product_transactions', function (Blueprint $table) {
            // WAJIB DIEKSEKUSI: Putus relasi Foreign Key dari tabel produk lama
            $table->dropForeign(['st_product_id']);

            // Setelah relasi putus, baru aman untuk menghapus kolom-kolom ini
            $table->dropColumn([
                'st_product_id',
                'variant_details',
                'quantity'
            ]);
        });

        // 2. Buat tabel DETAIL pesanan baru (st_transaction_details)
        Schema::create('st_transaction_details', function (Blueprint $table) {
            $table->id();

            // Relasi ke Header Transaksi
            $table->foreignId('st_product_transaction_id')
                  ->constrained('st_product_transactions')
                  ->cascadeOnDelete();

            // Relasi ke Produk
            $table->foreignId('st_product_id')
                  ->constrained('st_products')
                  ->cascadeOnDelete();

            $table->string('variant_details')->nullable()->comment('Menyimpan info RAM, Storage, dll saat dibeli');
            $table->integer('quantity');
            $table->decimal('price', 15, 2)->comment('Harga satuan saat checkout');
            $table->decimal('subtotal', 15, 2)->comment('price * quantity');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        // Urutan Rollback: Hapus tabel anak dulu, baru kembalikan kolom ke tabel induk
        Schema::dropIfExists('st_transaction_details');

        Schema::table('st_product_transactions', function (Blueprint $table) {
            $table->foreignId('st_product_id')->nullable()->constrained('st_products');
            $table->string('variant_details')->nullable();
            $table->integer('quantity')->default(1);
        });
    }
};

@extends('layouts.front')

@section('title', $product->name . ' - SmartTech')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12 md:py-16">
    <!-- Mengarah ke route Cart yang baru -->
    <form action="{{ route('front.cart.add', $product->id) }}" method="POST">
        @csrf
        <!-- Hidden input yang akan diisi oleh Javascript -->
        <input type="hidden" name="variant_id" id="selected_variant_id" required>
        <!-- Kita simpan juga string detailnya untuk keperluan history pesanan nanti -->
        <input type="hidden" name="variant_details" id="selected_variant_details" value="">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <!-- KIRI: Gambar -->
            <div class="lg:sticky lg:top-32">
                <div class="bg-white border-4 border-black p-4 shadow-[20px_20px_0px_0px_#000]">
                    <div class="aspect-square bg-[#E4E3E0] border-2 border-black overflow-hidden relative group">
                        <img src="{{ Storage::url($product->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Gallery Tambahan (Opsional, jika ada) -->
                @if($product->photos->count() > 0)
                <div class="grid grid-cols-4 gap-4 mt-4">
                    @foreach($product->photos as $photo)
                    <div class="aspect-square bg-white border-2 border-black overflow-hidden cursor-pointer hover:border-[#C5F277]">
                        <img src="{{ Storage::url($photo->photo) }}" class="w-full h-full object-cover grayscale hover:grayscale-0" alt="Gallery">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- KANAN: Info & Form -->
            <div class="flex flex-col gap-10">
                <div>
                    <h1 class="text-5xl md:text-7xl font-black italic uppercase tracking-tighter leading-[0.85] mb-2">{{ $product->name }}</h1>
                    <p class="text-[10px] font-bold uppercase tracking-widest opacity-40">// {{ $product->category->name }}</p>
                </div>

                <div class="bg-[#C5F277] border-4 border-black p-8 shadow-[10px_10px_0px_0px_#000]">
                    <p class="text-[10px] font-bold uppercase tracking-widest mb-2">Selected_Configuration_Price</p>
                    <!-- Harga ini akan berubah lewat JS -->
                    <p id="dynamic-price" class="text-5xl md:text-6xl font-black italic tracking-tighter">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Varian Spesifikasi (Dinamis dari JSON) -->
                <div id="variation-selector" data-variants="{{ json_encode($product->variants) }}" class="flex flex-col gap-6">
                    <h2 class="text-xl font-black italic uppercase border-b-4 border-black pb-1">System_Configuration</h2>

                    @if(isset($availableAttributes) && count($availableAttributes) > 0)
                        @foreach($availableAttributes as $attributeName => $options)
                            <div class="mb-4">
                                <p class="text-xs font-bold font-mono uppercase mb-2">> {{ $attributeName }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($options as $opt)
                                        <button type="button"
                                            class="spec-btn border-2 border-black px-4 py-2 font-black italic text-sm bg-white hover:bg-black hover:text-white transition-all"
                                            data-key="{{ $attributeName }}"
                                            data-value="{{ $opt }}">
                                            {{ $opt }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Jika produk ini tidak punya varian di DB -->
                        <div class="border-2 border-dashed border-black p-4 bg-gray-50">
                            <p class="text-sm font-bold opacity-50 italic">Standard Configuration Only</p>
                        </div>
                    @endif
                </div>

                <button type="submit" id="btn-add-cart" class="w-full bg-black text-white py-6 px-8 font-black italic uppercase text-2xl shadow-[10px_10px_0px_0px_#C5F277] border-2 border-black opacity-50 cursor-not-allowed transition-all" disabled>
                    Add_To_Cart
                </button>
            </div>
        </div>
    </form>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const variants = JSON.parse(document.getElementById('variation-selector').dataset.variants);
        const btnSubmit = document.getElementById('btn-add-cart');
        const priceDisplay = document.getElementById('dynamic-price');
        const inputVariantId = document.getElementById('selected_variant_id');
        const inputVariantDetails = document.getElementById('selected_variant_details');

        // Base price jika varian belum dipilih
        const basePrice = {{ $product->price }};

        // Jika produk tidak punya varian, aktifkan tombol Add To Cart dengan variant_id kosong
        if(variants.length === 0) {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
            return;
        }

        let selectedSpecs = {};
        const totalKeys = {{ isset($availableAttributes) ? count($availableAttributes) : 0 }};

        document.querySelectorAll('.spec-btn').forEach(button => {
            button.addEventListener('click', function() {
                let key = this.dataset.key;

                // UX: Ganti warna tombol yang diklik (deselect yang lain)
                document.querySelectorAll(`.spec-btn[data-key="${key}"]`).forEach(btn => {
                    btn.classList.remove('bg-black', 'text-white', 'shadow-[4px_4px_0px_0px_#C5F277]');
                    btn.classList.add('bg-white');
                });

                this.classList.remove('bg-white');
                this.classList.add('bg-black', 'text-white', 'shadow-[4px_4px_0px_0px_#C5F277]');

                // Simpan spesifikasi yang dipilih
                selectedSpecs[key] = this.dataset.value;

                // Cek apakah semua kelompok spesifikasi sudah dipilih
                if (Object.keys(selectedSpecs).length === totalKeys) {
                    findMatchingVariant();
                }
            });
        });

        function findMatchingVariant() {
            const matchedVariant = variants.find(variant => {
                let isMatch = true;
                if(variant.attributes) {
                    for (const [key, value] of Object.entries(selectedSpecs)) {
                        if (variant.attributes[key] !== value) {
                            isMatch = false;
                            break;
                        }
                    }
                } else {
                    isMatch = false;
                }
                return isMatch;
            });

            if (matchedVariant) {
                // Konfigurasi ditemukan dan tersedia
                inputVariantId.value = matchedVariant.id;

                // Format spec details untuk disimpan ke database (misal: "RAM: 16GB, Storage: 512GB")
                let detailsString = Object.entries(selectedSpecs).map(([k, v]) => `${k}: ${v}`).join(', ');
                inputVariantDetails.value = detailsString;

                // Update Harga
                let finalPrice = matchedVariant.price > 0 ? matchedVariant.price : basePrice;
                priceDisplay.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(finalPrice);

                // Aktifkan Tombol
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
                btnSubmit.innerText = "Add_To_Cart";
            } else {
                // Kombinasi tidak tersedia di database
                inputVariantId.value = '';
                inputVariantDetails.value = '';
                priceDisplay.innerText = "Config Unavailable";

                btnSubmit.disabled = true;
                btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
                btnSubmit.innerText = "Invalid_Configuration";
            }
        }
    });
</script>
@endsection

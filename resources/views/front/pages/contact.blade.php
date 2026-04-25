@extends('layouts.front')

@section('title', 'Contact Support - SmartTech')

@section('content')
<main class="st-page-wrap">

    <section class="st-hero p-6 md:p-10 mb-6">
        <span class="st-eyebrow st-eyebrow-blue">
            Customer Support
        </span>

        <h1 class="st-hero-title text-3xl md:text-5xl mt-4">
            Butuh Bantuan?
            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500">
                Kami Siap Bantu.
            </span>
        </h1>

        <p class="st-hero-text mt-4 max-w-2xl">
            Tanya soal produk, pesanan, pembayaran, garansi, atau pengiriman. Tim SmartTech akan bantu arahin dengan jelas.
        </p>
    </section>

    <section class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">

        {{-- Contact Info --}}
        <div class="space-y-5">

            <div class="st-card p-6">
                <div class="flex items-start gap-4">
                    <div class="st-icon-blue shrink-0">✉️</div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
                            Email Support
                        </p>
                        <h3 class="mt-1 text-xl font-black text-slate-950 break-all">
                            support@smarttech.local
                        </h3>
                        <p class="st-muted mt-2 text-sm">
                            Cocok untuk pertanyaan produk, status pesanan, dan klaim garansi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="st-card p-6">
                <div class="flex items-start gap-4">
                    <div class="st-icon-orange shrink-0">☎️</div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
                            Customer Care
                        </p>
                        <h3 class="mt-1 text-xl font-black text-slate-950">
                            +62-8009-0010
                        </h3>
                        <p class="st-muted mt-2 text-sm">
                            Jam operasional: Senin–Jumat, 09.00–17.00 WIB.
                        </p>
                    </div>
                </div>
            </div>

            <div class="st-card p-6">
                <div class="flex items-start gap-4">
                    <div class="st-icon-green shrink-0">📍</div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">
                            Store Location
                        </p>
                        <h3 class="mt-1 text-xl font-black text-slate-950">
                            Cybernetics District
                        </h3>
                        <p class="st-muted mt-2 text-sm">
                            Sector 7, Jakarta, ID 12920
                        </p>
                    </div>
                </div>
            </div>

            <div class="st-card-soft p-5">
                <h3 class="st-title text-lg mb-3">
                    Tips Biar Lebih Cepat Dibantu
                </h3>

                <ul class="st-list">
                    <li>Cantumkan nomor order jika pertanyaannya soal transaksi.</li>
                    <li>Sertakan nama produk yang ingin ditanyakan.</li>
                    <li>Upload atau simpan screenshot pembayaran jika diperlukan.</li>
                </ul>
            </div>

        </div>

        {{-- Form --}}
        <div class="st-card p-6 md:p-8">
            <div class="mb-7">
                <span class="st-eyebrow">
                    Send Message
                </span>

                <h2 class="st-title mt-4 text-2xl md:text-3xl">
                    Kirim Pesan ke SmartTech
                </h2>

                <p class="st-muted mt-2 text-sm">
                    Isi detailnya sejelas mungkin supaya tim support bisa langsung bantu tanpa bolak-balik tanya.
                </p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>
                        <input type="text"
                               name="name"
                               class="st-input"
                               placeholder="Contoh: Zia"
                               required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Email
                        </label>
                        <input type="email"
                               name="email"
                               class="st-input"
                               placeholder="email@example.com"
                               required>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Topik Bantuan
                    </label>
                    <select name="topic" class="st-input">
                        <option value="product">Pertanyaan Produk</option>
                        <option value="order">Status Pesanan</option>
                        <option value="payment">Pembayaran</option>
                        <option value="warranty">Garansi / Retur</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Pesan
                    </label>
                    <textarea name="message"
                              rows="6"
                              class="st-input resize-none"
                              placeholder="Tulis detail kendala atau pertanyaan kamu di sini..."
                              required></textarea>
                </div>

                <button type="button"
                        onclick="alert('Support form masih demo. Hubungkan action form ini ke controller Laravel untuk mengirim pesan.')"
                        class="st-btn-accent w-full">
                    Kirim Pesan
                </button>

                <p class="text-center text-xs text-slate-500">
                    Dengan mengirim pesan, kamu menyetujui tim SmartTech menghubungi kamu terkait kebutuhan support.
                </p>
            </form>
        </div>

    </section>

</main>
@endsection

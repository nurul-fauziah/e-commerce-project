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
                    <div class="st-icon-blue shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg></div>
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
                    <div class="st-icon-orange shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg></div>
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
                    <div class="st-icon-green shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg></div>
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

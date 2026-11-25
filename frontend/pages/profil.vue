<template>
  <div class="space-y-10 pb-16">
    <!-- Header -->
    <div class="space-y-3">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/60 border border-blue-500/30 text-blue-400 text-xs font-semibold">
        <span>🏢</span> PROFIL PENGELOLA KAWASAN
      </div>
      <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
        Kawasan Industri Pulogadung (KIP)
      </h1>
      <p class="text-slate-400 max-w-3xl text-sm leading-relaxed">
        Kawasan industri pertama di Indonesia yang dikelola oleh PT Jakarta Industrial Estate Pulogadung (JIEP), didirikan bersama oleh Pemerintah Provinsi DKI Jakarta dan Pemerintah Republik Indonesia melalui PT Danareksa (Persero).
      </p>
    </div>

    <!-- Overview Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="card md:col-span-2 bg-slate-900/70 border-slate-700/60 space-y-6">
        <div>
          <h2 class="text-lg font-bold text-white mb-2">Tentang PT JIEP</h2>
          <p class="text-sm text-slate-300 leading-relaxed">
            PT Jakarta Industrial Estate Pulogadung (PT JIEP) didirikan pada tanggal 26 Juni 1973. Selama lebih dari lima dekade, PT JIEP telah menjadi pelopor pengembangan kawasan industri modern dan ramah lingkungan di wilayah metropolitan DKI Jakarta. Kawasan Industri Pulogadung dirancang strategis dengan akses transportasi terpadu untuk menopang rantai pasok industri nasional.
          </p>
        </div>

        <div class="border-t border-slate-800 pt-5 space-y-4">
          <h3 class="text-sm font-bold text-cyan-400 uppercase tracking-wider text-xs">Identitas & Legalitas Resmi</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="p-3 bg-slate-950/50 rounded-lg border border-slate-800">
              <span class="text-slate-500 block mb-1">Nama Resmi Pengelola</span>
              <span class="text-white font-medium">PT Jakarta Industrial Estate Pulogadung</span>
            </div>
            <div class="p-3 bg-slate-950/50 rounded-lg border border-slate-800">
              <span class="text-slate-500 block mb-1">Tanggal Pendirian</span>
              <span class="text-white font-medium">26 Juni 1973</span>
            </div>
            <div class="p-3 bg-slate-950/50 rounded-lg border border-slate-800">
              <span class="text-slate-500 block mb-1">Total Luas Lahan</span>
              <span class="text-white font-medium">433 Hektare</span>
            </div>
            <div class="p-3 bg-slate-950/50 rounded-lg border border-slate-800">
              <span class="text-slate-500 block mb-1">Lokasi Kawasan</span>
              <span class="text-white font-medium">Pulogadung, Jakarta Timur, DKI Jakarta</span>
            </div>
          </div>
        </div>

        <div class="border-t border-slate-800 pt-5 space-y-3">
          <h3 class="text-sm font-bold text-purple-400 uppercase tracking-wider text-xs">Struktur Kepemilikan Saham</h3>
          <div class="space-y-3">
            <div>
              <div class="flex justify-between text-xs mb-1">
                <span class="text-slate-300 font-medium">Pemerintah Provinsi DKI Jakarta</span>
                <span class="text-purple-400 font-bold">53,06%</span>
              </div>
              <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-full rounded-full" style="width: 53.06%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs mb-1">
                <span class="text-slate-300 font-medium">PT Danareksa (Persero) / Pemerintah Pusat</span>
                <span class="text-blue-400 font-bold">46,94%</span>
              </div>
              <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-full rounded-full" style="width: 46.94%"></div>
              </div>
            </div>
          </div>
          <p class="text-[11px] text-slate-500">Sumber: Laporan Tahunan PT Danareksa 2025 & Publikasi Resmi JIEP.</p>
        </div>
      </div>

      <!-- Contact & Office Info -->
      <div class="space-y-6">
        <div class="card bg-slate-900/70 border-slate-700/60 space-y-4">
          <h2 class="text-base font-bold text-white flex items-center gap-2">
            <span>📍</span> Kantor Pengelola JIEP
          </h2>
          <div class="text-xs text-slate-300 space-y-2 leading-relaxed">
            <p class="font-semibold text-white">Gedung Graha Dayaguna</p>
            <p>Jl. Pulobuaran V, Blok JJ-4, Kawasan Industri Pulogadung, Jakarta Timur, DKI Jakarta 13930</p>
          </div>
          <div class="pt-3 border-t border-slate-800 space-y-2 text-xs">
            <div class="flex items-center justify-between text-slate-400">
              <span>Telepon:</span>
              <span class="text-white font-mono">+62 21 4682 0449</span>
            </div>
            <div class="flex items-center justify-between text-slate-400">
              <span>Kanal Layanan:</span>
              <span class="text-white font-mono">(021) 3971 1973</span>
            </div>
            <div class="flex items-center justify-between text-slate-400">
              <span>Website:</span>
              <a href="https://jiep.co.id/" target="_blank" class="text-cyan-400 hover:underline">jiep.co.id</a>
            </div>
          </div>
        </div>

        <div class="card bg-slate-900/70 border-slate-700/60 space-y-3">
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <span>🛡️</span> Transparansi & Validitas Data
          </h3>
          <p class="text-xs text-slate-400 leading-relaxed">
            Data profil ini diverifikasi langsung dari sumber resmi pemerintah dan korporasi terbuka.
          </p>
          <div class="space-y-2 text-[11px]">
            <div class="p-2.5 rounded bg-emerald-950/40 border border-emerald-800/40 text-emerald-300 flex items-center gap-2">
              <span>✓</span> Data Kepemilikan & Luas: Terverifikasi
            </div>
            <div class="p-2.5 rounded bg-amber-950/40 border border-amber-800/40 text-amber-300 flex items-center gap-2">
              <span>⚠</span> Koordinat Geospasial Spesifik: Perlu Verifikasi
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

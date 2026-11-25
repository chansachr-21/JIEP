<template>
  <footer class="bg-navy-mid border-t border-slate-700/50 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Brand -->
        <div>
          <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center">
              <span class="text-white font-black text-sm">I</span>
            </div>
            <span class="font-bold text-white">INDUSTRIA</span>
          </div>
          <p class="text-sm text-slate-400 leading-relaxed">
            Platform informasi dan digitalisasi layanan Kawasan Industri Pulogadung (KIP), Jakarta Timur.
          </p>
          <div class="mt-3 p-3 rounded-lg bg-amber-900/20 border border-amber-700/30">
            <p class="text-xs text-amber-400">
              ⚠ Sistem Demonstrasi — Data bersumber dari publikasi resmi JIEP. Bukan sistem resmi PT JIEP.
            </p>
          </div>
        </div>

        <!-- Navigasi -->
        <div>
          <h3 class="text-sm font-semibold text-white mb-3">Navigasi</h3>
          <ul class="space-y-1.5">
            <li v-for="item in navItems" :key="item.to">
              <NuxtLink :to="item.to" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors">
                {{ item.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Sumber Data -->
        <div>
          <h3 class="text-sm font-semibold text-white mb-3">Sumber Resmi</h3>
          <ul class="space-y-1.5">
            <li v-for="src in sources" :key="src.url">
              <a :href="src.url" target="_blank" rel="noopener noreferrer" class="text-sm text-slate-400 hover:text-cyan-400 transition-colors flex items-center gap-1">
                <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                {{ src.name }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-8 pt-6 border-t border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-3">
        <p class="text-xs text-slate-500">© 2026 INDUSTRIA — Proyek Demonstrasi Inovasi Teknologi</p>
        <p class="text-xs text-slate-500">Dibuat untuk kompetisi Digital Innovation for Industry</p>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
const navItems = [
  { to: '/', label: 'Beranda' },
  { to: '/profil', label: 'Profil Kawasan' },
  { to: '/peta', label: 'Peta Digital' },
  { to: '/perusahaan', label: 'Direktori Perusahaan' },
  { to: '/fasilitas', label: 'Fasilitas & Layanan' },
  { to: '/pengaduan', label: 'Pengaduan' },
  { to: '/lowongan', label: 'Lowongan Kerja' },
  { to: '/pengumuman', label: 'Pengumuman' },
]

const sources = [
  { name: 'PT JIEP — jiep.co.id', url: 'https://jiep.co.id/' },
  { name: 'PPID JIEP', url: 'https://ppid.jiep.co.id/' },
  { name: 'Pemprov DKI Jakarta', url: 'https://www.jakarta.go.id/' },
  { name: 'PT Danareksa', url: 'https://www.danareksa.co.id/' },
]
</script>

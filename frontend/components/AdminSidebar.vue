<template>
  <aside class="w-64 min-h-screen bg-[#060b18] border-r border-slate-700/50 flex flex-col">
    <!-- Logo -->
    <div class="p-5 border-b border-slate-700/50">
      <NuxtLink to="/" class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center">
          <span class="text-white font-black text-sm">I</span>
        </div>
        <div>
          <div class="font-bold text-sm text-white">INDUSTRIA</div>
          <div class="text-[10px] text-slate-500">Admin Dashboard</div>
        </div>
      </NuxtLink>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-3 overflow-y-auto">
      <div class="mb-4">
        <p class="text-[10px] uppercase tracking-widest text-slate-500 px-3 mb-2">Utama</p>
        <div class="space-y-0.5">
          <NuxtLink
            v-for="item in mainMenu"
            :key="item.to"
            :to="item.to"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all group"
            active-class="text-white bg-blue-900/40 border border-blue-700/30"
            exact-active-class="text-white bg-blue-900/40 border border-blue-700/30"
          >
            <span class="text-base">{{ item.icon }}</span>
            {{ item.label }}
          </NuxtLink>
        </div>
      </div>

      <div>
        <p class="text-[10px] uppercase tracking-widest text-slate-500 px-3 mb-2">Data</p>
        <div class="space-y-0.5">
          <NuxtLink
            v-for="item in dataMenu"
            :key="item.to"
            :to="item.to"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all"
            active-class="text-white bg-blue-900/40 border border-blue-700/30"
          >
            <span class="text-base">{{ item.icon }}</span>
            {{ item.label }}
          </NuxtLink>
        </div>
      </div>
    </nav>

    <!-- Bottom - link ke publik -->
    <div class="p-3 border-t border-slate-700/50">
      <NuxtLink to="/" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all">
        <span>🌐</span>
        Lihat Halaman Publik
      </NuxtLink>
    </div>
  </aside>
</template>

<script setup lang="ts">
const mainMenu = [
  { to: '/admin', label: 'Overview', icon: '📊' },
  { to: '/admin/logs', label: 'Activity Logs', icon: '📋' },
]

const dataMenu = [
  { to: '/admin/perusahaan', label: 'Perusahaan', icon: '🏭' },
  { to: '/admin/fasilitas', label: 'Fasilitas', icon: '🏗️' },
  { to: '/admin/pengaduan', label: 'Pengaduan', icon: '📝' },
  { to: '/admin/lowongan', label: 'Lowongan Kerja', icon: '💼' },
  { to: '/admin/pengumuman', label: 'Pengumuman', icon: '📢' },
]
</script>

<template>
  <nav class="fixed top-0 left-0 right-0 z-50 bg-navy-mid/95 backdrop-blur-md border-b border-slate-700/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <NuxtLink to="/" class="flex items-center gap-2 group">
          <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all">
            <span class="text-white font-black text-sm">I</span>
          </div>
          <div>
            <span class="font-bold text-lg text-white tracking-wide">INDUSTRIA</span>
            <div class="text-[10px] text-cyan-400/70 leading-none -mt-0.5 hidden sm:block">Kawasan Industri Pulogadung</div>
          </div>
        </NuxtLink>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-1">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            class="px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all"
            active-class="text-cyan-400 bg-slate-700/50"
          >
            {{ item.label }}
          </NuxtLink>
        </div>

        <!-- Admin & Mobile -->
        <div class="flex items-center gap-2">
          <NuxtLink
            to="/admin"
            class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600/20 hover:bg-blue-600/30 border border-blue-500/30 text-blue-400 text-sm font-medium transition-all"
          >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Admin
          </NuxtLink>

          <!-- Mobile menu btn -->
          <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/50 transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile menu -->
      <div v-if="mobileOpen" class="md:hidden pb-4 border-t border-slate-700/50 mt-2 pt-2">
        <div class="flex flex-col gap-1">
          <NuxtLink
            v-for="item in navItems"
            :key="item.to"
            :to="item.to"
            @click="mobileOpen = false"
            class="px-3 py-2.5 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all"
            active-class="text-cyan-400 bg-slate-700/50"
          >
            {{ item.label }}
          </NuxtLink>
          <NuxtLink to="/admin" @click="mobileOpen = false" class="px-3 py-2.5 rounded-lg text-sm text-blue-400 hover:bg-blue-900/30 transition-all">
            ⚙ Dashboard Admin
          </NuxtLink>
        </div>
      </div>
    </div>
  </nav>
  <!-- Spacer -->
  <div class="h-16"></div>
</template>

<script setup lang="ts">
const mobileOpen = ref(false)

const navItems = [
  { to: '/', label: 'Beranda' },
  { to: '/profil', label: 'Profil Kawasan' },
  { to: '/peta', label: 'Peta Digital' },
  { to: '/perusahaan', label: 'Direktori Perusahaan' },
  { to: '/fasilitas', label: 'Fasilitas' },
  { to: '/pengaduan', label: 'Pengaduan' },
  { to: '/lowongan', label: 'Lowongan' },
  { to: '/pengumuman', label: 'Pengumuman' },
]
</script>

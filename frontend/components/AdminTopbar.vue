<template>
  <header class="h-14 bg-[#060b18]/95 backdrop-blur-md border-b border-slate-700/50 flex items-center px-6 justify-between">
    <div>
      <h1 class="text-sm font-semibold text-white">{{ title }}</h1>
      <p class="text-xs text-slate-500">Admin Dashboard — Sistem Demonstrasi</p>
    </div>
    <div class="flex items-center gap-3">
      <div class="px-2.5 py-1 rounded-full bg-amber-900/30 border border-amber-700/30 text-amber-400 text-xs">
        ⚠ Mode Demo
      </div>
      <div class="text-xs text-slate-500">{{ currentTime }}</div>
    </div>
  </header>
</template>

<script setup lang="ts">
const route = useRoute()
const currentTime = ref('')

const pageNames: Record<string, string> = {
  '/admin': 'Dashboard Overview',
  '/admin/perusahaan': 'Manajemen Perusahaan',
  '/admin/fasilitas': 'Manajemen Fasilitas',
  '/admin/pengaduan': 'Manajemen Pengaduan',
  '/admin/lowongan': 'Manajemen Lowongan Kerja',
  '/admin/pengumuman': 'Manajemen Pengumuman',
  '/admin/logs': 'Activity Logs',
}

const title = computed(() => pageNames[route.path] || 'Admin')

onMounted(() => {
  const updateTime = () => {
    currentTime.value = new Date().toLocaleString('id-ID', {
      hour: '2-digit', minute: '2-digit', second: '2-digit',
      day: '2-digit', month: 'short', year: 'numeric'
    })
  }
  updateTime()
  setInterval(updateTime, 1000)
})
</script>

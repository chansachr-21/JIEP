<template>
  <div class="space-y-8 pb-16">
    <!-- Header -->
    <div>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/60 border border-cyan-500/40 text-cyan-400 text-xs font-semibold mb-2">
        <span>📢</span> WARTA & PENGUMUMAN
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
        Pengumuman Kawasan Industri Pulogadung
      </h1>
      <p class="text-xs text-slate-400">
        Informasi terkini, pengumuman operasional dari PPID JIEP, serta warta sistem demonstrasi INDUSTRIA.
      </p>
    </div>

    <!-- Announcement list -->
    <div v-if="loading" class="space-y-4">
      <div v-for="i in 2" :key="i" class="card bg-slate-900/50 border-slate-800 h-32 animate-pulse"></div>
    </div>

    <div v-else class="space-y-4">
      <div
        v-for="ann in announcements"
        :key="ann.id"
        class="card bg-slate-900/80 border-slate-700/60 p-6 space-y-3"
      >
        <div class="flex flex-wrap items-center justify-between gap-2">
          <div class="flex items-center gap-2">
            <span
              :class="ann.is_demo ? 'bg-amber-950/60 text-amber-400 border-amber-800/60' : 'bg-blue-950/60 text-blue-400 border-blue-800/60'"
              class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border"
            >
              {{ ann.is_demo ? 'KONTEN DEMONSTRASI' : 'REFERENSI PPID JIEP' }}
            </span>
            <span class="text-xs px-2 py-0.5 rounded bg-slate-800 text-slate-400 border border-slate-700 capitalize">
              {{ ann.category }}
            </span>
          </div>
          <span class="text-xs text-slate-500 font-mono">{{ ann.published_at }}</span>
        </div>

        <h3 class="text-lg font-bold text-white">{{ ann.title }}</h3>
        
        <p class="text-xs text-slate-300 leading-relaxed whitespace-pre-line">
          {{ ann.content }}
        </p>

        <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-500">
          <span>Sumber: {{ ann.data_source || 'PPID PT JIEP' }}</span>
          <a v-if="ann.source_url" :href="ann.source_url" target="_blank" rel="noopener noreferrer" class="text-cyan-400 hover:underline font-semibold">
            Tautan Asli PPID &rarr;
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Announcement, PaginatedResponse } from '~/types'

const api = useApi()
const announcements = ref<Announcement[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get<PaginatedResponse<Announcement>>('/announcements')
    announcements.value = res.data || []
  } catch (err) {
    console.error('Error fetching announcements:', err)
  } finally {
    loading.value = false
  }
})
</script>

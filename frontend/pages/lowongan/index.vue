<template>
  <div class="space-y-8 pb-16">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/60 border border-blue-500/30 text-blue-400 text-xs font-semibold mb-2">
          <span>💼</span> INFORMASI KARIR
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
          Lowongan Kerja Kawasan Industri Pulogadung
        </h1>
        <p class="text-xs text-slate-400">
          Informasi kesempatan karir dan lowongan resmi di perusahaan kawasan industri.
        </p>
      </div>
    </div>

    <!-- Notice -->
    <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-400 flex items-start gap-3">
      <span class="text-base text-cyan-400">🛡️</span>
      <div>
        <span class="text-slate-200 font-semibold">Integritas Informasi:</span>
        Hanya lowongan yang benar-benar tercantum pada kanal resmi perusahaan tenant atau pengelola yang ditampilkan. Sistem ini tidak menyajikan lowongan kerja fiktif.
      </div>
    </div>

    <!-- Jobs Grid -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div v-for="i in 2" :key="i" class="card bg-slate-900/50 border-slate-800 h-36 animate-pulse"></div>
    </div>

    <div v-else-if="jobs.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div v-for="job in jobs" :key="job.id" class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-3">
        <div class="flex items-center justify-between gap-2">
          <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-950 text-blue-400 border border-blue-800 font-semibold uppercase">
            {{ job.employment_type || 'Full Time' }}
          </span>
          <VerificationBadge :status="job.verification_status" />
        </div>
        <h3 class="text-base font-bold text-white">{{ job.title }}</h3>
        <p class="text-xs text-cyan-400 font-semibold">{{ job.company_name }}</p>
        <p class="text-xs text-slate-400 line-clamp-2">{{ job.description }}</p>
        <div class="pt-3 border-t border-slate-800 flex items-center justify-between text-[11px] text-slate-500">
          <span>Batas: {{ job.deadline || 'Sesuai publikasi' }}</span>
          <a v-if="job.source_url" :href="job.source_url" target="_blank" class="text-cyan-400 hover:underline font-semibold">Sumber Resmi &rarr;</a>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="card bg-slate-900/40 border-slate-800 p-12 text-center space-y-3">
      <div class="text-3xl">💼</div>
      <h3 class="text-sm font-bold text-white">Belum Ada Lowongan Terverifikasi</h3>
      <p class="text-xs text-slate-400 max-w-sm mx-auto">
        Saat ini belum ada informasi lowongan kerja yang telah lolos verifikasi dari sumber resmi perusahaan di KIP.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { JobVacancy, PaginatedResponse } from '~/types'

const api = useApi()
const jobs = ref<JobVacancy[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get<PaginatedResponse<JobVacancy>>('/jobs')
    jobs.value = res.data || []
  } catch (err) {
    console.error('Error fetching jobs:', err)
  } finally {
    loading.value = false
  }
})
</script>

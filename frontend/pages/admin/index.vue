<template>
  <div class="space-y-8 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Ringkasan Sistem & Verifikasi Data</h2>
        <p class="text-xs text-slate-400">Statistik real-time database demonstrasi INDUSTRIA</p>
      </div>
      <div class="flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
        <span class="text-xs font-mono text-emerald-400">API ONLINE (Port 8000)</span>
      </div>
    </div>

    <!-- Quick Stat Cards -->
    <div v-if="stats" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-1">
        <span class="text-xs text-slate-400">Total Perusahaan</span>
        <div class="text-2xl font-bold text-white">{{ stats.summary.total_companies }}</div>
        <p class="text-[11px] text-emerald-400 font-medium">✓ {{ stats.summary.verified_companies }} Terverifikasi</p>
      </div>
      <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-1">
        <span class="text-xs text-slate-400">Total Fasilitas</span>
        <div class="text-2xl font-bold text-cyan-400">{{ stats.summary.total_facilities }}</div>
        <p class="text-[11px] text-slate-500">11 Kategori resmi JIEP</p>
      </div>
      <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-1">
        <span class="text-xs text-slate-400">Pengaduan Demo</span>
        <div class="text-2xl font-bold text-amber-400">{{ stats.summary.total_complaints }}</div>
        <p class="text-[11px] text-amber-400/80 font-medium">{{ stats.summary.open_complaints }} Belum Selesai</p>
      </div>
      <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-1">
        <span class="text-xs text-slate-400">Pengumuman & Warta</span>
        <div class="text-2xl font-bold text-purple-400">{{ stats.summary.total_announcements }}</div>
        <p class="text-[11px] text-slate-500">Publikasi aktif</p>
      </div>
    </div>

    <!-- Data Quality & Verification Metrics -->
    <div v-if="stats" class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
          <span>📊</span> Status Verifikasi Data Perusahaan
        </h3>
        <div class="space-y-3 text-xs">
          <div>
            <div class="flex justify-between text-slate-300 mb-1">
              <span>Terverifikasi (verified)</span>
              <span class="text-emerald-400 font-bold">{{ stats.verification_stats.companies.verified }}</span>
            </div>
            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
              <div class="bg-emerald-500 h-full" :style="{ width: `${(stats.verification_stats.companies.verified / (stats.summary.total_companies || 1)) * 100}%` }"></div>
            </div>
          </div>
          <div>
            <div class="flex justify-between text-slate-300 mb-1">
              <span>Perlu Verifikasi (needs_verification)</span>
              <span class="text-amber-400 font-bold">{{ stats.verification_stats.companies.needs_verification }}</span>
            </div>
            <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
              <div class="bg-amber-500 h-full" :style="{ width: `${(stats.verification_stats.companies.needs_verification / (stats.summary.total_companies || 1)) * 100}%` }"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
          <span>📝</span> Status Pengaduan Demo Masuk
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
          <div v-for="(count, status) in stats.complaints_by_status" :key="status" class="p-3 bg-slate-950 rounded-lg border border-slate-800 text-center">
            <span class="text-slate-500 block uppercase text-[10px]">{{ status }}</span>
            <span class="text-lg font-bold text-white">{{ count }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="flex items-center justify-between">
        <h3 class="text-sm font-bold text-white flex items-center gap-2">
          <span>📋</span> Log Aktivitas Terbaru (Audit Trail)
        </h3>
        <NuxtLink to="/admin/logs" class="text-xs text-cyan-400 hover:underline">Semua Log &rarr;</NuxtLink>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Waktu</th>
              <th class="pb-2.5 font-semibold">Aksi</th>
              <th class="pb-2.5 font-semibold">Tabel</th>
              <th class="pb-2.5 font-semibold">Deskripsi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="log in recentLogs" :key="log.id" class="hover:bg-slate-800/40">
              <td class="py-2.5 font-mono text-[11px] text-slate-500">{{ new Date(log.created_at).toLocaleTimeString('id-ID') }}</td>
              <td class="py-2.5">
                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-800 text-cyan-400">
                  {{ log.action }}
                </span>
              </td>
              <td class="py-2.5 font-mono text-slate-400">{{ log.table_name }}</td>
              <td class="py-2.5 text-slate-300">{{ log.description }}</td>
            </tr>
            <tr v-if="recentLogs.length === 0">
              <td colspan="4" class="py-6 text-center text-slate-500">Belum ada aktivitas tercatat.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { DashboardStats, ActivityLog } from '~/types'

definePageMeta({
  layout: 'admin',
})

const api = useApi()
const stats = ref<DashboardStats | null>(null)
const recentLogs = ref<ActivityLog[]>([])

onMounted(async () => {
  try {
    const [statsRes, logsRes] = await Promise.allSettled([
      api.get<{ data: DashboardStats }>('/admin/dashboard/stats'),
      api.get<{ data: ActivityLog[] }>('/admin/dashboard/recent-activity'),
    ])

    if (statsRes.status === 'fulfilled' && statsRes.value.data) {
      stats.value = statsRes.value.data
    }
    if (logsRes.status === 'fulfilled' && logsRes.value.data) {
      recentLogs.value = logsRes.value.data
    }
  } catch (err) {
    console.error('Error fetching dashboard stats:', err)
  }
})
</script>

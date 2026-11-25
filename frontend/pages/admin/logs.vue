<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Audit Trail & Activity Logs</h2>
        <p class="text-xs text-slate-400">Pencatatan riwayat setiap penambahan, pembaruan, dan penghapusan data</p>
      </div>
      <button @click="fetchLogs" class="px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white text-xs border border-slate-700">
        🔄 Refresh
      </button>
    </div>

    <!-- Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Waktu Pencatatan</th>
              <th class="pb-2.5 font-semibold">Aksi</th>
              <th class="pb-2.5 font-semibold">Tabel Terkait</th>
              <th class="pb-2.5 font-semibold">ID Record</th>
              <th class="pb-2.5 font-semibold">Ringkasan Tindakan</th>
              <th class="pb-2.5 font-semibold">IP Origin</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="log in logs" :key="log.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-mono text-[11px] text-slate-500">{{ new Date(log.created_at).toLocaleString('id-ID') }}</td>
              <td class="py-3">
                <span
                  :class="[
                    'px-2 py-0.5 rounded text-[10px] font-bold uppercase font-mono',
                    log.action === 'create' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' :
                    log.action === 'update' ? 'bg-blue-950 text-blue-400 border border-blue-800' :
                    log.action === 'delete' ? 'bg-rose-950 text-rose-400 border border-rose-800' :
                    'bg-purple-950 text-purple-400 border border-purple-800'
                  ]"
                >
                  {{ log.action }}
                </span>
              </td>
              <td class="py-3 font-mono text-slate-400">{{ log.table_name }}</td>
              <td class="py-3 font-mono text-slate-500">{{ log.record_id || '-' }}</td>
              <td class="py-3 text-slate-300">{{ log.description }}</td>
              <td class="py-3 font-mono text-slate-500 text-[11px]">{{ log.ip_address || '127.0.0.1' }}</td>
            </tr>
            <tr v-if="logs.length === 0">
              <td colspan="6" class="py-8 text-center text-slate-500">Belum ada riwayat aktivitas tercatat.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { ActivityLog, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const logs = ref<ActivityLog[]>([])

const fetchLogs = async () => {
  try {
    const res = await api.get<PaginatedResponse<ActivityLog>>('/admin/activity-logs', { per_page: 50 })
    logs.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  fetchLogs()
})
</script>

<template>
  <div class="space-y-8 pb-16 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="text-center space-y-2">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/60 border border-cyan-500/40 text-cyan-400 text-xs font-semibold">
        <span>🔍</span> PELACAKAN STATUS TIKET
      </div>
      <h1 class="text-3xl font-extrabold text-white tracking-tight">
        Tracking Pengaduan
      </h1>
      <p class="text-xs text-slate-400">
        Masukkan nomor tiket pengaduan untuk melihat histori dan status penanganan tindak lanjut.
      </p>
    </div>

    <!-- Search Input -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-4 sm:p-6">
      <form @submit.prevent="handleTrack" class="flex gap-3">
        <input
          v-model="ticketNumber"
          type="text"
          placeholder="Contoh: IND-20261124-0001"
          class="flex-1 px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 font-mono"
        />
        <button
          type="submit"
          :disabled="loading"
          class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl text-xs transition-all disabled:opacity-50"
        >
          {{ loading ? 'Mencari...' : 'Lacak Tiket' }}
        </button>
      </form>
    </div>

    <!-- Result -->
    <div v-if="complaint" class="card bg-slate-900/80 border-slate-700/60 p-6 space-y-6">
      <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-800 pb-4">
        <div>
          <span class="text-xs font-mono text-cyan-400 font-bold block">{{ complaint.complaint_number }}</span>
          <h2 class="text-lg font-bold text-white mt-1">{{ complaint.title }}</h2>
        </div>
        <span
          :class="[
            'px-3 py-1 rounded-full text-xs font-bold uppercase border',
            complaint.status === 'selesai' ? 'bg-emerald-950 text-emerald-400 border-emerald-800' :
            complaint.status === 'diproses' ? 'bg-blue-950 text-blue-400 border-blue-800' :
            complaint.status === 'ditinjau' ? 'bg-purple-950 text-purple-400 border-purple-800' :
            complaint.status === 'ditolak' ? 'bg-rose-950 text-rose-400 border-rose-800' :
            'bg-amber-950 text-amber-400 border-amber-800'
          ]"
        >
          Status: {{ complaint.status }}
        </span>
      </div>

      <!-- Details -->
      <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Kategori</span>
          <span class="text-white font-medium capitalize">{{ complaint.category }}</span>
        </div>
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Lokasi</span>
          <span class="text-white font-medium">{{ complaint.location || '-' }}</span>
        </div>
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Tanggal Lapor</span>
          <span class="text-white font-mono">{{ new Date(complaint.created_at).toLocaleDateString('id-ID') }}</span>
        </div>
      </div>

      <div class="space-y-1 text-xs">
        <h4 class="text-slate-400 font-semibold">Deskripsi Laporan:</h4>
        <p class="text-slate-300 leading-relaxed bg-slate-950/50 p-3 rounded-lg border border-slate-800">
          {{ complaint.description }}
        </p>
      </div>

      <!-- Status Timeline -->
      <div class="space-y-3 pt-3 border-t border-slate-800">
        <h4 class="text-xs font-bold text-cyan-400 uppercase tracking-wider">Riwayat Status Penanganan</h4>
        <div class="relative pl-6 space-y-4 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-800">
          <div
            v-for="(hist, idx) in complaint.status_histories"
            :key="idx"
            class="relative space-y-1 text-xs"
          >
            <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-cyan-500 border-2 border-slate-900"></div>
            <div class="flex items-center gap-2">
              <span class="font-bold text-white capitalize">{{ hist.status }}</span>
              <span class="text-[10px] text-slate-500">{{ new Date(hist.created_at).toLocaleString('id-ID') }}</span>
            </div>
            <p v-if="hist.note" class="text-slate-400 text-[11px]">{{ hist.note }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import type { Complaint } from '~/types'

const route = useRoute()
const api = useApi()
const toast = useToast()

const ticketNumber = ref('')
const loading = ref(false)
const complaint = ref<Complaint | null>(null)

const handleTrack = async () => {
  if (!ticketNumber.value.trim()) {
    toast.error('Masukkan nomor pengaduan.')
    return
  }

  loading.value = true
  complaint.value = null

  try {
    const res: any = await api.get(`/complaints/track/${ticketNumber.value.trim()}`)
    complaint.value = res.data
  } catch (err: any) {
    toast.error(err.message || 'Nomor tiket tidak ditemukan.')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  if (route.query.number) {
    ticketNumber.value = String(route.query.number)
    handleTrack()
  }
})
</script>

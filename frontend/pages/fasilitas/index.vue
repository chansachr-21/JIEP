<template>
  <div class="space-y-8 pb-16">
    <!-- Header -->
    <div>
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/60 border border-cyan-500/40 text-cyan-400 text-xs font-semibold mb-2">
        <span>🏗️</span> SARANA & PRASARANA
      </div>
      <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
        Fasilitas & Layanan Kawasan Industri Pulogadung
      </h1>
      <p class="text-xs text-slate-400">
        Kategori fasilitas industri resmi yang dikembangkan dan dikelola oleh PT Jakarta Industrial Estate Pulogadung.
      </p>
    </div>

    <!-- Facilities List -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div v-for="i in 6" :key="i" class="card bg-slate-900/50 border-slate-800 h-44 animate-pulse"></div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div
        v-for="f in facilities"
        :key="f.id"
        class="card bg-slate-900/80 border-slate-700/60 hover:border-cyan-500/40 transition-all flex flex-col justify-between"
      >
        <div class="space-y-3">
          <div class="flex items-center justify-between gap-2">
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 text-cyan-400 border border-slate-700 uppercase font-semibold">
              {{ f.category }}
            </span>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-950/60 text-amber-400 border border-amber-800/60 font-medium">
              {{ f.operational_status }}
            </span>
          </div>

          <h3 class="text-base font-bold text-white tracking-tight">{{ f.name }}</h3>
          
          <p class="text-xs text-slate-300 leading-relaxed">
            {{ f.description || 'Fasilitas resmi kawasan untuk mendukung operasional industri tenant.' }}
          </p>
        </div>

        <div class="pt-3 mt-4 border-t border-slate-800 text-[11px] text-slate-500 flex items-center justify-between">
          <span>Sumber: {{ f.data_source || 'PT JIEP' }}</span>
          <VerificationBadge :status="f.verification_status" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Facility, PaginatedResponse } from '~/types'

const api = useApi()
const facilities = ref<Facility[]>([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get<PaginatedResponse<Facility>>('/facilities', { per_page: 30 })
    facilities.value = res.data || []
  } catch (err) {
    console.error('Error fetching facilities:', err)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="space-y-8 pb-16">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/60 border border-blue-500/30 text-blue-400 text-xs font-semibold mb-2">
          <span>🏭</span> DIREKTORI KAWASAN
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
          Direktori Perusahaan & Tenant KIP
        </h1>
        <p class="text-xs text-slate-400">
          Daftar tenant dan perusahaan yang terverifikasi berada di Kawasan Industri Pulogadung.
        </p>
      </div>

      <!-- Search & Filters -->
      <div class="flex flex-wrap items-center gap-3">
        <div class="relative w-full sm:w-64">
          <input
            v-model="search"
            @input="handleSearch"
            type="text"
            placeholder="Cari nama perusahaan..."
            class="w-full px-3.5 py-2 pl-9 bg-slate-900 border border-slate-700 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500"
          />
          <span class="absolute left-3 top-2.5 text-xs text-slate-500">🔍</span>
        </div>
      </div>
    </div>

    <!-- Notice Data Verifikasi -->
    <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-400 flex items-start gap-3">
      <span class="text-base text-cyan-400">ℹ️</span>
      <div>
        <span class="text-slate-200 font-semibold">Prinsip Validitas Data:</span>
        INDUSTRIA hanya menampilkan profil perusahaan yang telah diverifikasi silang dengan dokumen resmi pengelola atau dokumen terbuka korporasi. Data yang belum diverifikasi tidak dicantumkan sebagai fakta.
      </div>
    </div>

    <!-- Company Grid -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div v-for="i in 3" :key="i" class="card bg-slate-900/50 border-slate-800 h-48 animate-pulse"></div>
    </div>

    <div v-else-if="companies.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <div
        v-for="company in companies"
        :key="company.id"
        class="card bg-slate-900/80 border-slate-700/60 hover:border-cyan-500/50 transition-all flex flex-col justify-between"
      >
        <div class="space-y-3">
          <div class="flex items-center justify-between gap-2">
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700 uppercase font-semibold">
              {{ company.category || 'Tenant Kawasan' }}
            </span>
            <VerificationBadge :status="company.verification_status" />
          </div>

          <h3 class="text-base font-bold text-white tracking-tight">{{ company.name }}</h3>
          
          <p class="text-xs text-slate-400 leading-relaxed line-clamp-3">
            {{ company.description || 'Informasi deskripsi perusahaan sedang dalam proses pembaruan data.' }}
          </p>
        </div>

        <div class="pt-4 mt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
          <span class="text-[11px] text-slate-500 truncate max-w-[180px]">
            📍 {{ company.address || 'Kawasan Industri Pulogadung' }}
          </span>
          <NuxtLink :to="`/perusahaan/${company.id}`" class="text-cyan-400 hover:text-cyan-300 font-semibold flex items-center gap-1">
            Detail &rarr;
          </NuxtLink>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="card bg-slate-900/40 border-slate-800 p-12 text-center space-y-3">
      <div class="text-3xl">🏭</div>
      <h3 class="text-sm font-bold text-white">Tidak Ada Perusahaan Ditemukan</h3>
      <p class="text-xs text-slate-400 max-w-sm mx-auto">
        Tidak ditemukan data perusahaan yang cocok dengan kriteria pencarian Anda.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Company, PaginatedResponse } from '~/types'

const api = useApi()
const companies = ref<Company[]>([])
const loading = ref(true)
const search = ref('')

const fetchCompanies = async () => {
  loading.value = true
  try {
    const res = await api.get<PaginatedResponse<Company>>('/companies', {
      search: search.value,
      per_page: 20
    })
    companies.value = res.data || []
  } catch (err) {
    console.error('Error fetching companies:', err)
  } finally {
    loading.value = false
  }
}

let timeout: any = null
const handleSearch = () => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    fetchCompanies()
  }, 350)
}

onMounted(() => {
  fetchCompanies()
})
</script>

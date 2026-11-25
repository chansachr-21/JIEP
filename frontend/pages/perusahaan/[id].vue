<template>
  <div class="space-y-8 pb-16 max-w-4xl mx-auto">
    <!-- Back Link -->
    <NuxtLink to="/perusahaan" class="inline-flex items-center gap-2 text-xs text-slate-400 hover:text-cyan-400 font-medium transition-colors">
      &larr; Kembali ke Direktori Perusahaan
    </NuxtLink>

    <div v-if="loading" class="card bg-slate-900/50 border-slate-800 p-10 animate-pulse h-64"></div>

    <div v-else-if="company" class="card bg-slate-900/80 border-slate-700/60 p-6 sm:p-8 space-y-6">
      <!-- Title & Badges -->
      <div class="space-y-3 border-b border-slate-800 pb-5">
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-950 text-blue-400 border border-blue-800 font-semibold uppercase">
            {{ company.category || 'Tenant Kawasan' }}
          </span>
          <VerificationBadge :status="company.verification_status" />
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
          {{ company.name }}
        </h1>
        <p class="text-xs text-slate-500">
          Data Source: {{ company.data_source || 'Dokumen Resmi PT JIEP' }}
        </p>
      </div>

      <!-- Description -->
      <div class="space-y-2">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi & Profil Perusahaan</h3>
        <p class="text-sm text-slate-300 leading-relaxed whitespace-pre-line">
          {{ company.description || 'Informasi deskripsi detail belum tersedia atau dalam proses verifikasi.' }}
        </p>
      </div>

      <!-- Company Details Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-4 border-t border-slate-800">
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Alamat Operasional di KIP</span>
          <span class="text-white font-medium">{{ company.address || 'Kawasan Industri Pulogadung, Jakarta Timur' }}</span>
        </div>
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Website Resmi</span>
          <a v-if="company.website" :href="company.website" target="_blank" rel="noopener noreferrer" class="text-cyan-400 hover:underline font-medium">
            {{ company.website }}
          </a>
          <span v-else class="text-slate-500 italic">Tidak tersedia / belum diverifikasi</span>
        </div>
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Status Verifikasi</span>
          <span class="text-emerald-400 font-semibold">{{ company.verification_status }}</span>
        </div>
        <div class="p-3 bg-slate-950 rounded-lg border border-slate-800">
          <span class="text-slate-500 block mb-1">Terakhir Diperbarui</span>
          <span class="text-slate-300 font-mono">{{ company.last_verified_at || company.updated_at }}</span>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="card bg-slate-900/40 border-slate-800 p-12 text-center space-y-3">
      <div class="text-3xl">⚠️</div>
      <h3 class="text-sm font-bold text-white">Data Perusahaan Tidak Ditemukan</h3>
      <p class="text-xs text-slate-400">ID perusahaan yang dicari tidak terdaftar dalam database demonstrasi.</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import type { Company } from '~/types'

const route = useRoute()
const api = useApi()
const company = ref<Company | null>(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get<{ data: Company }>(`/companies/${route.params.id}`)
    company.value = res.data
  } catch (err) {
    console.error('Error fetching company detail:', err)
  } finally {
    loading.value = false
  }
})
</script>

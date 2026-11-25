<template>
  <div class="space-y-12 pb-16">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-navy-mid to-[#050914] border border-slate-700/60 p-8 sm:p-14 shadow-2xl">
      <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

      <div class="relative z-10 max-w-3xl space-y-6">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-cyan-950/60 border border-cyan-500/40 text-cyan-400 text-xs font-medium tracking-wide">
          <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
          DIGITAL INNOVATION FOR INDUSTRY — JAKARTA TIMUR
        </div>
        
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
          Kawasan Industri Pulogadung <br />
          <span class="gradient-text">Terintegrasi & Terdigitalisasi</span>
        </h1>
        
        <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
          INDUSTRIA menghadirkan platform transparansi data, direktori terverifikasi, peta geospasial kawasan, dan sistem layanan interaktif untuk Kawasan Industri Pulogadung yang dikelola oleh PT Jakarta Industrial Estate Pulogadung (JIEP).
        </p>

        <div class="flex flex-wrap items-center gap-3 pt-2">
          <NuxtLink to="/peta" class="px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-semibold text-sm shadow-lg shadow-blue-500/25 transition-all flex items-center gap-2">
            <span>🗺️</span> Jelajahi Peta Kawasan
          </NuxtLink>
          <NuxtLink to="/perusahaan" class="px-5 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 text-slate-200 font-semibold text-sm transition-all flex items-center gap-2">
            <span>🏭</span> Direktori Perusahaan
          </NuxtLink>
          <NuxtLink to="/pengaduan" class="px-5 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 text-slate-200 font-semibold text-sm transition-all flex items-center gap-2">
            <span>📝</span> Pengaduan Demo
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Key Statistics -->
    <section>
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-white tracking-tight">Statistik Kawasan</h2>
          <p class="text-xs text-slate-400">Ringkasan metrik resmi Kawasan Industri Pulogadung</p>
        </div>
        <span class="text-xs text-slate-500">Sumber: PT JIEP & Pemprov DKI</span>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="card bg-slate-900/60 border-slate-800/80 p-5 space-y-1">
          <span class="text-xs text-slate-400 font-medium">Luas Kawasan</span>
          <div class="text-2xl sm:text-3xl font-extrabold text-cyan-400">433 <span class="text-sm font-normal text-slate-400">Ha</span></div>
          <p class="text-[11px] text-slate-500">Kawasan industri pertama di DKI Jakarta</p>
        </div>
        <div class="card bg-slate-900/60 border-slate-800/80 p-5 space-y-1">
          <span class="text-xs text-slate-400 font-medium">Tahun Berdiri</span>
          <div class="text-2xl sm:text-3xl font-extrabold text-blue-400">1973</div>
          <p class="text-[11px] text-slate-500">26 Juni 1973 (50+ tahun pengalaman)</p>
        </div>
        <div class="card bg-slate-900/60 border-slate-800/80 p-5 space-y-1">
          <span class="text-xs text-slate-400 font-medium">Estimasi Tenant</span>
          <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">&gt;500</div>
          <p class="text-[11px] text-slate-500">Berdasarkan Lap. Tahunan Danareksa</p>
        </div>
        <div class="card bg-slate-900/60 border-slate-800/80 p-5 space-y-1">
          <span class="text-xs text-slate-400 font-medium">Struktur Kepemilikan</span>
          <div class="text-xl sm:text-2xl font-extrabold text-purple-400">53.06% / 46.94%</div>
          <p class="text-[11px] text-slate-500">Pemprov DKI Jakarta & PT Danareksa</p>
        </div>
      </div>
    </section>

    <!-- Interactive Map Preview Section -->
    <section class="space-y-4">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-white tracking-tight">Peta Digital Kawasan (Preview)</h2>
          <p class="text-xs text-slate-400">Menampilkan lokasi dan titik akses dengan koordinat terverifikasi</p>
        </div>
        <NuxtLink to="/peta" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
          Buka Peta Penuh &rarr;
        </NuxtLink>
      </div>

      <ClientOnly>
        <IndustrialMap :locations="mapLocations" :loading="mapLoading" />
        <template #fallback>
          <div class="w-full h-[400px] rounded-2xl bg-slate-900/50 border border-slate-800 flex items-center justify-center text-slate-500 text-xs">
            Memuat Peta Geospasial...
          </div>
        </template>
      </ClientOnly>
    </section>

    <!-- Verified Companies Highlight -->
    <section class="space-y-4">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-white tracking-tight">Perusahaan Terverifikasi di KIP</h2>
          <p class="text-xs text-slate-400">Data tenant yang telah diverifikasi silang dengan dokumen resmi</p>
        </div>
        <NuxtLink to="/perusahaan" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300">
          Lihat Semua &rarr;
        </NuxtLink>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div v-for="company in verifiedCompanies" :key="company.id" class="card bg-slate-900/70 border-slate-700/60 hover:border-slate-600 transition-all">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="flex items-center gap-2 mb-1">
                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-950 text-blue-400 border border-blue-800">
                  {{ company.category || 'Tenant Kawasan' }}
                </span>
                <VerificationBadge :status="company.verification_status" />
              </div>
              <h3 class="text-lg font-bold text-white">{{ company.name }}</h3>
              <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ company.description }}</p>
            </div>
          </div>
          <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
            <span>📍 {{ company.address || 'Kawasan Industri Pulogadung' }}</span>
            <NuxtLink :to="`/perusahaan/${company.id}`" class="text-cyan-400 hover:underline font-medium">Detail &rarr;</NuxtLink>
          </div>
        </div>

        <div v-if="verifiedCompanies.length === 0" class="col-span-full p-8 text-center bg-slate-900/40 rounded-xl border border-slate-800 text-slate-500 text-xs">
          Memuat data perusahaan terverifikasi...
        </div>
      </div>
    </section>

    <!-- Facilities Grid Preview -->
    <section class="space-y-4">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-white tracking-tight">Fasilitas & Layanan Kawasan</h2>
          <p class="text-xs text-slate-400">11 Kategori fasilitas resmi tercantum pada publikasi PT JIEP</p>
        </div>
        <NuxtLink to="/fasilitas" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300">
          Lihat Semua Fasilitas &rarr;
        </NuxtLink>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <div v-for="f in facilityHighlights" :key="f.name" class="p-4 rounded-xl bg-slate-900/50 border border-slate-800 hover:border-cyan-500/40 transition-all space-y-1">
          <div class="text-xl mb-1">{{ f.icon }}</div>
          <h4 class="text-sm font-semibold text-white">{{ f.name }}</h4>
          <p class="text-[11px] text-slate-400 line-clamp-2">{{ f.desc }}</p>
        </div>
      </div>
    </section>

    <!-- Latest Announcements & System Notice -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="md:col-span-2 space-y-4">
        <div class="flex items-center justify-between">
          <h2 class="text-xl font-bold text-white tracking-tight">Pengumuman & Pembaruan</h2>
          <NuxtLink to="/pengumuman" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300">Semua Pengumuman &rarr;</NuxtLink>
        </div>

        <div class="space-y-3">
          <div v-for="ann in announcements" :key="ann.id" class="p-4 rounded-xl bg-slate-900/70 border border-slate-800 space-y-2">
            <div class="flex items-center justify-between gap-2">
              <span :class="ann.is_demo ? 'bg-amber-950/60 text-amber-400 border border-amber-800/60' : 'bg-blue-950/60 text-blue-400 border border-blue-800/60'" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                {{ ann.is_demo ? 'KONTEN DEMO' : 'RESMI / REFERENSI' }}
              </span>
              <span class="text-[11px] text-slate-500">{{ ann.published_at }}</span>
            </div>
            <h3 class="text-sm font-bold text-white">{{ ann.title }}</h3>
            <p class="text-xs text-slate-300 line-clamp-2">{{ ann.content }}</p>
          </div>
        </div>
      </div>

      <!-- Quick Demo Info -->
      <div class="card bg-slate-900/90 border-slate-700/60 p-5 space-y-4 flex flex-col justify-between">
        <div class="space-y-3">
          <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-950 text-blue-400 border border-blue-800 text-[11px] font-semibold">
            <span>🛡️</span> Lingkungan Demonstrasi
          </div>
          <h3 class="text-base font-bold text-white">Digital Innovation for Industry</h3>
          <p class="text-xs text-slate-400 leading-relaxed">
            Aplikasi ini mendemonstrasikan transparansi data geospasial kawasan industri, pelacakan pengaduan demo tanpa login, dan pengelolaan data publik yang terstruktur.
          </p>
          <div class="p-3 rounded-lg bg-slate-950 border border-slate-800 space-y-1.5 text-xs">
            <div class="flex items-center justify-between text-slate-400">
              <span>Status API:</span>
              <span class="text-emerald-400 font-bold">Terhubung</span>
            </div>
            <div class="flex items-center justify-between text-slate-400">
              <span>Database:</span>
              <span class="text-cyan-400 font-mono">industria_db</span>
            </div>
          </div>
        </div>

        <NuxtLink to="/admin" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-600 text-center text-xs font-bold text-cyan-400 transition-all block">
          ⚙ Buka Dashboard Admin (Publik)
        </NuxtLink>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Company, MapLocation, Announcement } from '~/types'

const api = useApi()

const defaultLocations: MapLocation[] = [
  { id: 'estate-1', type: 'estate', label: 'Kantor Pengelola', name: 'PT JIEP (Gedung Graha Dayaguna)', latitude: -6.19428, longitude: 106.91979, description: 'Gedung Graha Dayaguna, Jl. Pulobuaran V, Blok JJ-4, Kawasan Industri Pulogadung', verification_status: 'verified' },
  { id: 'company-1', type: 'company', label: 'Perusahaan', name: 'PT Hexindo Adiperkasa Tbk', latitude: -6.196046, longitude: 106.908966, description: 'Jl. Pulo Kambing II Kav. I-II No. 33, Kawasan Industri Pulogadung', category: 'alat-berat', verification_status: 'verified', link_id: 1 },
  { id: 'facility-4', type: 'facility', label: 'Fasilitas', name: 'Business Center JIEP', latitude: -6.1935, longitude: 106.9182, description: 'Pusat bisnis yang menyediakan ruang perkantoran dan fasilitas pendukung kegiatan usaha di dalam kawasan industri.', category: 'perkantoran', verification_status: 'verified' },
  { id: 'facility-6', type: 'facility', label: 'Fasilitas', name: 'Food Center KIP', latitude: -6.191, longitude: 106.9075, description: 'Pusat kuliner yang menyediakan berbagai pilihan makanan dan minuman untuk pengguna kawasan industri.', category: 'layanan_umum', verification_status: 'verified' },
  { id: 'facility-10', type: 'facility', label: 'Fasilitas', name: 'Sentra Usaha Industri Kecil (SUIK)', latitude: -6.1852, longitude: 106.9035, description: 'Fasilitas bagi usaha industri kecil dan menengah yang beroperasi di dalam kawasan industri Pulogadung.', category: 'ukm', verification_status: 'verified' },
  { id: 'access-1', type: 'access', label: 'Akses Kawasan', name: 'Akses Utama Jl. Pulogadung Raya', latitude: -6.182, longitude: 106.9005, description: 'Gerbang utama E-Gate Kawasan Industri Pulogadung (PPID JIEP)', verification_status: 'verified' },
  { id: 'access-2', type: 'access', label: 'Akses Kawasan', name: 'Akses Utama Jl. Pulolentut', latitude: -6.1883, longitude: 106.8998, description: 'Gerbang barat E-Gate Kawasan Industri Pulogadung (PPID JIEP)', verification_status: 'verified' },
  { id: 'access-3', type: 'access', label: 'Akses Kawasan', name: 'Akses Utama Jl. Pulolio', latitude: -6.1812, longitude: 106.915, description: 'Gerbang timur E-Gate Kawasan Industri Pulogadung (PPID JIEP)', verification_status: 'verified' },
]

const mapLocations = ref<MapLocation[]>(defaultLocations)
const mapLoading = ref(false)
const verifiedCompanies = ref<Company[]>([])
const announcements = ref<Announcement[]>([])

const facilityHighlights = [
  { name: 'Tanah Kavling Industri', icon: '📐', desc: 'Penyewaan dan penjualan lahan kavling siap bangun' },
  { name: 'Bangunan Pabrik Siap Pakai', icon: '🏭', desc: 'Fasilitas pabrik BPSP siap pakai untuk tenant' },
  { name: 'Pergudangan Modern', icon: '📦', desc: 'Gudang penyimpanan dan distribusi logistik' },
  { name: 'Business Center', icon: '🏢', desc: 'Pusat perkantoran dan ruang rapat modern' },
  { name: 'Sentra Usaha Kecil (SUIK)', icon: '🏪', desc: 'Dukungan fasilitas bagi industri kecil & UMKM' },
  { name: 'Pertashop & Energi', icon: '⚡', desc: 'Penyedia bahan bakar dan utilitas energi kawasan' },
  { name: 'Food Center', icon: '🍲', desc: 'Kantin dan pusat kuliner karyawan kawasan' },
  { name: 'Sport Center', icon: '⚽', desc: 'Fasilitas olahraga dan kesehatan karyawan' },
]

onMounted(async () => {
  try {
    const [mapRes, compRes, annRes] = await Promise.allSettled([
      api.get<{ data: MapLocation[] }>('/map/locations'),
      api.get<{ data: Company[] }>('/companies', { verification_status: 'verified', per_page: 4 }),
      api.get<{ data: Announcement[] }>('/announcements', { per_page: 3 }),
    ])

    if (mapRes.status === 'fulfilled' && mapRes.value.data) {
      mapLocations.value = mapRes.value.data
    }
    if (compRes.status === 'fulfilled' && compRes.value.data) {
      verifiedCompanies.value = compRes.value.data
    }
    if (annRes.status === 'fulfilled' && annRes.value.data) {
      announcements.value = annRes.value.data
    }
  } catch (err) {
    console.error('Error fetching homepage data:', err)
  } finally {
    mapLoading.value = false
  }
})
</script>

<template>
  <div class="space-y-6 pb-16">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-950/60 border border-cyan-500/40 text-cyan-400 text-xs font-semibold mb-2">
          <span>🗺️</span> PETA GEOSPASIAL MASTER PLAN KIP
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
          Peta Digital Kawasan Industri Pulogadung
        </h1>
        <p class="text-xs text-slate-400">
          Visualisasi geospasial interaktif berbasis OpenStreetMap dan Master Plan Zonasi Resmi PT JIEP (433 Ha).
        </p>
      </div>

      <!-- Actions & Search -->
      <div class="flex flex-wrap items-center gap-2">
        <button
          @click="showCompareModal = true"
          class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-purple-600/30 to-blue-600/30 hover:from-purple-600/40 hover:to-blue-600/40 border border-purple-500/40 text-purple-200 text-xs font-bold transition-all flex items-center gap-1.5 shadow-lg shadow-purple-900/20"
        >
          <span>🖼️</span> Lihat Peta Asli JIEP (Instagram)
        </button>

        <div class="relative w-full sm:w-64">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari lokasi di peta..."
            class="w-full px-4 py-2 pl-9 bg-slate-900 border border-slate-700 rounded-xl text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 shadow-inner"
          />
          <span class="absolute left-3 top-2 text-xs text-slate-500">🔍</span>
        </div>
      </div>
    </div>

    <!-- Category Filter Pills -->
    <div class="flex flex-wrap items-center gap-2">
      <button
        v-for="cat in categories"
        :key="cat.key"
        @click="selectedCategory = cat.key"
        :class="[
          'px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all border flex items-center gap-1.5',
          selectedCategory === cat.key
            ? 'bg-cyan-500/20 text-cyan-300 border-cyan-500/60 shadow-lg shadow-cyan-500/10'
            : 'bg-slate-900/80 text-slate-400 border-slate-800 hover:text-white hover:border-slate-700'
        ]"
      >
        <span>{{ cat.icon }}</span>
        <span>{{ cat.label }}</span>
        <span class="px-1.5 py-0.2 rounded-full bg-slate-800 text-[10px] text-slate-400">
          {{ getCategoryCount(cat.key) }}
        </span>
      </button>
    </div>

    <!-- Map View and Details Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Main Map (3 cols) -->
      <div class="lg:col-span-3 space-y-4">
        <ClientOnly>
          <IndustrialMap
            :locations="filteredLocations"
            :selected-category="selectedCategory"
            :loading="loading"
            :focus-location="selectedLocation"
            @select-location="handleSelectLocation"
            @select-zone="handleSelectZone"
          />
          <template #fallback>
            <div class="w-full h-[600px] rounded-2xl bg-slate-900 border border-slate-800 flex flex-col items-center justify-center gap-3 text-slate-400 text-xs">
              <div class="w-8 h-8 border-4 border-cyan-500 border-t-transparent rounded-full animate-spin"></div>
              <span>Memuat Komponen Leaflet Map & OpenStreetMap...</span>
            </div>
          </template>
        </ClientOnly>

        <!-- List of Markers below the map for quick selection -->
        <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-3">
          <div class="flex items-center justify-between text-xs text-slate-400 border-b border-slate-800 pb-2">
            <span class="font-bold text-white uppercase text-[11px] tracking-wider">
              Daftar Titik Lokasi Terverifikasi ({{ filteredLocations.length }})
            </span>
            <span class="text-[11px] text-slate-500">Klik kartu untuk memusatkan peta ke lokasi</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div
              v-for="loc in filteredLocations"
              :key="loc.id"
              @click="handleSelectLocation(loc)"
              :class="[
                'p-3 rounded-xl border text-xs cursor-pointer transition-all space-y-1.5',
                selectedLocation?.id === loc.id
                  ? 'bg-cyan-950/40 border-cyan-500/80 shadow-md shadow-cyan-500/10'
                  : 'bg-slate-950/60 border-slate-800 hover:border-slate-700'
              ]"
            >
              <div class="flex items-center justify-between gap-1">
                <span class="text-[10px] px-2 py-0.5 rounded uppercase font-bold text-cyan-400 bg-cyan-950/80 border border-cyan-800/80">
                  {{ loc.label }}
                </span>
                <span class="text-[10px] text-emerald-400 font-semibold">✓</span>
              </div>
              <h4 class="font-bold text-white truncate text-[12px]">{{ loc.name }}</h4>
              <p class="text-[11px] text-slate-400 line-clamp-1">{{ loc.description }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Detail Sidebar (1 col) -->
      <div class="space-y-4">
        <!-- Selected Point Info Card -->
        <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
          <h3 class="text-sm font-bold text-white flex items-center gap-2">
            <span>📍</span> Titik Terpilih
          </h3>

          <div v-if="selectedLocation" class="space-y-3">
            <div class="flex items-center gap-2">
              <span class="text-xs px-2.5 py-0.5 rounded-full bg-cyan-950 text-cyan-400 border border-cyan-800 font-bold uppercase">
                {{ selectedLocation.label }}
              </span>
              <VerificationBadge :status="selectedLocation.verification_status" />
            </div>

            <h4 class="text-base font-bold text-white tracking-tight">{{ selectedLocation.name }}</h4>

            <p class="text-xs text-slate-300 leading-relaxed bg-slate-950/70 p-3 rounded-xl border border-slate-800">
              {{ selectedLocation.description || 'Lokasi terverifikasi di dalam kawasan industri.' }}
            </p>

            <div class="p-3 bg-slate-950 rounded-xl border border-slate-800 text-[11px] font-mono text-slate-400 space-y-1">
              <div class="flex justify-between">
                <span class="text-slate-500">Latitude:</span>
                <span class="text-cyan-400 font-bold">{{ selectedLocation.latitude?.toFixed(6) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-500">Longitude:</span>
                <span class="text-cyan-400 font-bold">{{ selectedLocation.longitude?.toFixed(6) }}</span>
              </div>
            </div>

            <div v-if="selectedLocation.link_id" class="pt-2">
              <NuxtLink :to="`/perusahaan/${selectedLocation.link_id}`" class="w-full py-2 px-3 rounded-lg bg-blue-600/30 hover:bg-blue-600/50 border border-blue-500/40 text-cyan-300 text-xs font-semibold text-center block transition-colors">
                Lihat Profil Perusahaan &rarr;
              </NuxtLink>
            </div>
          </div>

          <div v-else class="text-xs text-slate-500 text-center py-6">
            Klik salah satu marker pada peta untuk melihat detail koordinat dan profil.
          </div>
        </div>

        <!-- Master Plan Zone Card if clicked -->
        <div v-if="selectedZone" class="card bg-slate-900/90 border-cyan-500/50 p-4 space-y-2.5 text-xs animate-fade-in">
          <div class="flex items-center justify-between">
            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded" :style="{ backgroundColor: `${selectedZone.color}30`, color: selectedZone.color }">
              {{ selectedZone.category }}
            </span>
            <button @click="selectedZone = null" class="text-slate-500 hover:text-white">✕</button>
          </div>
          <h4 class="font-bold text-white text-sm">{{ selectedZone.name }}</h4>
          <p class="text-slate-300 text-[11px] leading-relaxed">{{ selectedZone.description }}</p>
          <div class="pt-2 border-t border-slate-800 text-[10px] text-slate-400">
            Sumber: Publikasi Master Plan JIEP (Instagram @jiep_official)
          </div>
        </div>

        <!-- Master Plan Zoning Legend matching the Instagram Post -->
        <div class="card bg-slate-900/80 border-slate-700/60 p-4 space-y-2.5 text-xs">
          <div class="flex items-center justify-between">
            <h4 class="font-bold text-slate-300 text-[11px] uppercase tracking-wider">Legenda Zonasi Master Plan</h4>
            <span class="text-[10px] text-cyan-400">Peta JIEP</span>
          </div>

          <div class="space-y-1.5 text-slate-300 text-[11px]">
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#eab308] border border-white/40"></span>
              <span>Komersial & Business Center</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#334155] border border-white/40"></span>
              <span>Pergudangan & Logistik Berat</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#8b5cf6] border border-white/40"></span>
              <span>Industri Manufaktur</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#ea580c] border border-white/40"></span>
              <span>Bangunan Pabrik Siap Pakai (BPSP)</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#0284c7] border border-white/40"></span>
              <span>Tenant Industri Berat & Hexindo</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#22c55e] border border-white/40"></span>
              <span>Koridor Hijau & Boulevard Utama</span>
            </div>
            <div class="flex items-center gap-2 p-1.5 rounded hover:bg-slate-800/50">
              <span class="w-3.5 h-3.5 rounded bg-[#c2410c] border border-white/40"></span>
              <span>Graha Dayaguna & Pelayanan Tenant</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Compare with Official Instagram Master Plan -->
    <div v-if="showCompareModal" class="fixed inset-0 bg-slate-950/85 backdrop-blur-md z-50 flex items-center justify-center p-4">
      <div class="card bg-slate-900 border-slate-700 max-w-2xl w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <div class="flex items-center gap-2">
            <span class="text-xl">🗺️</span>
            <div>
              <h3 class="text-sm font-bold text-white">Peta Resmi Kawasan Industri Pulogadung</h3>
              <p class="text-[10px] text-slate-400">Danantara Indonesia • PT JIEP • Pemprov DKI Jakarta</p>
            </div>
          </div>
          <button @click="showCompareModal = false" class="text-slate-400 hover:text-white text-lg">✕</button>
        </div>

        <div class="space-y-3 text-xs">
          <div class="rounded-xl overflow-hidden border border-slate-800 bg-slate-950 flex justify-center p-2">
            <img
              src="/images/peta-masterplan-jiep.jpg"
              alt="Peta Kawasan Industri Pulogadung Resmi PT JIEP"
              class="max-h-[460px] object-contain rounded-lg shadow-xl"
            />
          </div>

          <div class="p-3 bg-slate-950 rounded-xl border border-slate-800 space-y-1.5 text-slate-300">
            <div class="flex items-center justify-between text-[11px]">
              <span class="text-slate-500">Sumber Referensi Publik:</span>
              <a href="https://www.instagram.com/p/DO-4aq5Eywr/" target="_blank" rel="noopener noreferrer" class="text-cyan-400 hover:underline font-semibold flex items-center gap-1">
                <span>Instagram @jiep_official</span>
                <span>↗</span>
              </a>
            </div>
            <p class="text-[11px] text-slate-400 leading-relaxed">
              Peta zonasi ini merupakan rujukan tata ruang resmi Kawasan Industri Pulogadung. Seluruh blok warna (kuning, ungu, oranye, hijau koridor, dan biru) telah kami digitalisasi ke dalam lapisan spasial interaktif Leaflet di atas peta OpenStreetMap.
            </p>
          </div>
        </div>

        <div class="flex justify-end pt-2 border-t border-slate-800">
          <button
            @click="showCompareModal = false"
            class="px-5 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs transition-colors"
          >
            Tutup & Kembali ke Peta Interaktif
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import type { MapLocation } from '~/types'
import type { KipZone } from '~/utils/kipMasterPlan'

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

const locations = ref<MapLocation[]>(defaultLocations)
const loading = ref(false)
const selectedCategory = ref('all')
const selectedLocation = ref<MapLocation | null>(defaultLocations[0])
const selectedZone = ref<KipZone | null>(null)
const searchQuery = ref('')
const showCompareModal = ref(false)

const categories = [
  { key: 'all', label: 'Semua', icon: '🌐' },
  { key: 'estate', label: 'Kantor JIEP', icon: '🏢' },
  { key: 'company', label: 'Perusahaan', icon: '🏭' },
  { key: 'facility', label: 'Fasilitas', icon: '🏗️' },
  { key: 'access', label: 'Akses E-Gate', icon: '🚪' },
]

const filteredLocations = computed(() => {
  let list = locations.value

  if (selectedCategory.value !== 'all') {
    list = list.filter(l => l.type === selectedCategory.value)
  }

  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase()
    list = list.filter(l =>
      l.name.toLowerCase().includes(q) ||
      (l.description && l.description.toLowerCase().includes(q)) ||
      l.label.toLowerCase().includes(q)
    )
  }

  return list
})

const getCategoryCount = (key: string) => {
  if (key === 'all') return locations.value.length
  return locations.value.filter(l => l.type === key).length
}

const handleSelectLocation = (loc: MapLocation) => {
  selectedLocation.value = loc
}

const handleSelectZone = (zone: KipZone) => {
  selectedZone.value = zone
}

onMounted(async () => {
  try {
    const res = await api.get<{ data: MapLocation[] }>('/map/locations')
    if (res.data && res.data.length > 0) {
      locations.value = res.data
      if (!selectedLocation.value) {
        selectedLocation.value = res.data[0]
      }
    }
  } catch (err) {
    console.warn('Menggunakan data lokasi default terverifikasi:', err)
  }
})
</script>

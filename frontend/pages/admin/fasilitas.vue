<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Manajemen Fasilitas Kawasan</h2>
        <p class="text-xs text-slate-400">Kelola daftar fasilitas, sarana prasarana, dan utilitas KIP</p>
      </div>
      <button
        @click="openModal('create')"
        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5"
      >
        <span>➕</span> Tambah Fasilitas
      </button>
    </div>

    <!-- Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Nama Fasilitas</th>
              <th class="pb-2.5 font-semibold">Kategori</th>
              <th class="pb-2.5 font-semibold">Status Operasional</th>
              <th class="pb-2.5 font-semibold">Sumber Data</th>
              <th class="pb-2.5 font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="f in facilities" :key="f.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-semibold text-white">{{ f.name }}</td>
              <td class="py-3 text-cyan-400 uppercase font-mono text-[11px]">{{ f.category }}</td>
              <td class="py-3 text-slate-400">{{ f.operational_status }}</td>
              <td class="py-3 text-slate-500">{{ f.data_source }}</td>
              <td class="py-3 text-right space-x-2">
                <button @click="openModal('edit', f)" class="text-cyan-400 hover:underline">Edit</button>
                <button @click="handleDelete(f)" class="text-rose-400 hover:underline">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="card bg-slate-900 border-slate-700 max-w-lg w-full p-6 space-y-4 text-xs">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-sm font-bold text-white">{{ modalMode === 'create' ? 'Tambah Fasilitas Baru' : 'Edit Fasilitas' }}</h3>
          <button @click="showModal = false" class="text-slate-500 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="handleSave" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Nama Fasilitas *</label>
            <input v-model="form.name" required class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Kategori *</label>
              <input v-model="form.category" required placeholder="Contoh: logistik, pergudangan" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Status Operasional</label>
              <input v-model="form.operational_status" placeholder="Contoh: Beroperasi" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Deskripsi Fasilitas</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white"></textarea>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Sumber Data</label>
            <input v-model="form.data_source" placeholder="Contoh: PT JIEP — jiep.co.id" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>

          <div class="flex justify-end gap-2 pt-3 border-t border-slate-800">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Facility, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const toast = useToast()

const facilities = ref<Facility[]>([])
const showModal = ref(false)
const modalMode = ref<'create' | 'edit'>('create')
const activeId = ref<number | null>(null)

const form = ref({
  industrial_estate_id: 1,
  name: '',
  category: '',
  operational_status: 'Belum terverifikasi',
  description: '',
  data_source: 'PT JIEP — jiep.co.id',
  verification_status: 'needs_verification',
})

const fetchFacilities = async () => {
  try {
    const res = await api.get<PaginatedResponse<Facility>>('/facilities', { per_page: 50 })
    facilities.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

const openModal = (mode: 'create' | 'edit', f?: Facility) => {
  modalMode.value = mode
  if (mode === 'edit' && f) {
    activeId.value = f.id
    form.value = {
      industrial_estate_id: f.industrial_estate_id || 1,
      name: f.name,
      category: f.category,
      operational_status: f.operational_status || 'Belum terverifikasi',
      description: f.description || '',
      data_source: f.data_source || 'PT JIEP — jiep.co.id',
      verification_status: f.verification_status,
    }
  } else {
    activeId.value = null
    form.value = {
      industrial_estate_id: 1,
      name: '',
      category: '',
      operational_status: 'Belum terverifikasi',
      description: '',
      data_source: 'PT JIEP — jiep.co.id',
      verification_status: 'needs_verification',
    }
  }
  showModal.value = true
}

const handleSave = async () => {
  try {
    if (modalMode.value === 'create') {
      await api.post('/admin/facilities', form.value)
      toast.success('Fasilitas berhasil ditambahkan.')
    } else if (activeId.value) {
      await api.put(`/admin/facilities/${activeId.value}`, form.value)
      toast.success('Fasilitas berhasil diperbarui.')
    }
    showModal.value = false
    fetchFacilities()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menyimpan fasilitas.')
  }
}

const handleDelete = async (f: Facility) => {
  if (!confirm(`Hapus fasilitas '${f.name}'?`)) return
  try {
    await api.del(`/admin/facilities/${f.id}`)
    toast.success('Fasilitas berhasil dihapus.')
    fetchFacilities()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menghapus fasilitas.')
  }
}

onMounted(() => {
  fetchFacilities()
})
</script>

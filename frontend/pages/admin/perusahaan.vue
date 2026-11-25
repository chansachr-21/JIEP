<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Manajemen Data Perusahaan</h2>
        <p class="text-xs text-slate-400">Kelola dan verifikasi profil tenant Kawasan Industri Pulogadung</p>
      </div>
      <div class="flex items-center gap-2">
        <button
          @click="openModal('create')"
          class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5"
        >
          <span>➕</span> Tambah Perusahaan
        </button>
      </div>
    </div>

    <!-- Table Card -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="flex items-center justify-between gap-4">
        <input
          v-model="search"
          @input="fetchData"
          type="text"
          placeholder="Cari perusahaan..."
          class="px-3.5 py-1.5 bg-slate-950 border border-slate-700 rounded-lg text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 w-64"
        />
        <span class="text-xs text-slate-500">Total: {{ companies.length }} data</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Nama Perusahaan</th>
              <th class="pb-2.5 font-semibold">Kategori</th>
              <th class="pb-2.5 font-semibold">Verifikasi</th>
              <th class="pb-2.5 font-semibold">Sumber Data</th>
              <th class="pb-2.5 font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="c in companies" :key="c.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-semibold text-white">{{ c.name }}</td>
              <td class="py-3 text-slate-400">{{ c.category || '-' }}</td>
              <td class="py-3">
                <VerificationBadge :status="c.verification_status" />
              </td>
              <td class="py-3 text-slate-400 text-[11px]">{{ c.data_source || '-' }}</td>
              <td class="py-3 text-right space-x-2">
                <button @click="openModal('edit', c)" class="text-cyan-400 hover:underline">Edit</button>
                <button @click="handleDelete(c)" class="text-rose-400 hover:underline">Hapus</button>
              </td>
            </tr>
            <tr v-if="companies.length === 0">
              <td colspan="5" class="py-8 text-center text-slate-500">Tidak ada data perusahaan.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="card bg-slate-900 border-slate-700 max-w-lg w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto text-xs">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-sm font-bold text-white">{{ modalMode === 'create' ? 'Tambah Perusahaan Baru' : 'Edit Perusahaan' }}</h3>
          <button @click="showModal = false" class="text-slate-500 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="handleSave" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Nama Perusahaan *</label>
            <input v-model="form.name" required class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Kategori</label>
              <input v-model="form.category" placeholder="Contoh: Logistik, Manufaktur" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Status Verifikasi</label>
              <select v-model="form.verification_status" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white">
                <option value="verified">Verified (Terverifikasi)</option>
                <option value="needs_verification">Needs Verification</option>
                <option value="unverified">Unverified</option>
              </select>
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Deskripsi</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white"></textarea>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Alamat Operasional di KIP</label>
            <input v-model="form.address" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Sumber Data</label>
              <input v-model="form.data_source" placeholder="Contoh: Dokumen Resmi JIEP" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Website</label>
              <input v-model="form.website" placeholder="https://..." class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
          </div>

          <div class="flex justify-end gap-2 pt-3 border-t border-slate-800">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg hover:bg-slate-700">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Company, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const toast = useToast()

const companies = ref<Company[]>([])
const search = ref('')
const showModal = ref(false)
const modalMode = ref<'create' | 'edit'>('create')
const activeId = ref<number | null>(null)

const form = ref({
  industrial_estate_id: 1,
  name: '',
  category: '',
  description: '',
  address: '',
  data_source: '',
  website: '',
  verification_status: 'needs_verification',
})

const fetchData = async () => {
  try {
    const res = await api.get<PaginatedResponse<Company>>('/companies', { search: search.value, per_page: 50 })
    companies.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

const openModal = (mode: 'create' | 'edit', company?: Company) => {
  modalMode.value = mode
  if (mode === 'edit' && company) {
    activeId.value = company.id
    form.value = {
      industrial_estate_id: company.industrial_estate_id || 1,
      name: company.name,
      category: company.category || '',
      description: company.description || '',
      address: company.address || '',
      data_source: company.data_source || '',
      website: company.website || '',
      verification_status: company.verification_status,
    }
  } else {
    activeId.value = null
    form.value = {
      industrial_estate_id: 1,
      name: '',
      category: '',
      description: '',
      address: '',
      data_source: '',
      website: '',
      verification_status: 'needs_verification',
    }
  }
  showModal.value = true
}

const handleSave = async () => {
  try {
    if (modalMode.value === 'create') {
      await api.post('/admin/companies', form.value)
      toast.success('Perusahaan berhasil ditambahkan.')
    } else if (activeId.value) {
      await api.put(`/admin/companies/${activeId.value}`, form.value)
      toast.success('Data perusahaan berhasil diperbarui.')
    }
    showModal.value = false
    fetchData()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menyimpan data.')
  }
}

const handleDelete = async (c: Company) => {
  if (!confirm(`Hapus perusahaan '${c.name}'?`)) return
  try {
    await api.del(`/admin/companies/${c.id}`)
    toast.success('Perusahaan berhasil dihapus.')
    fetchData()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menghapus.')
  }
}

onMounted(() => {
  fetchData()
})
</script>

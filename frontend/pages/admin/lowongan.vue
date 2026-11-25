<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Manajemen Lowongan Kerja</h2>
        <p class="text-xs text-slate-400">Kelola informasi kesempatan kerja resmi di Kawasan Industri Pulogadung</p>
      </div>
      <button
        @click="openModal('create')"
        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5"
      >
        <span>➕</span> Tambah Lowongan
      </button>
    </div>

    <!-- Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Posisi Pekerjaan</th>
              <th class="pb-2.5 font-semibold">Perusahaan</th>
              <th class="pb-2.5 font-semibold">Tipe Kerja</th>
              <th class="pb-2.5 font-semibold">Batas Waktu</th>
              <th class="pb-2.5 font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="job in jobs" :key="job.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-semibold text-white">{{ job.title }}</td>
              <td class="py-3 text-cyan-400">{{ job.company_name }}</td>
              <td class="py-3 text-slate-400 capitalize">{{ job.employment_type || '-' }}</td>
              <td class="py-3 text-slate-500 text-[11px]">{{ job.deadline || 'Tanpa batas' }}</td>
              <td class="py-3 text-right space-x-2">
                <button @click="openModal('edit', job)" class="text-cyan-400 hover:underline">Edit</button>
                <button @click="handleDelete(job)" class="text-rose-400 hover:underline">Hapus</button>
              </td>
            </tr>
            <tr v-if="jobs.length === 0">
              <td colspan="5" class="py-8 text-center text-slate-500">Belum ada lowongan terdaftar.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form -->
    <div v-if="showModal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="card bg-slate-900 border-slate-700 max-w-lg w-full p-6 space-y-4 text-xs">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-sm font-bold text-white">{{ modalMode === 'create' ? 'Tambah Lowongan Baru' : 'Edit Lowongan' }}</h3>
          <button @click="showModal = false" class="text-slate-500 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="handleSave" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Nama Perusahaan *</label>
            <input v-model="form.company_name" required placeholder="Contoh: PT Hexindo Adiperkasa Tbk" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Judul / Posisi Lowongan *</label>
            <input v-model="form.title" required placeholder="Contoh: Staff Logistik Kawasan" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Tipe Pekerjaan</label>
              <select v-model="form.employment_type" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white">
                <option value="full-time">Full Time</option>
                <option value="part-time">Part Time</option>
                <option value="kontrak">Kontrak</option>
                <option value="magang">Magang</option>
              </select>
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Batas Waktu Lamaran</label>
              <input v-model="form.deadline" type="date" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Deskripsi Pekerjaan</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white"></textarea>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Tautan Sumber Resmi</label>
            <input v-model="form.source_url" placeholder="https://..." class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
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
import type { JobVacancy, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const toast = useToast()

const jobs = ref<JobVacancy[]>([])
const showModal = ref(false)
const modalMode = ref<'create' | 'edit'>('create')
const activeId = ref<number | null>(null)

const form = ref({
  company_name: '',
  title: '',
  employment_type: 'full-time',
  deadline: '',
  description: '',
  source_url: '',
  is_published: true,
  verification_status: 'verified',
})

const fetchJobs = async () => {
  try {
    const res = await api.get<PaginatedResponse<JobVacancy>>('/jobs', { include_expired: true, per_page: 50 })
    jobs.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

const openModal = (mode: 'create' | 'edit', j?: JobVacancy) => {
  modalMode.value = mode
  if (mode === 'edit' && j) {
    activeId.value = j.id
    form.value = {
      company_name: j.company_name,
      title: j.title,
      employment_type: j.employment_type || 'full-time',
      deadline: j.deadline || '',
      description: j.description || '',
      source_url: j.source_url || '',
      is_published: j.is_published,
      verification_status: j.verification_status,
    }
  } else {
    activeId.value = null
    form.value = {
      company_name: '',
      title: '',
      employment_type: 'full-time',
      deadline: '',
      description: '',
      source_url: '',
      is_published: true,
      verification_status: 'verified',
    }
  }
  showModal.value = true
}

const handleSave = async () => {
  try {
    if (modalMode.value === 'create') {
      await api.post('/admin/jobs', form.value)
      toast.success('Lowongan berhasil ditambahkan.')
    } else if (activeId.value) {
      await api.put(`/admin/jobs/${activeId.value}`, form.value)
      toast.success('Lowongan berhasil diperbarui.')
    }
    showModal.value = false
    fetchJobs()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menyimpan lowongan.')
  }
}

const handleDelete = async (j: JobVacancy) => {
  if (!confirm(`Hapus lowongan '${j.title}'?`)) return
  try {
    await api.del(`/admin/jobs/${j.id}`)
    toast.success('Lowongan berhasil dihapus.')
    fetchJobs()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menghapus.')
  }
}

onMounted(() => {
  fetchJobs()
})
</script>

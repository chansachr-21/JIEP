<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Manajemen Pengumuman & Warta</h2>
        <p class="text-xs text-slate-400">Kelola warta resmi dan pengumuman sistem demonstrasi</p>
      </div>
      <button
        @click="openModal('create')"
        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5"
      >
        <span>➕</span> Tambah Pengumuman
      </button>
    </div>

    <!-- Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Judul Pengumuman</th>
              <th class="pb-2.5 font-semibold">Kategori</th>
              <th class="pb-2.5 font-semibold">Tipe Konten</th>
              <th class="pb-2.5 font-semibold">Tanggal</th>
              <th class="pb-2.5 font-semibold text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="ann in announcements" :key="ann.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-semibold text-white">{{ ann.title }}</td>
              <td class="py-3 text-slate-400 capitalize">{{ ann.category }}</td>
              <td class="py-3">
                <span
                  :class="ann.is_demo ? 'bg-amber-950 text-amber-400 border-amber-800' : 'bg-blue-950 text-blue-400 border-blue-800'"
                  class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border"
                >
                  {{ ann.is_demo ? 'DEMO' : 'RESMI' }}
                </span>
              </td>
              <td class="py-3 text-slate-500 text-[11px]">{{ ann.published_at }}</td>
              <td class="py-3 text-right space-x-2">
                <button @click="openModal('edit', ann)" class="text-cyan-400 hover:underline">Edit</button>
                <button @click="handleDelete(ann)" class="text-rose-400 hover:underline">Hapus</button>
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
          <h3 class="text-sm font-bold text-white">{{ modalMode === 'create' ? 'Tambah Pengumuman Baru' : 'Edit Pengumuman' }}</h3>
          <button @click="showModal = false" class="text-slate-500 hover:text-white">✕</button>
        </div>

        <form @submit.prevent="handleSave" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Judul Pengumuman *</label>
            <input v-model="form.title" required class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Kategori</label>
              <select v-model="form.category" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white">
                <option value="umum">Umum</option>
                <option value="operasional">Operasional</option>
                <option value="keamanan">Keamanan</option>
                <option value="acara">Acara</option>
                <option value="demo">Demo</option>
              </select>
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Jenis Konten</label>
              <select v-model="form.is_demo" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white">
                <option :value="false">Resmi / Berdasarkan PPID JIEP</option>
                <option :value="true">Konten Demonstrasi</option>
              </select>
            </div>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Isi Pengumuman *</label>
            <textarea v-model="form.content" required rows="4" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Sumber Informasi</label>
              <input v-model="form.data_source" placeholder="Contoh: PPID JIEP" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
            <div>
              <label class="block text-slate-300 font-semibold mb-1">Tautan Dokumen Asli</label>
              <input v-model="form.source_url" placeholder="https://..." class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white" />
            </div>
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
import type { Announcement, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const toast = useToast()

const announcements = ref<Announcement[]>([])
const showModal = ref(false)
const modalMode = ref<'create' | 'edit'>('create')
const activeId = ref<number | null>(null)

const form = ref({
  title: '',
  category: 'umum',
  content: '',
  is_demo: false,
  data_source: '',
  source_url: '',
  is_published: true,
})

const fetchAnnouncements = async () => {
  try {
    const res = await api.get<PaginatedResponse<Announcement>>('/announcements', { per_page: 50 })
    announcements.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

const openModal = (mode: 'create' | 'edit', a?: Announcement) => {
  modalMode.value = mode
  if (mode === 'edit' && a) {
    activeId.value = a.id
    form.value = {
      title: a.title,
      category: a.category,
      content: a.content,
      is_demo: a.is_demo,
      data_source: a.data_source || '',
      source_url: a.source_url || '',
      is_published: a.is_published,
    }
  } else {
    activeId.value = null
    form.value = {
      title: '',
      category: 'umum',
      content: '',
      is_demo: false,
      data_source: '',
      source_url: '',
      is_published: true,
    }
  }
  showModal.value = true
}

const handleSave = async () => {
  try {
    if (modalMode.value === 'create') {
      await api.post('/admin/announcements', form.value)
      toast.success('Pengumuman berhasil ditambahkan.')
    } else if (activeId.value) {
      await api.put(`/admin/announcements/${activeId.value}`, form.value)
      toast.success('Pengumuman berhasil diperbarui.')
    }
    showModal.value = false
    fetchAnnouncements()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menyimpan pengumuman.')
  }
}

const handleDelete = async (a: Announcement) => {
  if (!confirm(`Hapus pengumuman '${a.title}'?`)) return
  try {
    await api.del(`/admin/announcements/${a.id}`)
    toast.success('Pengumuman berhasil dihapus.')
    fetchAnnouncements()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menghapus.')
  }
}

onMounted(() => {
  fetchAnnouncements()
})
</script>

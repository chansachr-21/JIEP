<template>
  <div class="space-y-6 pb-12">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <h2 class="text-xl font-extrabold text-white tracking-tight">Manajemen Pengaduan Demonstrasi</h2>
        <p class="text-xs text-slate-400">Tinjau laporan masuk, perbarui status penanganan, dan catat tindak lanjut</p>
      </div>
    </div>

    <!-- Table -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-5 space-y-4">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="text-slate-500 border-b border-slate-800">
            <tr>
              <th class="pb-2.5 font-semibold">Nomor Tiket</th>
              <th class="pb-2.5 font-semibold">Judul Pengaduan</th>
              <th class="pb-2.5 font-semibold">Kategori</th>
              <th class="pb-2.5 font-semibold">Status</th>
              <th class="pb-2.5 font-semibold">Tanggal</th>
              <th class="pb-2.5 font-semibold text-right">Tindakan</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            <tr v-for="c in complaints" :key="c.id" class="hover:bg-slate-800/40">
              <td class="py-3 font-mono text-cyan-400 font-bold">{{ c.complaint_number }}</td>
              <td class="py-3 font-medium text-white">{{ c.title }}</td>
              <td class="py-3 text-slate-400 capitalize">{{ c.category }}</td>
              <td class="py-3">
                <span
                  :class="[
                    'px-2 py-0.5 rounded text-[10px] font-bold uppercase border',
                    c.status === 'selesai' ? 'bg-emerald-950 text-emerald-400 border-emerald-800' :
                    c.status === 'diproses' ? 'bg-blue-950 text-blue-400 border-blue-800' :
                    c.status === 'ditinjau' ? 'bg-purple-950 text-purple-400 border-purple-800' :
                    c.status === 'ditolak' ? 'bg-rose-950 text-rose-400 border-rose-800' :
                    'bg-amber-950 text-amber-400 border-amber-800'
                  ]"
                >
                  {{ c.status }}
                </span>
              </td>
              <td class="py-3 text-slate-500 text-[11px]">{{ new Date(c.created_at).toLocaleDateString('id-ID') }}</td>
              <td class="py-3 text-right space-x-2">
                <button @click="openStatusModal(c)" class="text-cyan-400 hover:underline">Update Status</button>
                <button @click="handleDelete(c)" class="text-rose-400 hover:underline">Hapus</button>
              </td>
            </tr>
            <tr v-if="complaints.length === 0">
              <td colspan="6" class="py-8 text-center text-slate-500">Belum ada pengaduan demonstrasi masuk.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Update Status -->
    <div v-if="showModal && activeComplaint" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="card bg-slate-900 border-slate-700 max-w-md w-full p-6 space-y-4 text-xs">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
          <h3 class="text-sm font-bold text-white">Update Status Pengaduan</h3>
          <button @click="showModal = false" class="text-slate-500 hover:text-white">✕</button>
        </div>

        <div class="space-y-1">
          <span class="text-slate-400 block text-[11px] font-mono">{{ activeComplaint.complaint_number }}</span>
          <h4 class="text-sm font-bold text-white">{{ activeComplaint.title }}</h4>
        </div>

        <form @submit.prevent="handleUpdateStatus" class="space-y-3">
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Ubah Status Menjadi *</label>
            <select v-model="statusForm.status" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white">
              <option value="diterima">Diterima</option>
              <option value="ditinjau">Sedang Ditinjau</option>
              <option value="diproses">Diproses</option>
              <option value="selesai">Selesai</option>
              <option value="ditolak">Ditolak</option>
            </select>
          </div>
          <div>
            <label class="block text-slate-300 font-semibold mb-1">Catatan Tindak Lanjut</label>
            <textarea
              v-model="statusForm.note"
              rows="3"
              placeholder="Berikan keterangan penanganan..."
              class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-lg text-white"
            ></textarea>
          </div>

          <div class="flex justify-end gap-2 pt-3 border-t border-slate-800">
            <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold">Simpan Status</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Complaint, PaginatedResponse } from '~/types'

definePageMeta({ layout: 'admin' })

const api = useApi()
const toast = useToast()

const complaints = ref<Complaint[]>([])
const showModal = ref(false)
const activeComplaint = ref<Complaint | null>(null)

const statusForm = ref({
  status: 'ditinjau',
  note: '',
})

const fetchComplaints = async () => {
  try {
    const res = await api.get<PaginatedResponse<Complaint>>('/admin/complaints', { per_page: 50 })
    complaints.value = res.data || []
  } catch (err) {
    console.error(err)
  }
}

const openStatusModal = (c: Complaint) => {
  activeComplaint.value = c
  statusForm.value = {
    status: c.status,
    note: '',
  }
  showModal.value = true
}

const handleUpdateStatus = async () => {
  if (!activeComplaint.value) return
  try {
    await api.patch(`/admin/complaints/${activeComplaint.value.id}/status`, statusForm.value)
    toast.success('Status pengaduan berhasil diperbarui.')
    showModal.value = false
    fetchComplaints()
  } catch (err: any) {
    toast.error(err.message || 'Gagal mengubah status.')
  }
}

const handleDelete = async (c: Complaint) => {
  if (!confirm(`Hapus pengaduan '${c.complaint_number}'?`)) return
  try {
    await api.del(`/admin/complaints/${c.id}`)
    toast.success('Pengaduan berhasil dihapus.')
    fetchComplaints()
  } catch (err: any) {
    toast.error(err.message || 'Gagal menghapus.')
  }
}

onMounted(() => {
  fetchComplaints()
})
</script>

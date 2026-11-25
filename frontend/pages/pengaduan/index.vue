<template>
  <div class="space-y-8 pb-16 max-w-3xl mx-auto">
    <!-- Header -->
    <div class="text-center space-y-3">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/60 border border-blue-500/30 text-blue-400 text-xs font-semibold">
        <span>📝</span> LAYANAN DEMONSTRASI
      </div>
      <h1 class="text-3xl font-extrabold text-white tracking-tight">
        Formulir Pengaduan Kawasan
      </h1>
      <p class="text-xs text-slate-400 max-w-lg mx-auto">
        Kirimkan laporan demonstrasi terkait infrastruktur, kebersihan, atau fasilitas di kawasan untuk menguji alur penanganan digital.
      </p>
    </div>

    <!-- Notice Demo -->
    <div class="p-4 rounded-xl bg-amber-950/40 border border-amber-700/50 text-xs text-amber-200/90 space-y-1">
      <div class="font-bold flex items-center gap-1.5">
        <span>⚠️</span> PEMBERITAHUAN SISTEM DEMONSTRASI
      </div>
      <p>
        Formulir ini adalah modul percontohan inovasi teknologi. Pengaduan yang dikirim <strong>hanya tersimpan dalam database demonstrasi lokal INDUSTRIA</strong> dan <strong>TIDAK terhubung serta TIDAK dikirimkan ke PT JIEP</strong>.
      </p>
    </div>

    <!-- Form -->
    <div class="card bg-slate-900/80 border-slate-700/60 p-6 sm:p-8 space-y-6">
      <form @submit.prevent="handleSubmit" class="space-y-4 text-xs">
        <div>
          <label class="block text-slate-300 font-semibold mb-1.5">Judul Pengaduan <span class="text-rose-400">*</span></label>
          <input
            v-model="form.title"
            required
            type="text"
            placeholder="Contoh: Penerangan jalan redup di Jl. Pulobuaran"
            class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500"
          />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-slate-300 font-semibold mb-1.5">Kategori Pengaduan <span class="text-rose-400">*</span></label>
            <select
              v-model="form.category"
              required
              class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white focus:outline-none focus:border-cyan-500"
            >
              <option value="infrastruktur">Infrastruktur & Jalan</option>
              <option value="keamanan">Keamanan & Ketertiban</option>
              <option value="kebersihan">Kebersihan & Lingkungan</option>
              <option value="administrasi">Layanan Administrasi</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>

          <div>
            <label class="block text-slate-300 font-semibold mb-1.5">Lokasi Kejadian (Opsional)</label>
            <input
              v-model="form.location"
              type="text"
              placeholder="Contoh: Jl. Pulogadung Raya Blok C"
              class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500"
            />
          </div>
        </div>

        <div>
          <label class="block text-slate-300 font-semibold mb-1.5">Nama Pelapor (Opsional)</label>
          <input
            v-model="form.reporter_name"
            type="text"
            placeholder="Nama Anda atau anonim"
            class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500"
          />
          <p class="text-[10px] text-slate-500 mt-1">Kami menghormati privasi Anda. Pengisian nama bersifat sukarela untuk sistem demonstrasi ini.</p>
        </div>

        <div>
          <label class="block text-slate-300 font-semibold mb-1.5">Deskripsi Masalah (Minimal 20 Karakter) <span class="text-rose-400">*</span></label>
          <textarea
            v-model="form.description"
            required
            rows="4"
            placeholder="Jelaskan secara rinci kondisi atau kendala yang ditemui..."
            class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500"
          ></textarea>
        </div>

        <button
          type="submit"
          :disabled="submitting"
          class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white font-bold transition-all shadow-lg shadow-blue-500/20 disabled:opacity-50 text-sm"
        >
          {{ submitting ? 'Mengirim Laporan...' : 'Kirim Pengaduan Demonstrasi' }}
        </button>
      </form>

      <!-- Success Modal / Result -->
      <div v-if="successNumber" class="p-5 rounded-xl bg-emerald-950/60 border border-emerald-700/60 text-center space-y-3">
        <div class="text-2xl">🎉</div>
        <h4 class="text-sm font-bold text-emerald-300">Pengaduan Demonstrasi Berhasil Dibuat!</h4>
        <p class="text-xs text-slate-300">Simpan nomor tiket pengaduan ini untuk melacak status penanganan:</p>
        <div class="inline-block px-4 py-2 rounded-lg bg-emerald-900/80 border border-emerald-500 text-base font-mono font-bold text-white tracking-wider">
          {{ successNumber }}
        </div>
        <div class="pt-2">
          <NuxtLink :to="`/pengaduan/tracking?number=${successNumber}`" class="text-xs text-cyan-400 hover:underline font-semibold">
            Buka Pelacakan Tiket Ini &rarr;
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const api = useApi()
const toast = useToast()

const submitting = ref(false)
const successNumber = ref<string | null>(null)

const form = ref({
  title: '',
  category: 'infrastruktur',
  location: '',
  reporter_name: '',
  description: '',
})

const handleSubmit = async () => {
  if (form.value.description.length < 20) {
    toast.error('Deskripsi harus minimal 20 karakter.')
    return
  }

  submitting.value = true
  try {
    const res: any = await api.post('/complaints', form.value)
    successNumber.value = res.complaint_number
    toast.success('Pengaduan demonstrasi berhasil dikirim.')
    form.value = {
      title: '',
      category: 'infrastruktur',
      location: '',
      reporter_name: '',
      description: '',
    }
  } catch (err: any) {
    toast.error(err.message || 'Gagal mengirim pengaduan.')
  } finally {
    submitting.value = false
  }
}
</script>

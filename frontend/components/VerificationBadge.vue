<template>
  <span
    :class="[
      'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium border',
      status === 'verified' ? 'bg-emerald-900/50 text-emerald-400 border-emerald-700/50' : '',
      status === 'needs_verification' ? 'bg-amber-900/50 text-amber-400 border-amber-700/50' : '',
      status === 'unverified' ? 'bg-slate-700/50 text-slate-400 border-slate-600/50' : '',
    ]"
  >
    <span>{{ icon }}</span>
    {{ label }}
  </span>
</template>

<script setup lang="ts">
import type { VerificationStatus } from '~/types'

const props = defineProps<{ status: VerificationStatus }>()

const icon = computed(() => ({
  verified: '✓',
  needs_verification: '⚠',
  unverified: '?',
}[props.status]))

const label = computed(() => ({
  verified: 'Terverifikasi',
  needs_verification: 'Perlu Verifikasi',
  unverified: 'Belum Diverifikasi',
}[props.status]))
</script>

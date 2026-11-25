<template>
  <!-- Toast container -->
  <Teleport to="body">
    <div class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-80 max-w-[calc(100vw-2rem)]">
      <Transition
        v-for="toast in toasts"
        :key="toast.id"
        name="toast"
        appear
      >
        <div
          :class="[
            'flex items-start gap-3 p-4 rounded-xl border shadow-2xl backdrop-blur-md',
            toast.type === 'success' ? 'bg-emerald-900/90 border-emerald-700/50 text-emerald-100' : '',
            toast.type === 'error' ? 'bg-red-900/90 border-red-700/50 text-red-100' : '',
            toast.type === 'warning' ? 'bg-amber-900/90 border-amber-700/50 text-amber-100' : '',
            toast.type === 'info' ? 'bg-blue-900/90 border-blue-700/50 text-blue-100' : '',
          ]"
        >
          <span class="text-lg flex-shrink-0">
            {{ toast.type === 'success' ? '✅' : toast.type === 'error' ? '❌' : toast.type === 'warning' ? '⚠️' : 'ℹ️' }}
          </span>
          <p class="text-sm flex-1 leading-relaxed">{{ toast.message }}</p>
          <button @click="remove(toast.id)" class="text-current opacity-60 hover:opacity-100 flex-shrink-0 text-lg leading-none">×</button>
        </div>
      </Transition>
    </div>
  </Teleport>
</template>

<script setup lang="ts">
const { toasts, remove } = useToast()
</script>

<style scoped>
.toast-enter-active { transition: all 0.3s ease-out; }
.toast-leave-active { transition: all 0.25s ease-in; }
.toast-enter-from { opacity: 0; transform: translateX(100%); }
.toast-leave-to { opacity: 0; transform: translateX(100%) scale(0.95); }
</style>

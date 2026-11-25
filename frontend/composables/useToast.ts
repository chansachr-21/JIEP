// composables/useToast.ts
// Simple toast notification composable

interface Toast {
  id: string
  message: string
  type: 'success' | 'error' | 'info' | 'warning'
}

const toasts = ref<Toast[]>([])

export const useToast = () => {
  const show = (message: string, type: Toast['type'] = 'info', duration = 4000) => {
    const id = Math.random().toString(36).slice(2)
    toasts.value.push({ id, message, type })
    setTimeout(() => {
      toasts.value = toasts.value.filter(t => t.id !== id)
    }, duration)
  }

  const success = (msg: string) => show(msg, 'success')
  const error = (msg: string) => show(msg, 'error', 5000)
  const info = (msg: string) => show(msg, 'info')
  const warning = (msg: string) => show(msg, 'warning')
  const remove = (id: string) => { toasts.value = toasts.value.filter(t => t.id !== id) }

  return { toasts: readonly(toasts), show, success, error, info, warning, remove }
}

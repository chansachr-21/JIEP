// composables/useApi.ts
// Composable utama untuk mengakses Laravel API dari Nuxt 3

export const useApi = () => {
  const config = useRuntimeConfig()
  const baseUrl = config.public.apiBase

  const get = async <T>(path: string, params?: Record<string, any>): Promise<T> => {
    const url = new URL(`${baseUrl}${path}`)
    if (params) {
      Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
          url.searchParams.set(key, String(value))
        }
      })
    }

    const res = await fetch(url.toString(), {
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  const post = async <T>(path: string, body: any): Promise<T> => {
    const res = await fetch(`${baseUrl}${path}`, {
      method: 'POST',
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  const put = async <T>(path: string, body: any): Promise<T> => {
    const res = await fetch(`${baseUrl}${path}`, {
      method: 'PUT',
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  const patch = async <T>(path: string, body: any): Promise<T> => {
    const res = await fetch(`${baseUrl}${path}`, {
      method: 'PATCH',
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  const del = async <T>(path: string): Promise<T> => {
    const res = await fetch(`${baseUrl}${path}`, {
      method: 'DELETE',
      headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  const postForm = async <T>(path: string, formData: FormData): Promise<T> => {
    const res = await fetch(`${baseUrl}${path}`, {
      method: 'POST',
      headers: { 'Accept': 'application/json' },
      body: formData,
    })

    if (!res.ok) {
      const error = await res.json().catch(() => ({ message: 'Terjadi kesalahan' }))
      throw new Error(error.message || `HTTP ${res.status}`)
    }

    return res.json()
  }

  return { get, post, put, patch, del, postForm }
}

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },

  // Modules
  modules: [
    '@nuxtjs/tailwindcss',
  ],

  // CSS
  css: [
    '~/assets/css/main.css',
    'leaflet/dist/leaflet.css',
  ],

  // Runtime config
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://127.0.0.1:8000/api/v1',
    },
  },

  // App config
  app: {
    head: {
      title: 'INDUSTRIA — Platform Informasi Kawasan Industri Pulogadung',
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        {
          name: 'description',
          content: 'INDUSTRIA adalah platform informasi dan digitalisasi layanan Kawasan Industri Pulogadung (KIP) yang dikelola oleh PT Jakarta Industrial Estate Pulogadung (JIEP).',
        },
        { name: 'theme-color', content: '#0d1526' },
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      ],
    },
    pageTransition: { name: 'page', mode: 'out-in' },
  },

  // Vite config
  vite: {
    define: {
      global: 'globalThis',
    },
  },

  // SSR config — beberapa komponen seperti Leaflet harus client-side only
  ssr: true,
})

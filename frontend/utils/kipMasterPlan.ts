// Master Plan & Zonasi Kawasan Industri Pulogadung (KIP)
// Referensi: Publikasi Resmi PT JIEP (Danantara Indonesia / Pemprov DKI Jakarta)
// Sumber: https://www.instagram.com/p/DO-4aq5Eywr/

export interface KipZone {
  id: string
  name: string
  category: string
  color: string
  fillOpacity: number
  description: string
  coordinates: [number, number][]
}

// Batas Luar Master Plan Kawasan Industri Pulogadung
export const KIP_OUTER_BOUNDARY: [number, number][] = [
  [-6.1770, 106.9075],
  [-6.1782, 106.9190],
  [-6.1825, 106.9202],
  [-6.1870, 106.9210],
  [-6.1950, 106.9220],
  [-6.2025, 106.9222],
  [-6.2030, 106.9080],
  [-6.2020, 106.9025],
  [-6.1970, 106.9020],
  [-6.1915, 106.9002],
  [-6.1865, 106.8998],
  [-6.1810, 106.9010],
  [-6.1770, 106.9075],
]

// Zonasi Blok Berdasarkan Peta Resmi PT JIEP
export const KIP_ZONES: KipZone[] = [
  {
    id: 'zone-north-heavy',
    name: 'Blok Utara — Zonasi Pergudangan & Logistik Berat',
    category: 'Logistik & Industri Berat',
    color: '#334155', // Dark slate/charcoal
    fillOpacity: 0.55,
    description: 'Area pergudangan bertaraf modern, depo logistik, dan fasilitas industri berat bagian utara dekat koridor Cakung - Bekasi Raya.',
    coordinates: [
      [-6.1770, 106.9075],
      [-6.1782, 106.9190],
      [-6.1820, 106.9195],
      [-6.1815, 106.9070],
      [-6.1770, 106.9075],
    ],
  },
  {
    id: 'zone-northwest-commercial',
    name: 'Blok Barat Laut — Zonasi Komersial & Business Center',
    category: 'Komersial & Jasa Industri',
    color: '#eab308', // Gold/Yellow
    fillOpacity: 0.55,
    description: 'Kawasan fasilitas perbankan, perkantoran komersial, Business Center, dan gerbang masuk utama Jl. Pulogadung Raya.',
    coordinates: [
      [-6.1810, 106.9010],
      [-6.1770, 106.9075],
      [-6.1815, 106.9070],
      [-6.1855, 106.9010],
      [-6.1810, 106.9010],
    ],
  },
  {
    id: 'zone-mid-purple',
    name: 'Blok Tengah Utara — Manufaktur & Perakitan',
    category: 'Industri Manufaktur',
    color: '#8b5cf6', // Purple/Violet
    fillOpacity: 0.55,
    description: 'Zonasi industri manufaktur presisi, perakitan komponen, dan fasilitas pabrik modern bernilai tambah tinggi.',
    coordinates: [
      [-6.1815, 106.9070],
      [-6.1820, 106.9195],
      [-6.1865, 106.9205],
      [-6.1860, 106.9070],
      [-6.1815, 106.9070],
    ],
  },
  {
    id: 'zone-mid-bpsp',
    name: 'Blok Tengah Timur — Bangunan Pabrik Siap Pakai (BPSP)',
    category: 'BPSP & Kavling Siap Pakai',
    color: '#ea580c', // Orange
    fillOpacity: 0.55,
    description: 'Kompleks Bangunan Pabrik Siap Pakai (BPSP) standar internasional untuk percepatan investasi tenant industri.',
    coordinates: [
      [-6.1860, 106.9070],
      [-6.1865, 106.9205],
      [-6.1920, 106.9210],
      [-6.1915, 106.9070],
      [-6.1860, 106.9070],
    ],
  },
  {
    id: 'zone-midwest-suik',
    name: 'Blok Tengah Barat — Sentra Industri Kecil (SUIK) & Tenant Sedang',
    category: 'SUIK & Industri Sedang',
    color: '#64748b', // Slate grey
    fillOpacity: 0.55,
    description: 'Area Sentra Usaha Industri Kecil (SUIK) dan pembinaan industri kecil-menengah terintegrasi dengan akses Jl. Pulolentut.',
    coordinates: [
      [-6.1855, 106.9010],
      [-6.1860, 106.9070],
      [-6.1925, 106.9070],
      [-6.1915, 106.9002],
      [-6.1855, 106.9010],
    ],
  },
  {
    id: 'zone-green-spine',
    name: 'Koridor Hijau & Boulevard Utama KIP',
    category: 'Buffer Lingkungan & Utilitas Hijau',
    color: '#22c55e', // Vibrant green strip (diagonal in master plan)
    fillOpacity: 0.70,
    description: 'Koridor hijau arterial, resapan drainase, dan penghijauan lingkungan industri sesuai prinsip Eco-Industrial Park JIEP.',
    coordinates: [
      [-6.1915, 106.9040],
      [-6.1880, 106.9080],
      [-6.1940, 106.9140],
      [-6.2025, 106.9090],
      [-6.2015, 106.9065],
      [-6.1930, 106.9030],
      [-6.1915, 106.9040],
    ],
  },
  {
    id: 'zone-southwest-tenants',
    name: 'Blok Barat Daya — Kawasan Tenant Industri Terpadu',
    category: 'Tenant Industri Utama',
    color: '#0284c7', // Sky Blue
    fillOpacity: 0.55,
    description: 'Lokasi tenant korporasi terkemuka termasuk PT Hexindo Adiperkasa Tbk, pabrik peralatan industri, dan permesinan berat.',
    coordinates: [
      [-6.1915, 106.9002],
      [-6.1930, 106.9030],
      [-6.2015, 106.9065],
      [-6.2020, 106.9025],
      [-6.1970, 106.9020],
      [-6.1915, 106.9002],
    ],
  },
  {
    id: 'zone-southeast-graha',
    name: 'Blok Timur — Graha Dayaguna & Food Center',
    category: 'Pusat Manajemen & Pelayanan Tenant',
    color: '#c2410c', // Coral/Amber
    fillOpacity: 0.55,
    description: 'Area kantor pusat PT JIEP (Graha Dayaguna), Food Center kawasan, Pertashop energi, dan utilitas penunjang.',
    coordinates: [
      [-6.1920, 106.9210],
      [-6.1940, 106.9140],
      [-6.2025, 106.9090],
      [-6.2030, 106.9222],
      [-6.1950, 106.9220],
      [-6.1920, 106.9210],
    ],
  },
]

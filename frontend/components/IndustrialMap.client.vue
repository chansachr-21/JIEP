<template>
  <div class="relative w-full rounded-2xl overflow-hidden border border-slate-700/60 shadow-2xl bg-slate-800">
    <!-- Map Container -->
    <div
      ref="mapContainer"
      class="w-full"
      style="height: 600px; min-height: 600px; width: 100%; position: relative; z-index: 10;"
    ></div>

    <!-- Master Plan Overlay Controls -->
    <div class="absolute top-4 left-14 z-20 bg-slate-900/90 backdrop-blur-md border border-slate-700/80 px-3.5 py-2.5 rounded-xl shadow-xl flex items-center gap-3 text-xs">
      <label class="flex items-center gap-2 cursor-pointer select-none text-white font-semibold">
        <input
          v-model="showMasterPlan"
          type="checkbox"
          class="w-4 h-4 rounded text-cyan-500 focus:ring-0 cursor-pointer accent-cyan-500"
        />
        <span class="flex items-center gap-1.5">
          <span>📐</span> Master Plan Zonasi JIEP
        </span>
      </label>

      <div v-if="showMasterPlan" class="flex items-center gap-2 pl-3 border-l border-slate-700">
        <span class="text-[10px] text-slate-400">Transparansi:</span>
        <input
          v-model.number="zoneOpacity"
          type="range"
          min="0.1"
          max="0.8"
          step="0.05"
          class="w-20 h-1.5 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-cyan-400"
        />
      </div>
    </div>

    <!-- Map Info Overlay (Right Top) -->
    <div class="absolute top-4 right-4 z-20 bg-slate-900/95 backdrop-blur-md border border-slate-700/80 p-3 rounded-xl shadow-xl max-w-xs text-xs space-y-1.5 hidden sm:block">
      <div class="flex items-center justify-between text-cyan-400 font-semibold uppercase tracking-wider text-[10px]">
        <span class="flex items-center gap-1.5">
          <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
          Kawasan Industri Pulogadung
        </span>
        <button
          @click="resetView"
          title="Kembalikan posisi peta ke kawasan KIP"
          class="px-2 py-0.5 rounded bg-slate-800 hover:bg-slate-700 text-cyan-400 font-bold text-[10px] border border-slate-700 transition-colors"
        >
          Pusat KIP
        </button>
      </div>
      <p class="text-slate-300 leading-relaxed text-[11px]">
        {{ locations.length }} titik lokasi terverifikasi + batas master plan 433 Ha PT JIEP.
      </p>
      <div class="pt-1.5 border-t border-slate-800 text-[10px] text-slate-400 flex items-center justify-between">
        <span>© OpenStreetMap contributors</span>
        <span class="text-cyan-400 font-mono">PT JIEP Official</span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue'
import type { MapLocation } from '~/types'
import { KIP_OUTER_BOUNDARY, KIP_ZONES, type KipZone } from '~/utils/kipMasterPlan'

const props = defineProps<{
  locations: MapLocation[]
  selectedCategory?: string
  loading?: boolean
  focusLocation?: MapLocation | null
}>()

const emit = defineEmits<{
  (e: 'select-location', location: MapLocation): void
  (e: 'select-zone', zone: KipZone): void
}>()

const mapContainer = ref<HTMLElement | null>(null)
let mapInstance: any = null
let markersLayer: any = null
let masterPlanLayer: any = null
let L: any = null

const showMasterPlan = ref(true)
const zoneOpacity = ref(0.45)

const DEFAULT_CENTER: [number, number] = [-6.1895, 106.9105] // Pulogadung industrial area
const DEFAULT_ZOOM = 14

const initMap = async () => {
  if (typeof window === 'undefined' || !mapContainer.value) return

  try {
    L = await import('leaflet')
    await import('leaflet/dist/leaflet.css')

    if (mapInstance) {
      mapInstance.remove()
      mapInstance = null
    }

    await nextTick()

    mapInstance = L.map(mapContainer.value, {
      zoomControl: true,
      attributionControl: true,
      scrollWheelZoom: true,
      preferCanvas: true,
    }).setView(DEFAULT_CENTER, DEFAULT_ZOOM)

    // CARTO Voyager Tiles (OpenStreetMap Data)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions" target="_blank">CARTO</a>',
      subdomains: 'abcd',
      maxZoom: 19,
    }).addTo(mapInstance)

    masterPlanLayer = L.layerGroup().addTo(mapInstance)
    markersLayer = L.layerGroup().addTo(mapInstance)

    renderMasterPlan()
    renderMarkers()

    setTimeout(() => { mapInstance?.invalidateSize() }, 150)
    setTimeout(() => { mapInstance?.invalidateSize() }, 450)
    setTimeout(() => { mapInstance?.invalidateSize() }, 900)
  } catch (err) {
    console.error('Error initializing map:', err)
  }
}

// Render Master Plan Polygons matching PT JIEP Instagram
const renderMasterPlan = () => {
  if (!mapInstance || !L || !masterPlanLayer) return
  masterPlanLayer.clearLayers()

  if (!showMasterPlan.value) return

  // 1. Draw Outer Boundary Polygon (Batas Kawasan 433 Ha)
  const outerBorder = L.polygon(KIP_OUTER_BOUNDARY, {
    color: '#06b6d4',
    weight: 3,
    dashArray: '6, 6',
    fillColor: '#0891b2',
    fillOpacity: 0.05,
  })

  outerBorder.bindTooltip('Batas Master Plan Kawasan Industri Pulogadung (433 Ha)', {
    permanent: false,
    direction: 'center',
    className: 'boundary-tooltip'
  })

  masterPlanLayer.addLayer(outerBorder)

  // 2. Draw Each Zoning Block
  KIP_ZONES.forEach((zone) => {
    const poly = L.polygon(zone.coordinates, {
      color: zone.color,
      weight: 1.5,
      fillColor: zone.color,
      fillOpacity: zoneOpacity.value,
    })

    poly.bindPopup(`
      <div style="font-family: system-ui, -apple-system, sans-serif; font-size: 12px; line-height: 1.4; color: #0f172a; padding: 4px; max-width: 260px;">
        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: ${zone.color}; letter-spacing: 0.05em;">
          ${zone.category}
        </span>
        <h4 style="margin: 3px 0 6px; font-size: 13px; font-weight: 700; color: #0f172a;">${zone.name}</h4>
        <p style="margin: 0 0 6px; color: #475569; font-size: 11px;">${zone.description}</p>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px; padding-top: 6px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #64748b;">
          <span>Sumber: Master Plan PT JIEP</span>
          <span style="font-weight: 600; color: #0284c7;">Danantara - JIEP</span>
        </div>
      </div>
    `)

    poly.on('mouseover', () => {
      poly.setStyle({ fillOpacity: Math.min(zoneOpacity.value + 0.25, 0.95), weight: 2.5 })
    })

    poly.on('mouseout', () => {
      poly.setStyle({ fillOpacity: zoneOpacity.value, weight: 1.5 })
    })

    poly.on('click', () => {
      emit('select-zone', zone)
    })

    masterPlanLayer.addLayer(poly)
  })
}

// Render Verified Point Markers
const renderMarkers = () => {
  if (!mapInstance || !L || !markersLayer) return
  markersLayer.clearLayers()

  const filtered = props.selectedCategory && props.selectedCategory !== 'all'
    ? props.locations.filter(l => l.type === props.selectedCategory)
    : props.locations

  const validLocations = filtered.filter(l => l.latitude && l.longitude)

  validLocations.forEach((loc) => {
    const color = loc.type === 'estate' ? '#8b5cf6'
      : loc.type === 'company' ? '#06b6d4'
      : loc.type === 'facility' ? '#10b981'
      : loc.type === 'access' ? '#f59e0b' : '#3b82f6'

    const iconEmoji = loc.type === 'estate' ? '🏢'
      : loc.type === 'company' ? '🏭'
      : loc.type === 'facility' ? '🏗️'
      : '🚪'

    const customIcon = L.divIcon({
      className: 'industria-marker',
      html: `
        <div style="background-color: ${color}; width: 34px; height: 34px; border-radius: 50%; border: 3px solid #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; font-size: 15px; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
          ${iconEmoji}
        </div>
      `,
      iconSize: [34, 34],
      iconAnchor: [17, 17],
      popupAnchor: [0, -18]
    })

    const marker = L.marker([loc.latitude, loc.longitude], { icon: customIcon, zIndexOffset: 1000 })

    marker.bindPopup(`
      <div style="font-family: system-ui, -apple-system, sans-serif; font-size: 12px; line-height: 1.4; color: #0f172a; padding: 4px; min-width: 220px;">
        <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: ${color}; letter-spacing: 0.05em;">
          ${loc.label}
        </span>
        <h4 style="margin: 3px 0 6px; font-size: 14px; font-weight: 700; color: #0f172a;">${loc.name}</h4>
        <p style="margin: 0 0 6px; color: #475569; font-size: 11px;">${loc.description || 'Lokasi terverifikasi di Kawasan Industri Pulogadung.'}</p>
        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px; padding-top: 6px; border-top: 1px solid #e2e8f0;">
          <span style="display: inline-block; padding: 2px 6px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; border-radius: 9999px; font-size: 10px; font-weight: 600;">
            ✓ Terverifikasi
          </span>
          <span style="font-size: 10px; color: #64748b; font-family: monospace;">
            ${loc.latitude.toFixed(4)}, ${loc.longitude.toFixed(4)}
          </span>
        </div>
      </div>
    `)

    marker.on('click', () => {
      emit('select-location', loc)
    })

    markersLayer.addLayer(marker)
  })

  // Fit bounds if we have valid locations and no specific focus
  if (validLocations.length > 0 && !props.focusLocation) {
    try {
      const group = L.featureGroup(markersLayer.getLayers())
      mapInstance.fitBounds(group.getBounds().pad(0.18))
    } catch {
      mapInstance.setView(DEFAULT_CENTER, DEFAULT_ZOOM)
    }
  }
}

const resetView = () => {
  if (mapInstance) {
    mapInstance.setView(DEFAULT_CENTER, DEFAULT_ZOOM)
    mapInstance.invalidateSize()
  }
}

watch(showMasterPlan, () => {
  renderMasterPlan()
})

watch(zoneOpacity, () => {
  renderMasterPlan()
})

watch(() => props.focusLocation, (newLoc) => {
  if (newLoc && mapInstance && newLoc.latitude && newLoc.longitude) {
    mapInstance.flyTo([newLoc.latitude, newLoc.longitude], 16, {
      duration: 1.2
    })
  }
})

watch(() => props.locations, () => {
  renderMarkers()
  setTimeout(() => mapInstance?.invalidateSize(), 200)
}, { deep: true })

watch(() => props.selectedCategory, () => {
  renderMarkers()
})

onMounted(() => {
  initMap()
  window.addEventListener('resize', () => {
    mapInstance?.invalidateSize()
  })
})

onBeforeUnmount(() => {
  if (mapInstance) {
    mapInstance.remove()
    mapInstance = null
  }
})
</script>

<style>
.leaflet-container {
  width: 100% !important;
  height: 100% !important;
  min-height: 600px !important;
  background-color: #e2e8f0 !important;
  font-family: inherit;
}
.leaflet-popup-content-wrapper {
  border-radius: 12px !important;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4) !important;
  border: 1px solid #cbd5e1;
}
.leaflet-popup-content {
  margin: 10px 14px !important;
}
.boundary-tooltip {
  background-color: rgba(15, 23, 42, 0.9) !important;
  color: #38bdf8 !important;
  border: 1px solid #0284c7 !important;
  border-radius: 8px !important;
  font-size: 11px !important;
  font-weight: 700 !important;
  padding: 4px 8px !important;
}
</style>

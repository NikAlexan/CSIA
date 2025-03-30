<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import MicrogreenChart from '@/components/Charts/MicrogreenChart.vue'
import { ref, computed } from 'vue'

// The backend sends sensorChart data and an object "enabledGraphs" to toggle charts.
const { sensorChart, enabledGraphs } = defineProps<{
  sensorChart: {
    timestamp: string
    soil1: number
    soil2: number
    soil3: number
    soil4: number
    soil5: number
    air_temperature: number
    water_temperature: number
    air_humidity: number
    light_level: number
  }[],
  enabledGraphs: {
    soil: boolean,
    temperature: boolean,
    environment: boolean,
  }
}>()

// Build labels from the sensor timestamps.
const labels = sensorChart.map(item =>
  new Date(item.timestamp).toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' })
)

// UI state for live adjustment.
const showSoil = ref(enabledGraphs.soil)
const showTemp = ref(enabledGraphs.temperature)
const showEnv = ref(enabledGraphs.environment)
const maxTicks = ref(10)

// Soil moisture chart data (for sensors soil1 to soil5).
const soilChartData = computed(() => ({
  labels,
  datasets: ['soil1', 'soil2', 'soil3', 'soil4', 'soil5'].map((key, i) => ({
    label: `Почва ${i + 1}`,
    data: sensorChart.map(item => item[key]),
    borderColor: ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444'][i],
    fill: false,
    tension: 0.4,
  })),
}))

// Temperature chart data for air and water.
const tempChartData = computed(() => ({
  labels,
  datasets: [
    {
      label: 'Температура воздуха (°C)',
      data: sensorChart.map(item => item.air_temperature),
      borderColor: '#2563eb',
      fill: false,
      tension: 0.4,
    },
    {
      label: 'Температура воды (°C)',
      data: sensorChart.map(item => item.water_temperature),
      borderColor: '#06b6d4',
      fill: false,
      tension: 0.4,
    },
  ],
}))

// Environment chart: air humidity and light level.
const envChartData = computed(() => ({
  labels,
  datasets: [
    {
      label: 'Влажность воздуха (%)',
      data: sensorChart.map(item => item.air_humidity),
      borderColor: '#f43f5e',
      fill: false,
      tension: 0.4,
    },
    {
      label: 'Освещённость (lx)',
      data: sensorChart.map(item => item.light_level),
      borderColor: '#facc15',
      fill: false,
      tension: 0.4,
    },
  ],
}))

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Панель управления', href: '/dashboard' },
]
</script>

<template>
  <Head title="Панель управления" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-8 p-6">
      <!-- Настройки графиков -->
      <div class="bg-white dark:bg-sidebar rounded-xl border p-4 flex flex-wrap gap-4 items-center justify-between shadow">
        <div class="flex flex-wrap gap-4 items-center">
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" v-model="showSoil" />
            Почва
          </label>
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" v-model="showTemp" />
            Температура
          </label>
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" v-model="showEnv" />
            Влажность/Свет
          </label>
        </div>
        <div class="flex items-center gap-2 text-sm">
          <label for="ticks">Метки оси X:</label>
          <input type="range" min="5" max="50" step="1" v-model.number="maxTicks" />
          <span class="w-8 text-center">{{ maxTicks }}</span>
        </div>
      </div>

      <!-- График для влажности почвы -->
      <section v-if="showSoil" class="bg-white dark:bg-sidebar border rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">🌱 Влажность почвы</h2>
        <div class="h-[400px] overflow-x-auto">
          <MicrogreenChart :chartData="soilChartData" :maxTicks="maxTicks" />
        </div>
      </section>

      <!-- График для температуры -->
      <section v-if="showTemp" class="bg-white dark:bg-sidebar border rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">🌡 Температура</h2>
        <div class="h-[400px] overflow-x-auto">
          <MicrogreenChart :chartData="tempChartData" :maxTicks="maxTicks" />
        </div>
      </section>

      <!-- График для влажности и освещённости -->
      <section v-if="showEnv" class="bg-white dark:bg-sidebar border rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">💧 Влажность/Свет</h2>
        <div class="h-[400px] overflow-x-auto">
          <MicrogreenChart :chartData="envChartData" :maxTicks="maxTicks" />
        </div>
      </section>
    </div>
  </AppLayout>
</template>

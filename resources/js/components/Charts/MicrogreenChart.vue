<script setup>
import {
  Chart as ChartJS,
  Title, Tooltip, Legend,
  LineElement, PointElement,
  CategoryScale, LinearScale
} from 'chart.js'
import { Line } from 'vue-chartjs'
import { ref, watch } from 'vue'

ChartJS.register(
  Title, Tooltip, Legend,
  LineElement, PointElement,
  CategoryScale, LinearScale
)

const props = defineProps({
  chartData: Object,
  maxTicks: {
    type: Number,
    default: 10
  }
})

// Ref to store chart instance
const chartRef = ref(null)

// Chart options (function so it's recreated on tick change)
const getChartOptions = () => ({
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: { display: true },
    tooltip: { mode: 'index', intersect: false },
  },
  scales: {
    x: {
      ticks: {
        autoSkip: true,
        callback: function (value, index, ticks) {
          const step = Math.ceil(ticks.length / props.maxTicks)
          return index % step === 0 ? this.getLabelForValue(value) : ''
        },
        maxRotation: 0,
        minRotation: 0,
      }
    },
    y: {
      beginAtZero: false
    }
  }
})

// Watch for tick changes and re-render chart
watch(() => props.maxTicks, () => {
  if (chartRef.value?.chart) {
    chartRef.value.chart.destroy()
    chartRef.value.renderChart()
    console.log('🌀 Re-rendered chart with maxTicks =', props.maxTicks)
  }
})
</script>

<template>
  <Line
    ref="chartRef"
    :data="chartData"
    :options="getChartOptions()"
  />

  <!-- Debug output -->
  <details class="text-xs bg-gray-100 dark:bg-gray-800 p-2 rounded mt-4">
    <summary class="cursor-pointer">🧪 chartData Debug</summary>
    <pre>{{ chartData }}</pre>
  </details>
</template>

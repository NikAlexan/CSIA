<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import MicrogreenChart from '@/components/Charts/MicrogreenChart.vue';

// ✅ Declare props first
const props = defineProps<{
  microgreenChart: { date: string; total: number }[]
}>()

// ✅ Then use props.microgreenChart
const chartData = {
  labels: props.microgreenChart.map(item => item.date),
  datasets: [{
    label: 'Рост микрозелени по дням',
    data: props.microgreenChart.map(item => item.total),
    borderColor: '#10b981',
    backgroundColor: 'rgba(16, 185, 129, 0.2)',
    tension: 0.3,
    fill: true,
    pointRadius: 4,
    pointHoverRadius: 6,
  }]
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Панель управления', href: '/dashboard' }
];
</script>


<template>
  <Head title="Панель управления" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-6 p-6">

      <!-- Greeting Section -->
      <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-6 rounded-2xl shadow">
        <h1 class="text-2xl font-bold">Добро пожаловать!</h1>
        <p class="mt-2 text-sm text-green-100">
          Это ваша панель мониторинга микрозелени. Следите за динамикой роста, поливами и наблюдениями.
        </p>
      </div>

      <!-- Main Chart Section -->
      <div class="bg-white dark:bg-sidebar border border-gray-200 dark:border-sidebar-border rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">📈 Статистика микрозелени</h2>

        <div class="h-[320px]">
          <MicrogreenChart :chartData="chartData" />
        </div>
      </div>

      <!-- Placeholder / Upcoming Block -->
      <div class="bg-white dark:bg-sidebar border border-dashed border-gray-300 dark:border-sidebar-border rounded-2xl p-6 flex items-center justify-center h-48 text-gray-400 dark:text-gray-600">
        <p class="text-sm">Здесь скоро появится новый функционал 🌱</p>
      </div>

    </div>
  </AppLayout>
</template>

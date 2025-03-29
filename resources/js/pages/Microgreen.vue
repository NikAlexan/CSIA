<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import MicrogreenList from '../components/Microgreen/List.vue';

const props = defineProps({
    someData: String,
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Microgreen',
        href: '/microgreen',
    },
];
</script>

<template>
    <Head title="Microgreen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <MicrogreenList />
            </div>
        </div>
    </AppLayout>
</template>

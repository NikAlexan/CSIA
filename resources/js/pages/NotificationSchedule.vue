<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import NotificationScheduleList from '../components/NotificationSchedule/List.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notifications schedule',
        href: '/notifications/schedule',
    },
];
</script>

<template>
    <Head title="Batches" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full rounded-xl p-4">
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <NotificationScheduleList :notificationsSchedule="$page.props.notificationsSchedule" />
            </div>
        </div>
    </AppLayout>
</template>

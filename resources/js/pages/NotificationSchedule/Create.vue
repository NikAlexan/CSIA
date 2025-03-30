<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ErrorMessage, Field, useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';

interface NotificationType {
    name: string
    value: string
}

const props = defineProps<{
    types: NotificationType[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notification Schedules',
        href: '/notifications/schedule',
    },
    {
        title: 'Create',
        href: '/notifications/schedule/create',
    },
];

// Define form schema matching your store validation
const formSchema = toTypedSchema(
    z.object({
        type: z.string().min(1, 'Type is required'),
        notify_at: z.string().regex(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/, 'Must be in HH:MM format'),
        message: z.string().optional(),
        enabled: z.boolean().default(true),
    })
);

const { handleSubmit } = useForm({
    validationSchema: formSchema,
    initialValues: {
        enabled: true,
        notify_at: '08:00' // Default time
    }
});

const onSubmit = handleSubmit(async (values) => {
    try {
        router.post('/notifications/schedule', {
            ...values,
            notify_at: values.notify_at ? `${values.notify_at}:00` : null // Add seconds for backend
        }, {
            onSuccess: () => {
                router.visit('/notifications/schedule'); // Redirect to index
            }
        });
    } catch (error) {
        console.error('Error creating notification schedule:', error);
    }
});
</script>

<template>
    <Head title="Create Notification Schedule" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 max-w-2xl mx-auto p-6">
            <h1 class="text-2xl font-bold">Create New Notification Schedule</h1>

            <form @submit="onSubmit" class="space-y-6">
                <!-- Type Field -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">
                        Type *
                    </label>
                    <Field
                        as="select"
                        id="type"
                        name="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Select a notification type</option>
                        <option
                            v-for="type in props.types"
                            :key="type.value"
                            :value="type.value"
                        >
                            {{ type.name }}
                        </option>
                    </Field>
                    <ErrorMessage name="type" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Notification Time -->
                <div>
                    <label for="notify_at" class="block text-sm font-medium text-gray-700">
                        Notification Time (HH:MM) *
                    </label>
                    <Field
                        id="notify_at"
                        name="notify_at"
                        type="time"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        step="60"
                    />
                    <ErrorMessage name="notify_at" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">
                        Message
                    </label>
                    <Field
                        as="textarea"
                        id="message"
                        name="message"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Optional notification message"
                    />
                    <ErrorMessage name="message" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Enabled Toggle -->
                <div class="flex items-center">
                    <Field
                        id="enabled"
                        name="enabled"
                        type="checkbox"
                        :value="true"
                        :unchecked-value="false"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    />
                    <label for="enabled" class="ml-2 block text-sm text-gray-700">
                        Enabled
                    </label>
                    <ErrorMessage name="enabled" class="ml-2 text-sm text-red-600" />
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Create Schedule
                    </button>
                    <button
                        type="button"
                        @click="router.visit('/notifications/schedule')"
                        class="flex-1 justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

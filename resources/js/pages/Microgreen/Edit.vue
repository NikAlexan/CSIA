<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ErrorMessage, Field, useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';

interface Microgreen {
    id: bigint
    name: string
    germination_min_days: number
    germination_max_days: number
    temperature_min: number
    temperature_max: number
    light: string
}

const props = defineProps<{
    microgreen: Microgreen
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Microgreens',
        href: '/microgreens',
    },
    {
        title: 'Edit',
        href: `/microgreens/${props.microgreen.id}/edit`,
    },
];

// Define form schema matching your update validation
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(1, 'Name is required'),
        germination_min_days: z.coerce.number().min(0, 'Must be positive'),
        germination_max_days: z.coerce.number().min(0, 'Must be positive'),
        temperature_min: z.coerce.number(),
        temperature_max: z.coerce.number(),
        light: z.string().optional(),
    }).refine(data => data.germination_max_days >= data.germination_min_days, {
        message: "Max days must be greater than or equal to min days",
        path: ["germination_max_days"]
    }).refine(data => data.temperature_max >= data.temperature_min, {
        message: "Max temperature must be greater than or equal to min temperature",
        path: ["temperature_max"]
    })
);

const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
});

// Set initial form values
setValues({
    name: props.microgreen.name,
    germination_min_days: props.microgreen.germination_min_days,
    germination_max_days: props.microgreen.germination_max_days,
    temperature_min: props.microgreen.temperature_min,
    temperature_max: props.microgreen.temperature_max,
    light: props.microgreen.light || ''
});

const onSubmit = handleSubmit(async (values) => {
    try {
        router.patch(`/microgreens/${props.microgreen.id}`, values, {
            onSuccess: () => {
                router.visit('/microgreens');
            }
        });
    } catch (error) {
        console.error('Error updating microgreen:', error);
    }
});
</script>

<template>
    <Head title="Edit Microgreen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 max-w-2xl mx-auto p-6">
            <h1 class="text-2xl font-bold">Edit Microgreen</h1>

            <form @submit="onSubmit" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Name *
                    </label>
                    <Field
                        id="name"
                        name="name"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Microgreen name"
                    />
                    <ErrorMessage name="name" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="germination_min_days" class="block text-sm font-medium text-gray-700">
                            Min Germination Days *
                        </label>
                        <Field
                            id="germination_min_days"
                            name="germination_min_days"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="3"
                            min="0"
                        />
                        <ErrorMessage name="germination_min_days" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="germination_max_days" class="block text-sm font-medium text-gray-700">
                            Max Germination Days *
                        </label>
                        <Field
                            id="germination_max_days"
                            name="germination_max_days"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="7"
                            min="0"
                        />
                        <ErrorMessage name="germination_max_days" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="temperature_min" class="block text-sm font-medium text-gray-700">
                            Min Temperature (°C) *
                        </label>
                        <Field
                            id="temperature_min"
                            name="temperature_min"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="18"
                            step="0.1"
                        />
                        <ErrorMessage name="temperature_min" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="temperature_max" class="block text-sm font-medium text-gray-700">
                            Max Temperature (°C) *
                        </label>
                        <Field
                            id="temperature_max"
                            name="temperature_max"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="24"
                            step="0.1"
                        />
                        <ErrorMessage name="temperature_max" class="mt-2 text-sm text-red-600" />
                    </div>
                </div>

                <div>
                    <label for="light" class="block text-sm font-medium text-gray-700">
                        Light Requirements
                    </label>
                    <Field
                        id="light"
                        name="light"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Partial shade"
                    />
                    <ErrorMessage name="light" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                    >
                        Update Microgreen
                    </button>
                    <button
                        type="button"
                        @click="router.visit('/microgreens')"
                        class="flex-1 justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

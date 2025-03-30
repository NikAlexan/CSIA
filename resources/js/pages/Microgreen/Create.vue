<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ErrorMessage, Field, useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Microgreens',
        href: '/microgreens',
    },
    {
        title: 'Create',
        href: '/microgreens/create',
    },
];

// Define form schema matching your store validation
const formSchema = toTypedSchema(
    z.object({
        name: z.string().min(1, 'Name is required'),
        germination_min_days: z.coerce.number().min(0).optional(),
        germination_max_days: z.coerce.number().min(0).optional(),
        temperature_min: z.coerce.number().optional(),
        temperature_max: z.coerce.number().optional(),
        light: z.string().optional(),
    })
);

const { handleSubmit } = useForm({
    validationSchema: formSchema,
});

const onSubmit = handleSubmit(async (values) => {
    try {
        router.post('/microgreens', {
            ...values,
            // Convert to strings if needed for your backend
            germination_min_days: values.germination_min_days
                ? values.germination_min_days
                : 3,
            temperature_min: values.temperature_min
                ? values.temperature_max
                : 18,
            // Convert to strings if needed for your backend
            germination_max_days: values.germination_max_days
                ? values.germination_max_days
                : 7,
            temperature_max: values.temperature_max
                ? values.temperature_max
                : 24,
        });
    } catch (error) {
        console.error('Error creating microgreen:', error);
    }
});
</script>

<template>
    <Head title="Create Microgreen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 max-w-2xl mx-auto p-6">
            <h1 class="text-2xl font-bold">Create New Microgreen</h1>

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
                            Min Germination Days
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
                            Max Germination Days
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
                            Min Temperature (°C)
                        </label>
                        <Field
                            id="temperature_min"
                            name="temperature_min"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="18"
                        />
                        <ErrorMessage name="temperature_min" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <label for="temperature_max" class="block text-sm font-medium text-gray-700">
                            Max Temperature (°C)
                        </label>
                        <Field
                            id="temperature_max"
                            name="temperature_max"
                            type="number"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="24"
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

                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    Create Microgreen
                </button>
            </form>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ErrorMessage, Field, useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';

interface User {
    id: number
    name: string
}

interface Microgreen {
    id: number
    name: string
}

const props = defineProps<{
    users: User[]
    microgreen: Microgreen[]
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Batches',
        href: '/batches',
    },
    {
        title: 'Create',
        href: '/batches/create',
    },
];

// Define form schema matching your store validation
const formSchema = toTypedSchema(
    z.object({
        user_id: z.number().min(1, 'User is required'),
        microgreen_id: z.number().min(1, 'Microgreen is required'),
        dateOfSowing: z.string().min(1, 'Sowing date is required'),
        dateOfCollection: z.string().min(1, 'Collection date is required'),
    })
);

const { handleSubmit } = useForm({
    validationSchema: formSchema,
});

const onSubmit = handleSubmit(async (values) => {
    try {
        router.post('/batches', values, {
            onSuccess: () => {
                router.visit('/batches');
            }
        });
    } catch (error) {
        console.error('Error creating batch:', error);
    }
});
</script>

<template>
    <Head title="Create Batch" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 max-w-2xl mx-auto p-6">
            <h1 class="text-2xl font-bold">Create New Batch</h1>

            <form @submit="onSubmit" class="space-y-6">
                <!-- User Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">
                        User *
                    </label>
                    <Field
                        as="select"
                        id="user_id"
                        name="user_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Select a user</option>
                        <option
                            v-for="user in props.users"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </Field>
                    <ErrorMessage name="user_id" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Microgreen Selection -->
                <div>
                    <label for="microgreen_id" class="block text-sm font-medium text-gray-700">
                        Microgreen *
                    </label>
                    <Field
                        as="select"
                        id="microgreen_id"
                        name="microgreen_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Select a microgreen</option>
                        <option
                            v-for="mg in props.microgreen"
                            :key="mg.id"
                            :value="mg.id"
                        >
                            {{ mg.name }}
                        </option>
                    </Field>
                    <ErrorMessage name="microgreen_id" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Sowing Date -->
                <div>
                    <label for="dateOfSowing" class="block text-sm font-medium text-gray-700">
                        Sowing Date *
                    </label>
                    <Field
                        id="dateOfSowing"
                        name="dateOfSowing"
                        type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <ErrorMessage name="dateOfSowing" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Collection Date -->
                <div>
                    <label for="dateOfCollection" class="block text-sm font-medium text-gray-700">
                        Collection Date *
                    </label>
                    <Field
                        id="dateOfCollection"
                        name="dateOfCollection"
                        type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <ErrorMessage name="dateOfCollection" class="mt-2 text-sm text-red-600" />
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    Create Batch
                </button>
            </form>
        </div>
    </AppLayout>
</template>

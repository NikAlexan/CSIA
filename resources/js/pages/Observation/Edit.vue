<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ErrorMessage, Field, useForm } from 'vee-validate';
import { toTypedSchema } from '@vee-validate/zod';
import { z } from 'zod';

interface Batch {
    id: number
    name: string
}

interface Observation {
    id: number
    batch_id: number
    date: string
    visualChanges: string
    image_url: string
    height: string
    notes?: string
}

const props = defineProps<{
    batches: Batch[]
    observation: Observation
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Observations',
        href: '/observations',
    },
    {
        title: 'Edit',
        href: `/observations/${props.observation.id}/edit`,
    },
];

// Define form schema matching your store validation
const formSchema = toTypedSchema(
    z.object({
        batch_id: z.string().min(1, 'Batch is required'),
        date: z.string().min(1, 'Date is required'),
        visualChanges: z.string().min(1, 'Visual changes description is required'),
        image: z.instanceof(File).optional(),
        height: z.string().min(1, 'Height is required'),
        notes: z.string().optional(),
    })
);

const { handleSubmit, setFieldValue, setValues } = useForm({
    validationSchema: formSchema,
});

// Set initial values from the observation prop
setValues({
    batch_id: props.observation.batch_id.toString(),
    date: props.observation.date.split('T')[0], // Format date for input[type="date"]
    visualChanges: props.observation.visualChanges,
    height: props.observation.height,
    notes: props.observation.notes || '',
});

const onSubmit = handleSubmit(async (values) => {
    try {
        const formData = new FormData();
        formData.append('batch_id', values.batch_id);
        formData.append('date', values.date);
        formData.append('visualChanges', values.visualChanges);
        if (values.image) formData.append('image', values.image);
        formData.append('height', values.height);
        if (values.notes) formData.append('notes', values.notes);
        formData.append('_method', 'PUT'); // For Laravel to recognize as PUT request

        router.path(`/observations/${props.observation.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
            onSuccess: () => {
                router.visit('/observations');
            }
        });
    } catch (error) {
        console.error('Error updating observation:', error);
    }
});

const handleImageChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        setFieldValue('image', input.files[0]);
    }
};
</script>

<template>
    <Head title="Edit Observation" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 max-w-2xl mx-auto p-6">
            <h1 class="text-2xl font-bold">Edit Observation</h1>

            <form @submit="onSubmit" class="space-y-6" enctype="multipart/form-data">
                <!-- Batch Selection -->
                <div>
                    <label for="batch_id" class="block text-sm font-medium text-gray-700">
                        Batch *
                    </label>
                    <Field
                        as="select"
                        id="batch_id"
                        name="batch_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Select a batch</option>
                        <option
                            v-for="batch in batches"
                            :key="batch.id"
                            :value="batch.id"
                            :selected="batch.id === observation.batch_id"
                        >
                            {{ batch.name }}
                        </option>
                    </Field>
                    <ErrorMessage name="batch_id" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">
                        Date *
                    </label>
                    <Field
                        id="date"
                        name="date"
                        type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                    <ErrorMessage name="date" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Visual Changes -->
                <div>
                    <label for="visualChanges" class="block text-sm font-medium text-gray-700">
                        Visual Changes *
                    </label>
                    <Field
                        as="textarea"
                        id="visualChanges"
                        name="visualChanges"
                        rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Describe visual changes"
                    />
                    <ErrorMessage name="visualChanges" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        Image
                    </label>
                    <div class="mt-1 flex items-center">
                        <img
                            v-if="observation.image_url"
                            :src="observation.image_url"
                            class="h-16 w-16 object-cover rounded-md mr-4"
                            alt="Current observation image"
                        />
                        <input
                            id="image"
                            name="image"
                            type="file"
                            accept="image/*"
                            @change="handleImageChange"
                            class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100"
                        />
                    </div>
                    <small class="text-gray-500">Leave empty to keep current image</small>
                    <ErrorMessage name="image" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Height -->
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">
                        Height *
                    </label>
                    <Field
                        id="height"
                        name="height"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter height measurement"
                    />
                    <ErrorMessage name="height" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">
                        Notes
                    </label>
                    <Field
                        as="textarea"
                        id="notes"
                        name="notes"
                        rows="2"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Additional notes (optional)"
                    />
                    <ErrorMessage name="notes" class="mt-2 text-sm text-red-600" />
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        Update Observation
                    </button>
                    <button
                        type="button"
                        @click="router.visit('/observations')"
                        class="flex-1 justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

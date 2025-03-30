<script setup lang="ts">
import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import {
    ColumnFiltersState,
    createColumnHelper,
    FlexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    SortingState,
    useVueTable,
} from '@tanstack/vue-table'
import { h, ref } from 'vue'
import { ChevronsUpDown, ImageIcon } from "lucide-vue-next"
import {Link, router} from "@inertiajs/vue3"
import { format } from 'date-fns'

interface Observation {
    id: number
    date: Date | string
    image_url: string | null
    height: number | null
}

const { observations } = defineProps<{ observations: Observation[] }>()

const columnHelper = createColumnHelper<Observation>()

const columns = [
    columnHelper.accessor('date', {
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Date', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const date = row.getValue<Date>('date')
            return h('div', date ? format(new Date(date), 'MMM dd, yyyy') : 'N/A')
        },
        sortingFn: 'datetime'
    }),
    columnHelper.accessor('height', {
        header: 'Height',
        cell: ({ row }) => h('div', row.getValue('height') ?? 'N/A')
    }),
    columnHelper.accessor('image_url', {
        header: 'Visual',
        cell: ({ row }) => {
            const imageUrl = row.getValue<string | null>('image_url')
            return imageUrl
                ? h('div', { class: 'flex' }, [
                    h('img', {
                        src: imageUrl,
                        class: 'h-20 w-20 object-cover rounded-md cursor-pointer',
                        onClick: () => window.open(imageUrl, '_blank')
                    })
                ])
                : h(ImageIcon, { class: 'h-5 w-5 text-gray-400' })
        }
    }),
    columnHelper.display({
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => h('div', { class: 'flex gap-2' }, [
            h(Button, {
                variant: 'ghost',
                class: 'text-blue-500 hover:text-blue-700',
                onClick: () => router.get(`/observations/${row.original.id}/edit`)
            }, 'Edit'),
            h(Button, {
                variant: 'ghost',
                class: 'text-red-500 hover:text-red-700',
                onClick: () => confirm('Delete this item?') && router.delete(`/observations/${row.original.id}`)
            }, 'Delete')
        ])
    })
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])

const table = useVueTable({
    data: observations,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
    },
})
</script>

<template>
    <div class="w-full p-4">
        <div class="flex gap-2 items-center py-4">
            <a href="/observations/create" class="rounded-md text-sm font-medium ring-offset-background bg-green-600 hover:bg-green-700 text-white px-4 py-2">
                New Observation
            </a>
        </div>
        <div class="rounded-md border overflow-x-auto">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow v-for="row in table.getRowModel().rows" :key="row.id" :data-state="row.getIsSelected() && 'selected'">
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                    </template>
                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            No observations found.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>

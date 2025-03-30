<script setup lang="ts">
import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
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
import { ChevronsUpDown } from "lucide-vue-next"
import {Link, router} from "@inertiajs/vue3"
import { format } from 'date-fns'

interface Microgreen {
    id: bigint
    name: string
    germination_time: string
    temperature: string
    value: boolean
}

interface Batch {
    id: number
    user_id: number
    microgreen_id: number
    microgreen: Microgreen
    dateOfSowing: Date | string
    dateOfCollection: Date | string | null
    light: string
}

const { batches } = defineProps<{ batches: Batch[] }>()

const columnHelper = createColumnHelper<Batch>()

const columns = [
    columnHelper.accessor(row => row.microgreen.name, {
        id: 'microgreen_name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Microgreen', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div',  `ID:${row.original.id} - ${row.getValue('microgreen_name')}` || 'N/A'),
    }),
    columnHelper.accessor('dateOfSowing', {
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Sowing Date', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const date = row.getValue<Date>('dateOfSowing')
            return h('div', date ? format(new Date(date), 'MMM dd, yyyy') : 'N/A')
        },
        sortingFn: 'datetime'
    }),
    columnHelper.accessor('dateOfCollection', {
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Collection Date', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const date = row.getValue<Date | null>('dateOfCollection')
            return h('div', date ? format(new Date(date), 'MMM dd, yyyy') : 'Not collected')
        },
        sortingFn: 'datetime'
    }),
    columnHelper.display({
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => h('div', { class: 'flex gap-2' }, [
            h(Button, {
                variant: 'ghost',
                class: 'text-blue-500 hover:text-blue-700',
                onClick: () => router.get(`/batches/${row.original.id}/edit`)
            }, 'Edit'),
            h(Button, {
                variant: 'ghost',
                class: 'text-red-500 hover:text-red-700',
                onClick: () => confirm('Delete this item?') && router.delete(`/batches/${row.original.id}`)
            }, 'Delete')
        ])
    })
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])

const table = useVueTable({
    data: batches,
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
            <a href="/batches/create" class="rounded-md text-sm font-medium ring-offset-background bg-green-600 hover:bg-green-700 text-white px-4 py-2">
                Create Batch
            </a>
            <Input
                class="max-w-sm"
                placeholder="Filter by microgreen name..."
                :model-value="table.getColumn('microgreen_name')?.getFilterValue() as string"
                @update:model-value="table.getColumn('microgreen_name')?.setFilterValue($event)"
            />
        </div>
        <div class="rounded-md border">
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
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>
                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            No batches found.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>

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
import { ChevronsUpDown, Bell, ToggleRight, ToggleLeft } from "lucide-vue-next"
import { router } from '@inertiajs/vue3'

interface NotificationSchedule {
    id: number
    type: string
    type_name: string
    notify_at: string
    enabled: boolean
    message: string
}

const { notificationsSchedule } = defineProps<{ notificationsSchedule: NotificationSchedule[] }>()

const columnHelper = createColumnHelper<NotificationSchedule>()

const columns = [
    columnHelper.accessor('type_name', {
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Notification Type', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'flex items-center gap-2' }, row.getValue('type_name'))
    }),
    columnHelper.accessor('notify_at', {
        header: 'Scheduled Time',
        cell: ({ row }) => h('div', { class: 'flex items-center gap-2' }, [
            h(Bell, { class: 'w-4 h-4' }),
            row.getValue('notify_at')
        ])
    }),
    columnHelper.accessor('enabled', {
        header: 'Status',
        cell: ({ row }) => h('div', { class: 'flex items-center gap-2' }, [
            row.getValue('enabled')
                ? h(ToggleRight, { class: 'w-5 h-5 text-green-500' })
                : h(ToggleLeft, { class: 'w-5 h-5 text-gray-400' }),
            row.getValue('enabled') ? 'Active' : 'Inactive'
        ])
    }),
    columnHelper.accessor('message', {
        header: 'Message',
        cell: ({ row }) => h('div', {
            class: 'truncate max-w-[200px]',
            title: row.getValue('message')
        }, row.getValue('message'))
    }),
    columnHelper.display({
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => h('div', { class: 'flex gap-2' }, [
            h(Button, {
                variant: 'ghost',
                class: 'text-blue-500 hover:text-blue-700',
                onClick: () => router.get(`/notifications/schedule/${row.original.id}/edit`)
            }, 'Edit'),
            h(Button, {
                variant: 'ghost',
                class: 'text-red-500 hover:text-red-700',
                onClick: () => confirm('Delete this schedule?') && router.delete(`/notifications/schedule/${row.original.id}`,
                    {onSuccess: () => router.visit('/notifications/schedule') }
                ),
            }, 'Delete')
        ])
    })
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])

const table = useVueTable({
    data: notificationsSchedule,
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
            <a href="/notifications/schedule/create" class="rounded-md text-sm font-medium ring-offset-background bg-green-600 hover:bg-green-700 text-white px-4 py-2">
                New Schedule
            </a>
            <Input
                class="max-w-sm"
                placeholder="Filter by type..."
                :model-value="table.getColumn('type_name')?.getFilterValue() as string"
                @update:model-value="table.getColumn('type_name')?.setFilterValue($event)"
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
                            No schedules found.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>

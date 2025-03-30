<script setup lang="ts">
import { cn, valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input' // Add this import
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
  createColumnHelper, ExpandedState,
  FlexRender,
  getCoreRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel, SortingState,
  useVueTable, VisibilityState,
} from '@tanstack/vue-table'
import {h, ref, watch} from 'vue'
import {ChevronsUpDown} from "lucide-vue-next";
import {Link, router} from "@inertiajs/vue3";

export interface Microgreen {
  id: bigint
  name: string
  germination_time: string
  temperature: string
  light: string
  value: boolean
}

const { microgreen } = defineProps<{ microgreen: Microgreen[] }>()

const columnHelper = createColumnHelper<Microgreen>()

const columns = [
  columnHelper.accessor('name', {
    header: ({ column }) => {
      return h(Button, {
        variant: 'ghost',
        onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
      }, () => ['Name', h(ChevronsUpDown, { class: 'ml-2 h-4 w-4' })])
    },
    cell: ({ row }) => h('div', row.getValue('name')),
  }),
  columnHelper.accessor('germination_time', {
    header: 'Germination Time',
    cell: ({ row }) => h('div', row.getValue('germination_time')),
  }),
  columnHelper.accessor('temperature', {
    header: 'Temperature',
    cell: ({ row }) => h('div', row.getValue('temperature')),
  }),
  columnHelper.accessor('light', {
    header: 'Light',
    cell: ({ row }) => h('div', row.getValue('light')),
  }),
  columnHelper.display({
    id: 'actions',
    header: 'Actions',
    cell: ({ row }) => h('div', { class: 'flex gap-2' }, [
      h(Button, {
        variant: 'ghost',
        class: 'text-blue-500 hover:text-blue-700',
        onClick: () => router.get(`/microgreens/${row.original.id}/edit`)
      }, 'Edit'),
      h(Button, {
        variant: 'ghost',
        class: 'text-red-500 hover:text-red-700',
        onClick: () => confirm('Delete this microgreen?') && router.delete(`/microgreens/${row.original.id}`)
      }, 'Delete')
    ])
  })
]

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable({
  data: microgreen,
  columns,
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
  onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
  state: {
    get sorting() { return sorting.value },
    get columnFilters() { return columnFilters.value },
    get columnVisibility() { return columnVisibility.value },
    get rowSelection() { return rowSelection.value },
  },
})
</script>

<template>
  <div class="w-full p-4">
    <div class="flex gap-2 items-center py-4">
      <a href="/microgreen/create" class="rounded-md text-sm font-medium ring-offset-background bg-green-600 hover:bg-green-700 text-white px-4 py-2">
        Create Microgreen
      </a>
      <!-- Add the filter input -->
      <Input
          class="max-w-sm"
          placeholder="Filter microgreens by name..."
          :model-value="table.getColumn('name')?.getFilterValue() as string"
          @update:model-value="table.getColumn('name')?.setFilterValue($event)"
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
              No results found.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>

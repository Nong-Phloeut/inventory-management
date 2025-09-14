<template>
  <custom-title icon="mdi-cash-register">Sales</custom-title>

  <v-data-table :headers="headers" :items="salesStore.sales" />
</template>

<script setup>
import { useSalesStore } from '@/stores/salesStore'

const salesStore = useSalesStore()

const headers = [
  { title: 'Invoice No', key: 'invoice' },
  { title: 'Product', key: 'product' },
  { title: 'Qty Sold', key: 'quantity' },
  { title: 'Total', key: 'total' },
  { title: 'Date', key: 'date' },
]
</script>

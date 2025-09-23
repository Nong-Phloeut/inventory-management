<template>
  <custom-title icon="mdi-warehouse">
    Stocks
    <template #right>
      <BaseButton icon="mdi-plus" @click="openAddDialog">
        Add Stock
      </BaseButton>
    </template>
  </custom-title>

  <v-data-table :headers="headers" :items="stockStore.stocks">
    <template #item.product="{ item }">
      {{ item.product?.name }}
    </template>
    <template #item.actions="{ item }">
      <v-btn icon="mdi-pencil" size="small" color="primary" @click="openEditDialog(item)" />
      <v-btn icon="mdi-delete" size="small" color="error" @click="deleteStock(item)" />
    </template>
  </v-data-table>

  <StockDialog
    v-model:isOpen="isDialogOpen"
    :stock="selectedStock"
    :products="productStore.products"
    @save="saveStock"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useStockStore } from '@/stores/stockStore'
import { useProductStore } from '@/stores/productStore'
import StockDialog from '@/components/StockDialog.vue'

const stockStore = useStockStore()
const productStore = useProductStore()

const headers = [
  { title: 'Product', key: 'product' },
  { title: 'Quantity', key: 'quantity' },
  { title: 'Actions', key: 'actions', sortable: false }
]

const isDialogOpen = ref(false)
const selectedStock = ref(null)

onMounted(() => {
  stockStore.fetchStocks()
  productStore.fetchProducts()
})

const openAddDialog = () => {
  selectedStock.value = null
  isDialogOpen.value = true
}
const openEditDialog = s => {
  selectedStock.value = { ...s }
  isDialogOpen.value = true
}
const saveStock = s => {
  s.id ? stockStore.updateStock(s) : stockStore.addStock(s)
  stockStore.fetchStocks()
}
const deleteStock = s => {
  if (confirm(`Delete stock of "${s.product.name}"?`)) stockStore.deleteStock(s.id)
}
</script>

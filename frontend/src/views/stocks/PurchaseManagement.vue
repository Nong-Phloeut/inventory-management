<template>
  <custom-title icon="mdi-cart-arrow-down">
    <template #right>
      <BaseButton icon="mdi-plus" @click="isDialogOpen = true">
        New Purchase
      </BaseButton>
    </template>
    Purchases
  </custom-title>

  <v-data-table :headers="headers" :items="purchaseStore.purchases" />

  <PurchaseDialog v-model:isOpen="isDialogOpen" @save="savePurchase" />
</template>

<script setup>
  import { ref } from 'vue'
  import { usePurchaseStore } from '@/stores/purchaseStore'
  import PurchaseDialog from '@/components/PurchaseDialog.vue'

  const purchaseStore = usePurchaseStore()
  const isDialogOpen = ref(false)

  const headers = [
    { title: 'Invoice No', key: 'invoice' },
    { title: 'Supplier', key: 'supplier' },
    { title: 'Total', key: 'total' },
    { title: 'Date', key: 'date' }
  ]

  const savePurchase = p => purchaseStore.addPurchase(p)
</script>

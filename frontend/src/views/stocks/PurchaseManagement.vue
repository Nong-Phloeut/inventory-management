<template>
  <custom-title icon="mdi-cart-arrow-down">
    <template #right>
      <BaseButton icon="mdi-plus" @click="openDialog">
        New Purchase
      </BaseButton>
    </template>
    Purchases
  </custom-title>

  <v-data-table
    :headers="headers"
    :items="purchaseStore.purchases"
    item-key="id"
    @click:row="editPurchase"
  />

  <PurchaseDialog
    :model-value="isDialogOpen"
    @update:model-value="val => (isDialogOpen = val)"
    :purchase="selectedPurchase"
    @save="savePurchase"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePurchaseStore } from '@/stores/purchaseStore'
import PurchaseDialog from '@/components/PurchaseDialog.vue'

const purchaseStore = usePurchaseStore()
const isDialogOpen = ref(false)
const selectedPurchase = ref(null)

const headers = [
  { title: 'Invoice No', key: 'invoice' },
  { title: 'Supplier', key: 'supplier_name' },
  { title: 'Total', key: 'total_amount' },
  { title: 'Date', key: 'purchase_date' }
]

onMounted(() => {
  purchaseStore.fetchPurchases()
})

function openDialog() {
  selectedPurchase.value = { items: [] } // empty purchase for creation
  isDialogOpen.value = true
}

function editPurchase(purchase) {
  selectedPurchase.value = { ...purchase } // clone for editing
  isDialogOpen.value = true
}

function savePurchase(purchase) {
  if (purchase.id) {
    purchaseStore.updatePurchase(purchase.id, purchase)
  } else {
    purchaseStore.addPurchase(purchase)
  }
  isDialogOpen.value = false
  selectedPurchase.value = null
}
</script>

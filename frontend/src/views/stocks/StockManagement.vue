<template>
    <custom-title icon="mdi-swap-horizontal">Stock Management
    <template #right>
      <BaseButton icon="mdi-plus" @click="openDialog">
        Add Movement
      </BaseButton>
    </template>
  </custom-title>
  <div>

    <v-data-table
      :headers="headers"
      :items="stockMovements"
      item-key="id"
    >
      <template v-slot:item.actions="{ item }">
        <v-btn icon @click="openDialog(item)">
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn icon color="error" @click="deleteMovement(item.id)">
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <StockMovementDialog
      v-model="isDialogOpen"
      :movement="selectedMovement"
      @save="saveMovement"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useStockMovementStore } from '@/stores/stockMovement'
import StockMovementDialog from '@/components/StockMovementDialog.vue'

const store = useStockMovementStore()
const isDialogOpen = ref(false)
const selectedMovement = ref(null)

const headers = [
  { title: 'Product', key: 'productName' },
  { title: 'Type', key: 'type' },
  { title: 'Quantity', key: 'quantity' },
  { title: 'Date', key: 'date' },
  { title: 'Actions', key: 'actions', sortable: false }
]

const stockMovements = computed(() => store.stockMovements)

const openDialog = (movement = null) => {
  selectedMovement.value = movement ? { ...movement } : null
  isDialogOpen.value = true
}

const saveMovement = (movement) => {
  if (movement.id) {
    store.updateMovement(movement)
  } else {
    store.addMovement(movement)
  }
  isDialogOpen.value = false
}

const deleteMovement = (id) => {
  store.deleteMovement(id)
}
</script>

<template>
  <custom-title icon="mdi-truck-delivery">
    Supplier Management
    <template #right>
      <BaseButton icon="mdi-plus" @click="openAddDialog">
        Add Supplier
      </BaseButton>
    </template>
  </custom-title>

  <v-data-table
    :items="supplierStore.suppliers"
    :loading="supplierStore.loading"
    :headers="headers"
  >
    <template #item.actions="{ item }">
      <v-btn size="small" @click="openEditDialog(item)">Edit</v-btn>
      <v-btn size="small" color="error" @click="openDeleteDialog(item)">
        Delete
      </v-btn>
    </template>
  </v-data-table>

  <!-- Dialogs -->
  <SupplierDialog
    v-model="isDialogOpen"
    :supplier="selectedSupplier"
    @save="handleSave"
  />
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { useSupplierStore } from '@/stores/supplierStore'
  import SupplierDialog from '@/components/SupplierDialog.vue'

  const supplierStore = useSupplierStore()
  const isDialogOpen = ref(false)
  const isDeleteDialogOpen = ref(false)
  const selectedSupplier = ref(null)

  const headers = [
    { title: 'Name', key: 'name' },
    { title: 'Contact', key: 'contact' },
    { title: 'Phone', key: 'phone' },
    { title: 'Email', key: 'email' },
    { title: 'Actions', key: 'actions', sortable: false }
  ]

  onMounted(() => {
    supplierStore.fetchSuppliers()
  })

  const openAddDialog = () => {
    selectedSupplier.value = null
    isDialogOpen.value = true
  }

  const openEditDialog = supplier => {
    selectedSupplier.value = { ...supplier }
    isDialogOpen.value = true
  }

  const openDeleteDialog = supplier => {
    selectedSupplier.value = supplier
    isDeleteDialogOpen.value = true
  }

  const handleSave = async supplier => {
    if (supplier.id) {
      await supplierStore.updateSupplier(supplier)
    } else {
      await supplierStore.addSupplier(supplier)
    }
  }

  const handleDelete = async id => {
    await supplierStore.deleteSupplier(id)
  }
</script>

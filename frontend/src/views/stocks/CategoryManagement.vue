<template>
  <custom-title icon="mdi-shape-outline">
    Category Management
    <template #right>
      <BaseButton icon="mdi-plus" @click="openAddDialog">
        Add Category
      </BaseButton>
    </template>
  </custom-title>

  <v-data-table
    :items="categoryStore.categories"
    :loading="categoryStore.loading"
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
  <CategoryDialog
    v-model="isDialogOpen"
    :category="selectedCategory"
    @save="handleSave"
  />
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { useCategoryStore } from '@/stores/categoryStore'
  import CategoryDialog from '@/components/CategoryDialog.vue'

  const categoryStore = useCategoryStore()
  const isDialogOpen = ref(false)
  const isDeleteDialogOpen = ref(false)
  const selectedCategory = ref(null)

  const headers = [
    { title: 'Name', key: 'name' },
    { title: 'Description', key: 'description' },
    { title: 'Actions', key: 'actions', sortable: false }
  ]

  onMounted(() => {
    categoryStore.fetchCategories()
  })

  const openAddDialog = () => {
    selectedCategory.value = null
    isDialogOpen.value = true
  }

  const openEditDialog = category => {
    selectedCategory.value = { ...category }
    isDialogOpen.value = true
  }

  const openDeleteDialog = category => {
    selectedCategory.value = category
    isDeleteDialogOpen.value = true
  }

  const handleSave = async category => {
    if (category.id) {
      await categoryStore.updateCategory(category)
    } else {
      await categoryStore.addCategory(category)
    }
  }

  const handleDelete = async id => {
    await categoryStore.deleteCategory(id)
  }
</script>

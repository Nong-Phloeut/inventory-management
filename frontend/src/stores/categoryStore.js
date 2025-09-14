import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useCategoryStore = defineStore('category', () => {
  const categories = ref([])
  const loading = ref(false)

  // Fetch all categories
  const fetchCategories = async () => {
    loading.value = true
    try {
      // Replace this with API call
      categories.value = [
        { id: 1, name: 'Beverages', description: 'Soft drinks, water, etc.' },
        { id: 2, name: 'Snacks', description: 'Chips, biscuits, etc.' }
      ]
    } finally {
      loading.value = false
    }
  }

  // Create
  const addCategory = async (category) => {
    category.id = Date.now()
    categories.value.push(category)
  }

  // Update
  const updateCategory = async (category) => {
    const idx = categories.value.findIndex((c) => c.id === category.id)
    if (idx !== -1) categories.value[idx] = { ...category }
  }

  // Delete
  const deleteCategory = async (id) => {
    categories.value = categories.value.filter((c) => c.id !== id)
  }

  return {
    categories,
    loading,
    fetchCategories,
    addCategory,
    updateCategory,
    deleteCategory
  }
})

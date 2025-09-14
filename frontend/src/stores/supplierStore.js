import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSupplierStore = defineStore('supplier', () => {
  const suppliers = ref([])
  const loading = ref(false)

  // Fetch suppliers
  const fetchSuppliers = async () => {
    loading.value = true
    try {
      // Replace with API call
      suppliers.value = [
        { id: 1, name: 'ABC Trading', contact: 'John Doe', phone: '0123456789', email: 'abc@example.com' },
        { id: 2, name: 'XYZ Supply', contact: 'Jane Smith', phone: '0987654321', email: 'xyz@example.com' }
      ]
    } finally {
      loading.value = false
    }
  }

  // Create
  const addSupplier = async (supplier) => {
    supplier.id = Date.now()
    suppliers.value.push(supplier)
  }

  // Update
  const updateSupplier = async (supplier) => {
    const idx = suppliers.value.findIndex((s) => s.id === supplier.id)
    if (idx !== -1) suppliers.value[idx] = { ...supplier }
  }

  // Delete
  const deleteSupplier = async (id) => {
    suppliers.value = suppliers.value.filter((s) => s.id !== id)
  }

  return {
    suppliers,
    loading,
    fetchSuppliers,
    addSupplier,
    updateSupplier,
    deleteSupplier
  }
})

import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useProductStore = defineStore('product', () => {
  const products = ref([
    { id: 1, name: 'Laptop', sku: 'LTP-001', stock: 20, price: 1200 },
    { id: 2, name: 'Keyboard', sku: 'KBD-101', stock: 50, price: 40 },
  ])

  let nextId = 3

  const fetchProducts = async () => {
    // TODO: Replace with API call
    // const { data } = await axios.get('/api/products')
    // products.value = data
  }

  const addProduct = async (product) => {
    // TODO: Replace with API POST
    product.id = nextId++
    products.value.push(product)
  }

  const updateProduct = async (product) => {
    // TODO: Replace with API PUT
    const index = products.value.findIndex((p) => p.id === product.id)
    if (index !== -1) {
      products.value[index] = { ...product }
    }
  }

  const deleteProduct = async (id) => {
    // TODO: Replace with API DELETE
    products.value = products.value.filter((p) => p.id !== id)
  }

  return {
    products,
    fetchProducts,
    addProduct,
    updateProduct,
    deleteProduct,
  }
})

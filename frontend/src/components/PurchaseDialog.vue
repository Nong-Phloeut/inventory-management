<template>
  <v-dialog
    :model-value="modelValue"
    @update:model-value="val => emit('update:modelValue', val)"
    max-width="800"
  >
    <v-card>
      <v-card-title>
        {{ purchase.id ? 'Edit Purchase' : 'Add Purchase' }}
      </v-card-title>
      <v-card-text>
        <v-form ref="formRef" v-model="valid">
          <v-row>
            <v-col cols="6">
              <v-select
                label="Supplier"
                :items="suppliers"
                v-model="purchase.supplier_id"
                item-title="name"
                item-value="id"
                :rules="[v => !!v || 'Supplier is required']"
              />
            </v-col>
            <v-col cols="6">
              <v-date-input v-model="purchase.purchase_date" format="YYYY-MM-DD"/>
            </v-col>
          </v-row>

          <v-divider class="my-3" />

          <div
            v-for="(item, index) in purchase.items"
            :key="index"
            class="d-flex align-center mb-2"
          >
            <v-select
              :items="products"
              v-model="item.product_id"
              item-title="name"
              item-value="id"
              label="Product"
              class="me-2"
            />
            <v-text-field
              v-model.number="item.quantity"
              type="number"
              label="Quantity"
              class="me-2"
            />
            <v-text-field
              v-model.number="item.price"
              type="number"
              label="Price"
              class="me-2"
            />
            <v-btn icon color="red" @click="removeItem(index)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </div>

          <v-btn text @click="addItem">+ Add Product</v-btn>

          <v-row class="mt-3">
            <v-col class="text-end">
              <h3>Total: {{ totalAmount.toFixed(2) }}</h3>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="close">Cancel</v-btn>
        <v-btn color="primary" @click="save" :disabled="!valid">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { reactive, computed, watch, ref } from 'vue'
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  purchase: Object
})

const emit = defineEmits(['update:modelValue', 'save'])

const formRef = ref(null)
const valid = ref(false)

// Create a local reactive copy of purchase
const localPurchase = reactive({
  id: null,
  supplier_id: null,
  purchase_date: null,
  items: []
})

// Sync props.purchase into localPurchase whenever it changes
watch(
  () => props.purchase,
  (newVal) => {
    if (newVal) {
      // Use Object.assign to merge the new data into the existing reactive object
      Object.assign(localPurchase, newVal)
      // Ensure items is an array
      if (!localPurchase.items) localPurchase.items = []
    }
  },
  { immediate: true, deep: true }
)

// Computed properties with getter and setter to handle v-model
const purchaseSupplier = computed({
  get: () => localPurchase.supplier_id,
  set: (val) => {
    localPurchase.supplier_id = val
  }
})

const purchaseDate = computed({
  get: () => localPurchase.purchase_date,
  set: (val) => {
    localPurchase.purchase_date = val
  }
})

// Dummy data for example
const suppliers = [
  { id: 1, name: 'Supplier A' },
  { id: 2, name: 'Supplier B' }
]

const products = [
  { id: 3, name: 'Product X' },
  { id: 4, name: 'Product Y' }
]

function addItem() {
  localPurchase.items.push({ product_id: null, quantity: 1, price: 0 })
}

function removeItem(index) {
  localPurchase.items.splice(index, 1)
}

const totalAmount = computed(() =>
  localPurchase.items.reduce((sum, i) => sum + (i.quantity * i.price || 0), 0)
)
async function save() {
  const { valid: isValid } = await formRef.value.validate()
  if (!isValid) return

  // Ensure purchase_date is YYYY-MM-DD string
  let formattedDate = null
  if (localPurchase.purchase_date instanceof Date) {
    // Convert Date object
    formattedDate = localPurchase.purchase_date.toISOString().slice(0, 10)
  } else if (typeof localPurchase.purchase_date === 'string') {
    // If string, keep only YYYY-MM-DD
    formattedDate = localPurchase.purchase_date.split('T')[0]
  }

  // Emit the payload to parent
  emit('save', {
    ...localPurchase,
    purchase_date: formattedDate
  })

  close()
}


function close() {
  emit('update:modelValue', false)
}
</script>
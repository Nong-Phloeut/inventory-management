<template>
  <v-dialog
    :model-value="isOpen"
    @update:model-value="emit('update:isOpen', $event)"
    max-width="600"
  >
    <v-card>
      <v-card-title>
        <span class="text-h6">
          {{ product?.id ? 'Edit Product' : 'Add Product' }}
        </span>
      </v-card-title>

      <v-card-text>
        <v-form ref="formRef" v-model="isFormValid">
          <v-text-field
            v-model="form.name"
            label="Product Name"
            :rules="[v => !!v || 'Name is required']"
            required
          />
          <v-text-field
            v-model="form.sku"
            label="SKU"
            :rules="[v => !!v || 'SKU is required']"
            required
          />
          <v-text-field
            v-model="form.stock"
            type="number"
            label="Stock Quantity"
            :rules="[v => v >= 0 || 'Stock must be >= 0']"
            required
          />
          <v-text-field
            v-model="form.price"
            type="number"
            label="Price"
            prefix="$"
            :rules="[v => v > 0 || 'Price must be > 0']"
            required
          />
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="close">Cancel</v-btn>
        <v-btn
          color="primary"
          :disabled="!isFormValid"
          @click="handleSave"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, default: false },
  product: { type: Object, default: null },
})

const emit = defineEmits(['update:isOpen', 'save'])

const formRef = ref(null)
const isFormValid = ref(false)

const form = reactive({
  id: null,
  name: '',
  sku: '',
  stock: 0,
  price: 0,
})

const resetForm = () => {
  form.id = null
  form.name = ''
  form.sku = ''
  form.stock = 0
  form.price = 0
}

watch(
  () => props.product,
  (newVal) => {
    if (newVal) {
      Object.assign(form, newVal)
    } else {
      resetForm()
    }
  },
  { immediate: true }
)

const close = () => {
  emit('update:isOpen', false)
}

const handleSave = () => {
  if (!formRef.value?.validate()) return
  emit('save', { ...form })
}
</script>

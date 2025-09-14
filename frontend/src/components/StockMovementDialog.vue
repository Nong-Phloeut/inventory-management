<template>
  <v-dialog v-model="isOpen" max-width="500">
    <v-card>
      <v-card-title>
        {{ form.id ? 'Edit Movement' : 'New Movement' }}
      </v-card-title>
      <v-card-text>
        <v-form>
          <v-text-field v-model="form.productName" label="Product" />
          <v-select v-model="form.type" :items="['IN', 'OUT']" label="Type" />
          <v-text-field
            v-model="form.quantity"
            type="number"
            label="Quantity"
          />
          <v-text-field v-model="form.date" type="date" label="Date" />
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn text @click="close">Cancel</v-btn>
        <v-btn color="primary" @click="save">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
  import { ref, watch } from 'vue'

  const props = defineProps({
    modelValue: Boolean,
    movement: Object
  })
  const emit = defineEmits(['update:modelValue', 'save'])

  const isOpen = ref(props.modelValue)
  watch(
    () => props.modelValue,
    val => (isOpen.value = val)
  )
  watch(isOpen, val => emit('update:modelValue', val))

  const form = ref({
    id: null,
    productName: '',
    type: 'IN',
    quantity: 0,
    date: ''
  })
  const resetForm = () => {
    form.value = {
      id: null,
      productName: '',
      type: 'IN',
      quantity: 0,
      date: ''
    }
  }
  watch(
    () => props.movement,
    newVal => {
      if (newVal) {
        form.value = { ...newVal }
      } else {
        resetForm()
      }
    },
    { immediate: true }
  )

  const save = () => {
    emit('save', { ...form.value })
  }

  const close = () => {
    isOpen.value = false
  }
</script>

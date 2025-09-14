<template>
  <v-dialog v-model="internalOpen" max-width="600">
    <v-card>
      <v-card-title>
        {{ form.id ? 'Edit Supplier' : 'Add Supplier' }}
      </v-card-title>
      <v-card-text>
        <v-text-field v-model="form.name" label="Supplier Name" required />
        <v-text-field v-model="form.contact" label="Contact Person" />
        <v-text-field v-model="form.phone" label="Phone" />
        <v-text-field v-model="form.email" label="Email" type="email" />
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
    supplier: { type: Object, default: null }
  })
  const emit = defineEmits(['update:modelValue', 'save'])

  const internalOpen = ref(false)

  const form = ref({ id: null, name: '', contact: '', phone: '', email: '' })
  
  const resetForm = () => {
    form.value = { id: null, name: '', contact: '', phone: '', email: '' }
  }

  watch(
    () => props.modelValue,
    val => (internalOpen.value = val),
    { immediate: true }
  )

  watch(internalOpen, val => emit('update:modelValue', val))

  watch(
    () => props.supplier,
    newVal => {
      if (newVal) {
        form.value = { ...newVal }
      } else {
        resetForm()
      }
    },
    { immediate: true }
  )

  const close = () => (internalOpen.value = false)

  const save = () => {
    emit('save', { ...form.value })
    close()
  }
</script>

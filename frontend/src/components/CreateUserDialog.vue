<template>
  <v-dialog v-model="show" max-width="900">
    <v-card>
      <v-card-title class="bg-primary">Create Staff</v-card-title>
      <v-card-text>
        <v-form ref="formRef" v-model="valid" lazy-validation>
          <!-- Personal Info -->
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="First Name"
                v-model="firstName"
                :rules="[rules.required]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Last Name"
                v-model="lastName"
                :rules="[rules.required]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Email"
                v-model="email"
                :rules="[rules.required, rules.email]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Phone Number" v-model="phone" />
            </v-col>
            <v-col cols="12" md="6">
              <v-select
                label="Gender"
                v-model="gender"
                :items="['Male', 'Female', 'Other']"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-date-input v-model="dob" label="Date of Birth" />
            </v-col>
          </v-row>

          <!-- Job Info -->
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field label="Job Title" v-model="jobTitle" />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Department" v-model="department" />
            </v-col>
            <v-col cols="12" md="6">
              <v-select
                label="Role"
                v-model="role"
                :items="['Admin', 'Manager', 'Staff', 'Viewer']"
                :rules="[rules.required]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field label="Employee ID" v-model="employeeId" />
            </v-col>
            <v-col cols="12" md="6">
              <v-date-input v-model="joiningDate" label="Date of Joining" />
            </v-col>
          </v-row>

          <!-- Login Info -->
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                label="Username"
                v-model="username"
                :rules="[rules.required]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Password"
                v-model="password"
                type="password"
                :rules="[rules.required]"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-select
                label="Status"
                v-model="status"
                :items="['Active', 'Inactive', 'On Leave']"
              />
            </v-col>
          </v-row>

          <!-- Optional Info -->
          <v-row>
            <v-col cols="12">
              <v-textarea label="Address" v-model="address" />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Emergency Contact Name"
                v-model="emergencyName"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                label="Emergency Contact Phone"
                v-model="emergencyPhone"
              />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="close">Cancel</v-btn>
        <v-btn color="primary" :disabled="!valid" @click="submit">Create</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
  import { ref, watch } from 'vue'

  // Props & emits
  const props = defineProps({
    modelValue: Boolean
  })
  const emit = defineEmits(['update:modelValue', 'create'])

  // Dialog state
  const show = ref(props.modelValue)
  watch(
    () => props.modelValue,
    val => (show.value = val)
  )
  watch(show, val => emit('update:modelValue', val))

  // Form validation
  const valid = ref(false)
  const formRef = ref(null)
  const rules = {
    required: value => !!value || 'Required.',
    email: value =>
      !value ||
      /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(value) ||
      'Invalid email.'
  }

  // Staff fields
  const firstName = ref('')
  const lastName = ref('')
  const email = ref('')
  const phone = ref('')
  const gender = ref('')
  const dob = ref(null)
  const jobTitle = ref('')
  const department = ref('')
  const role = ref('')
  const employeeId = ref('')
  const joiningDate = ref(null)
  const username = ref('')
  const password = ref('')
  const status = ref('Active')
  const address = ref('')
  const emergencyName = ref('')
  const emergencyPhone = ref('')
  const notes = ref('')

  // Methods
  function close() {
    show.value = false
  }

  function submit() {
    if (formRef.value.validate()) {
      emit('create', {
        firstName: firstName.value,
        lastName: lastName.value,
        email: email.value,
        phone: phone.value,
        gender: gender.value,
        dob: dob.value,
        jobTitle: jobTitle.value,
        department: department.value,
        role: role.value,
        employeeId: employeeId.value,
        joiningDate: joiningDate.value,
        username: username.value,
        password: password.value,
        status: status.value,
        address: address.value,
        emergencyName: emergencyName.value,
        emergencyPhone: emergencyPhone.value,
        notes: notes.value
      })
      resetForm()
      close()
    }
  }

  function resetForm() {
    firstName.value = ''
    lastName.value = ''
    email.value = ''
    phone.value = ''
    gender.value = ''
    dob.value = null
    jobTitle.value = ''
    department.value = ''
    role.value = ''
    employeeId.value = ''
    joiningDate.value = null
    username.value = ''
    password.value = ''
    status.value = 'Active'
    address.value = ''
    emergencyName.value = ''
    emergencyPhone.value = ''
    notes.value = ''
    formRef.value.resetValidation()
  }
</script>

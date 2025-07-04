<template>
  <div class="w-100" style="max-width: 400px;">
    <!-- Título -->
    <h1 class="mb-4 fs-4 fw-semibold text-center">Crear nueva cuenta</h1>

    <!-- Formulario de registro -->
    <form @submit.prevent="onRegister" novalidate>
      <!-- Nombre completo -->
      <div class="mb-3">
        <label for="fullName" class="form-label d-block text-body-secondary">Nombre completo</label>
        <input
          v-model="myForm.fullName"
          ref="fullNameInputRef"
          type="text"
          id="fullName"
          class="form-control border rounded focus:shadow-none focus:outline-none"
          placeholder="Ingresa tu nombre"
          required
        />
      </div>

      <!-- Correo electrónico -->
      <div class="mb-3">
        <label for="email" class="form-label d-block text-body-secondary">Correo electrónico</label>
        <input
          v-model="myForm.email"
          ref="emailInputRef"
          type="email"
          id="email"
          class="form-control border rounded focus:shadow-none focus:outline-none"
          placeholder="usuario@ejemplo.com"
          required
        />
      </div>

      <!-- Contraseña -->
      <div class="mb-4">
        <label for="password" class="form-label d-block text-body-secondary">Contraseña</label>
        <input
          v-model="myForm.password"
          ref="passwordInputRef"
          type="password"
          id="password"
          class="form-control border rounded focus:shadow-none focus:outline-none"
          placeholder="Mínimo 6 caracteres"
          required
          minlength="6"
        />
      </div>

      <!-- Botón de enviar -->
      <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
        Crear cuenta
      </button>
    </form>

    <!-- Enlace a login -->
    <div class="mt-4 text-center text-primary">
      <RouterLink :to="{ name: 'login' }" class="text-decoration-none">
        ¿Ya tienes cuenta? Inicia sesión
      </RouterLink>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useAuthStore } from '../stores/auth.store'
import { useToast } from 'vue-toastification'

const authStore = useAuthStore()
const toast = useToast()

const fullNameInputRef = ref<HTMLInputElement | null>(null)
const emailInputRef = ref<HTMLInputElement | null>(null)
const passwordInputRef = ref<HTMLInputElement | null>(null)

const myForm = reactive({
  fullName: '',
  email: '',
  password: ''
})

const onRegister = async () => {
  // Validaciones básicas
  if (myForm.fullName.trim().length < 2) {
    fullNameInputRef.value?.focus()
    return
  }
  if (!myForm.email.includes('@')) {
    emailInputRef.value?.focus()
    return
  }
  if (myForm.password.length < 6) {
    passwordInputRef.value?.focus()
    return
  }

  // Llamada al store
  const { ok, message } = await authStore.register(
    myForm.fullName,
    myForm.email,
    myForm.password
  )

  if (!ok) {
    toast.error(message)
  }
}
</script>

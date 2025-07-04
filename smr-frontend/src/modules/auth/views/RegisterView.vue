<template>
  <BarraAccesibilidad />
  <div class="d-flex justify-content-center align-items-center min-vh-80 px-3">
    <div class="w-100" style="max-width: 400px">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="mb-4 fs-4 fw-semibold text-center">Crear nueva cuenta</h1>
          <form @submit.prevent="onRegister" novalidate>
            <!-- Nombre completo -->
            <div class="mb-3">
              <label for="fullName" class="form-label text-secondary">Nombre completo</label>
              <input
                v-model="myForm.fullName"
                ref="fullNameInputRef"
                type="text"
                id="fullName"
                class="form-control border rounded-2"
                placeholder="Ingresa tu nombre"
                required
              />
            </div>
            <!-- Correo electrónico -->
            <div class="mb-3">
              <label for="email" class="form-label text-secondary">Correo electrónico</label>
              <input
                v-model="myForm.email"
                ref="emailInputRef"
                type="email"
                id="email"
                class="form-control border rounded-2"
                placeholder="usuario@ejemplo.com"
                required
              />
            </div>
            <!-- Contraseña -->
            <div class="mb-4">
              <label for="password" class="form-label text-secondary">Contraseña</label>
              <input
                v-model="myForm.password"
                ref="passwordInputRef"
                type="password"
                id="password"
                class="form-control border rounded-2"
                placeholder="Mínimo 6 caracteres"
                required
                minlength="6"
              />
            </div>
            <!-- Botón de enviar -->
            <button type="submit" class="btn btn-primary w-100 py-2 fs-6 fw-semibold rounded-2">
              Crear cuenta
            </button>
          </form>
          <!-- Enlace a login -->
          <div class="mt-4 text-center">
            <RouterLink :to="{ name: 'login' }" class="text-decoration-none text-primary">
              ¿Ya tienes cuenta? Inicia sesión
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useAuthStore } from '../stores/auth.store';
import { useToast } from 'vue-toastification';
import BarraAccesibilidad from '@/modules/publico/layouts/components/BarraAccesibilidad.vue';

const authStore = useAuthStore();
const toast = useToast();

const fullNameInputRef = ref<HTMLInputElement | null>(null);
const emailInputRef = ref<HTMLInputElement | null>(null);
const passwordInputRef = ref<HTMLInputElement | null>(null);

const myForm = reactive({
  fullName: '',
  email: '',
  password: '',
});

const onRegister = async () => {
  // Validaciones básicas
  if (myForm.fullName.trim().length < 2) {
    fullNameInputRef.value?.focus();
    return;
  }
  if (!myForm.email.includes('@')) {
    emailInputRef.value?.focus();
    return;
  }
  if (myForm.password.length < 6) {
    passwordInputRef.value?.focus();
    return;
  }

  // Llamada al store
  const { ok, message } = await authStore.register(myForm.fullName, myForm.email, myForm.password);

  if (!ok) {
    toast.error(message);
  }
};
</script>

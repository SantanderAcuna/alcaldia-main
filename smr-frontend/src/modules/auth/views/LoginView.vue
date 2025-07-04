<template>
  <div class="d-flex justify-content-center align-items-center min-vh-80 px-3">
    <div class="w-100" style="max-width: 400px">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          <h1 class="mb-4 fs-4 fw-semibold text-center">Login</h1>
          <BarraAccesibilidad />
          <form @submit.prevent="onLogin">
            <!-- Correo -->
            <div class="mb-3">
              <label for="email" class="form-label text-secondary">Correo</label>
              <input
                v-model="myForm.email"
                ref="emailInputRef"
                type="text"
                id="email"
                name="email"
                class="form-control border rounded-2"
                autocomplete="off"
              />
            </div>
            <!-- Contraseña -->
            <div class="mb-3">
              <label for="password" class="form-label text-secondary">Contraseña</label>
              <input
                v-model="myForm.password"
                ref="passwordInputRef"
                type="password"
                id="password"
                name="password"
                class="form-control border rounded-2"
                autocomplete="off"
              />
            </div>
            <!-- Recordar usuario -->
            <div class="form-check mb-3">
              <input
                v-model="myForm.rememberMe"
                type="checkbox"
                id="remember"
                name="remember"
                class="form-check-input"
                ref="rememberRef"
              />
              <label for="remember" class="form-check-label text-secondary">
                Recordar usuario
              </label>
            </div>
            <!-- Olvidaste contraseña -->
            <div class="mb-4 text-end">
              <a href="#" class="text-decoration-none text-primary">¿Olvidaste la contraseña?</a>
            </div>
            <!-- Botón de ingreso -->
            <button type="submit" class="btn btn-primary w-100 py-2 fs-6 fw-semibold rounded-2">
              Ingresar
            </button>
          </form>
          <!-- Enlace a registro -->
          <div class="mt-4 text-center">
            <RouterLink :to="{ name: 'register' }" class="text-decoration-none text-primary">
              Crear cuenta aquí
            </RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref, watchEffect } from 'vue';
import { useAuthStore } from '../stores/auth.store';
import { useToast } from 'vue-toastification';
import BarraAccesibilidad from '@/modules/publico/layouts/components/BarraAccesibilidad.vue';

const authStore = useAuthStore();
const toast = useToast();

const emailInputRef = ref<HTMLInputElement | null>(null);
const passwordInputRef = ref<HTMLInputElement | null>(null);

const myForm = reactive({
  email: '',
  password: '',
  rememberMe: false,
});

const onLogin = async () => {
  if (myForm.email === '') {
    return emailInputRef.value?.focus();
  }

  if (myForm.password.length < 6) {
    return passwordInputRef.value?.focus();
  }

  if (myForm.rememberMe) {
    localStorage.setItem('email', myForm.email);
  } else {
    localStorage.removeItem('email');
  }

  const ok = await authStore.login(myForm.email, myForm.password);

  if (ok) return;

  toast.error('Usuario/Contraseña no son correctos');
};

watchEffect(() => {
  const email = localStorage.getItem('email');
  if (email) {
    myForm.email = email;
    myForm.rememberMe = true;
  }
});
</script>

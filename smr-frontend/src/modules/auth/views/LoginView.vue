<template>
  <h1 class="mb-4 fs-4 fw-semibold">Login</h1>
  <form @submit.prevent="onLogin">
    <!-- Email Input -->
    <div class="mb-3">
      <label for="email" class="form-label d-block text-body-secondary">Correo</label>
      <input
        v-model="myForm.email"
        ref="emailInputRef"
        type="text"
        id="email"
        name="email"
        class="form-control"
        autocomplete="off"
      />
    </div>
    <!-- Password Input -->
    <div class="mb-3">
      <label for="password" class="form-label d-block text-body-secondary">Contraseña</label>
      <input
        v-model="myForm.password"
        ref="passwordInputRef"
        type="password"
        id="password"
        name="password"
        class="form-control"
        autocomplete="off"
      />
    </div>
    <!-- Remember Me Checkbox -->
    <div class="form-check mb-3">
      <input
        v-model="myForm.rememberMe"
        type="checkbox"
        id="remember"
        name="remember"
        class="form-check-input"
      />
      <label for="remember" class="form-check-label text-body-secondary">Recordar usuario</label>
    </div>
    <!-- Forgot Password Link -->
    <div class="mb-4 text-primary">
      <a href="#" class="text-decoration-none">¿Olvidaste la contraseña?</a>
    </div>
    <!-- Login Button -->
    <button
      type="submit"
      class="btn btn-primary w-100 fw-semibold py-2"
    >
      Ingresar
    </button>
  </form>
  <!-- Sign up Link -->
  <div class="mt-4 text-center text-primary">
    <RouterLink :to="{ name: 'register' }" class="text-decoration-none">Crear cuenta aquí</RouterLink>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref, watchEffect } from 'vue';
import { useAuthStore } from '../stores/auth.store';
import { useToast } from 'vue-toastification';

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

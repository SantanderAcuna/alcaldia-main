<template>
  <div class="container-fluid vh-100 p-0">
    <div class="row g-0 h-100">
      <!-- Imagen siempre visible, ocupa col-12 en xs y col-6 en lg -->
      <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
        <img :src="logo500Or" alt="500 Años" class="img-fluid w-70 mx-auto" loading="lazy" />
      </div>

      <!-- Formulario -->
      <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center">
        <div class="w-100 px-4 px-md-5">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const logo500Or = new URL('@/assets/img/logos/logo500Or.png', import.meta.url).href;
</script>

<style scoped>
/* Garantiza que el contenedor ocupe al menos la altura de la ventana */
.vh-100 {
  min-height: 100vh;
}

/* object-fit no está disponible como clase en Bootstrap 5. Adaptamos con inline-style */
</style>

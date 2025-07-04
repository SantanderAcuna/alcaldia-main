<template>
  <!-- Contenedor fluido para cubrir toda la pantalla sin padding -->
  <div class="container-fluid vh-100 p-0">
    <!-- Fila de Bootstrap sin gutters y altura completa -->
    <div class="row g-0 h-100">
      <!-- Columna izquierda: imagen solo visible en pantallas lg en adelante -->
      <div class="col-lg-6 d-none d-lg-block">
        <img
          src="https://placehold.co/800x/667fff/ffffff.png?text=Your+Image&font=Montserrat"
          alt="Login illustration"
          class="img-fluid w-100 h-100"
          style="object-fit: cover;"
        />
      </div>

      <!-- Columna derecha: formulario centrado -->
      <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
        <!-- Wrapper interno con padding responsivo -->
        <div class="w-100 px-4 px-md-5">
          <!-- Renderizado del componente de login vía Vue Router -->
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Este layout no requiere props ni lógica adicional.
// Usa <script setup> para soporte óptimo de Composition API.
</script>

<style scoped>
/* Garantiza que el contenedor ocupe al menos la altura de la ventana */
.vh-100 {
  min-height: 100vh;
}

/* object-fit no está disponible como clase en Bootstrap 5. Adaptamos con inline-style */
</style>

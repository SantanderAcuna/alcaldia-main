<template>
  <!-- Inicio de la barra de navegación -->
  <div>
    <div>
      <!-- Barra de Accesibilidad -->
      <BarraAccesibilidad />

      <!-- Header con Navegación Superior -->
      <header>
        <!-- Navegación Superior -->
        <NavegacionSuperior />

        <NavbarPanel />
      </header>
    </div>
    <!-- Fin de la barra de navegación -->

    <!-- Contenido principal -->
<main class="mb-xl-5">
  <Carrusel  v-if="route.path === '/'"/>
  <router-view />

  <TramiteServicios v-if="route.path === '/'" />
  <Noticias v-if="route.path === '/'" />
  <Documentos v-if="route.path === '/'" />
</main>

    <!-- Footer -->
    <FooterPanel />
  </div>
</template>
<script setup>
import { onMounted } from "vue";


import { useRouter, useRoute } from "vue-router";

const route = useRoute();

// ✅ Importación de componentes usados en el template
import BarraAccesibilidad from "@/components/layout/BarraAccesibilidad.vue";
import NavegacionSuperior from "@/components/layout/NavegacionSuperior.vue";
import NavbarPanel from "@/components/layout/NavbarPanel.vue";
import FooterPanel from "@/components/layout/FooterPanel.vue";
import Carrusel from "@/components/layout/Carrusel.vue";
import TramiteServicios from "@/components/tramites/TramiteServicios.vue";
import Noticias from "@/components/noticias/Noticias.vue";
import Documentos from "@/components/archivos/Documentos.vue";

function cerrarTodosLosDropdowns() {
  const toggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');
  toggles.forEach((toggle) => {
    const instance = window.bootstrap?.Dropdown.getInstance(toggle);
    if (instance) instance.hide();
  });
}

const router = useRouter();

onMounted(() => {
  router.afterEach(() => {
    cerrarTodosLosDropdowns();
  });
});
</script>

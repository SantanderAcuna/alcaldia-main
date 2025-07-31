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

        <!-- <NavbarPanel /> -->
        <Nabvar-Panel />
      </header>
    </div>
    <!-- Fin de la barra de navegación -->

    <!-- Contenido principal -->
    <main class="mb-lg-5">
      <BreadCrumb :items="breadcrumbItems" />
      <router-view />
      <VueQueryDevtools />
    </main>

    <!-- Footer -->
    <FooterPanel />
  </div>
</template>
<script lang="ts" setup>
import { onMounted, computed } from 'vue';

import { useRoute, useRouter } from 'vue-router';

import { VueQueryDevtools } from '@tanstack/vue-query-devtools';

const router = useRouter();

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const isHomePage = computed(() => router.currentRoute.value.path === '/');

// ✅ Importación de componentes usados en el template
import BarraAccesibilidad from '@/modules/publico/layouts/components/BarraAccesibilidad.vue';
import NavegacionSuperior from '@/modules/publico/layouts/components/NabvarSuperior.vue';
import NabvarPanel from '@/modules/publico/layouts/components/NabvarPanel.vue';
import FooterPanel from '@/modules/publico/layouts/components/FooterPanel.vue';
import BreadCrumb from '@/modules/publico/layouts/components/BreadCrumb.vue';

function cerrarTodosLosDropdowns() {
  const toggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');
  toggles.forEach((toggle) => {
    const instance = window.bootstrap?.Dropdown.getInstance(toggle);
    if (instance) instance.hide();
  });
}

onMounted(() => {
  router.afterEach(() => {
    cerrarTodosLosDropdowns();
  });
});

const route = useRoute();

const breadcrumbItems = [
  { label: 'Dashboard', to: '/dashboard' },
  // El breadcrumb añadirá automáticamente las rutas siguientes
];
</script>

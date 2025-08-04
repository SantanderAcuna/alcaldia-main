<template>
  <div class="container-fluid position-relative">
    <div class="row">
      <!-- Sidebar con submenús colapsables -->
      <NabarSuperior />
      <BarraAccesibilidad />
      <NavbarSuperior />
      <NavBarAdminPanel />
      <BreadCrumb :items="breadcrumbItems" />

      <!-- Contenido principal con margen dinámico -->
      <main class="position-relative h-100 border-radius-lg">
        <!-- <NabarSuperior @toggle-sidebar="toggleSidebar" /> -->
        <!-- Contenido de la página -->
        <router-view />
        <VueQueryDevtools />

        <div class="container-fluid">
          <!-- Breadcrumb para móvil -->
        </div>
      </main>
      <FooterPanel />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
// import * as bootstrap from 'bootstrap';
// En los archivos .vue
import * as bootstrap from 'bootstrap';

import NavbarSuperior from '@/modules/publico/layouts/components/NabvarSuperior.vue';

import { VueQueryDevtools } from '@tanstack/vue-query-devtools';
import BarraAccesibilidad from '@/modules/publico/layouts/components/BarraAccesibilidad.vue';

import NavBarAdminPanel from './components/NavBarAdminPanel.vue';
import FooterPanel from '@/modules/publico/layouts/components/FooterPanel.vue';
import BreadCrumb from './components/BreadCrumb.vue';

// Estados para controlar la UI
const sidebarVisible = ref(false);
const isSidebarCollapsed = ref(false);

// Estilo dinámico para el contenido principal
const mainContentStyle = computed(() => {
  // En dispositivos móviles, el contenido siempre ocupa el 100%
  if (window.innerWidth < 992) {
    return {
      marginLeft: '0',
      width: '100%',
      transition: 'all 0.3s ease',
    };
  }

  // En escritorio, ajustamos según el estado del sidebar
  return {
    marginLeft: isSidebarCollapsed.value ? '70px' : '280px',
    width: isSidebarCollapsed.value ? 'calc(100% - 70px)' : 'calc(100% - 280px)',
    transition: 'all 0.3s ease',
  };
});

const route = useRoute();

const breadcrumbItems = [
  { label: 'Dashboard', to: '/dashboard' },
  // El breadcrumb añadirá automáticamente las rutas siguientes
];

// Alternar visibilidad del sidebar en móviles
const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value;
};

// Alternar estado colapsado del sidebar en desktop
const toggleSidebarCollapse = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

// Inicializar tooltips de Bootstrap al montar el componente
onMounted(() => {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltipTriggerList.forEach((tooltipTriggerEl) => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Ajustar sidebar al cargar según el tamaño de pantalla
  if (window.innerWidth >= 992) {
    sidebarVisible.value = true;
  }
});
</script>

<style scoped>
/* Variables CSS para mantener consistencia */
:root {
  --bs-primary: #2563eb;
  --bs-secondary: #6b7280;
  --bs-success: #10b981;
  --bs-info: #06b6d4;
  --bs-warning: #f59e0b;
  --bs-danger: #ef4444;
  --bs-light: #f9fafb;
  --bs-dark: #1f2937;
  --bs-card-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
  --bs-border-radius: 0.75rem;
  --bs-transition: all 0.3s ease;
}

/* Contenido principal */
.main-content {
  margin-left: 280px;
  width: calc(100% - 280px);
  transition: var(--bs-transition);
}

/* Ajustes cuando el sidebar está colapsado */
.sidenav.collapsed ~ .main-content {
  margin-left: 70px;
  width: calc(100% - 70px);
}

/* Tarjetas de dashboard */
.dashboard-card {
  border-radius: var(--bs-border-radius);
  box-shadow: var(--bs-card-shadow);
  border: none;
  transition: var(--bs-transition);
  overflow: hidden;
  height: 100%;
}

/* Efecto hover en tarjetas */
.dashboard-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.08);
}

/* Header de tarjetas */
.card-header {
  padding: 1rem 1.5rem;
  background-color: white;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

/* Iconos en tarjetas */
.card-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Timeline para actividades */
.timeline {
  position: relative;
}

.timeline::before {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  left: 18px;
  width: 2px;
  background-color: #e9ecef;
  z-index: 0;
}

.timeline-block {
  position: relative;
  padding-left: 2.5rem;
}

.timeline-step {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  left: 0;
  z-index: 1;
  font-size: 0.875rem;
}

.timeline-content {
  padding-bottom: 1.5rem;
  position: relative;
}

/* Footer */
.footer {
  background-color: white;
  border-top: 1px solid rgba(0, 0, 0, 0.05);
}

/* Responsividad */
@media (max-width: 991.98px) {
  .main-content {
    margin-left: 0 !important;
    width: 100% !important;
  }
}

@media (max-width: 767.98px) {
  .navbar-nav .nav-item .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }

  .table-responsive {
    border: 0;
  }

  .table th,
  .table td {
    padding: 0.75rem;
  }
}

/* Accesibilidad */
:focus-visible {
  outline: 2px solid var(--bs-primary);
  outline-offset: 2px;
}

/* Animaciones */
.btn,
.nav-link,
.dashboard-card {
  transition: var(--bs-transition);
}

/* Colores para utilidades */
.bg-primary-subtle {
  background-color: rgba(37, 99, 235, 0.1) !important;
}

.bg-success-subtle {
  background-color: rgba(16, 185, 129, 0.1) !important;
}

.bg-info-subtle {
  background-color: rgba(6, 182, 212, 0.1) !important;
}

.bg-warning-subtle {
  background-color: rgba(245, 158, 11, 0.1) !important;
}

.bg-danger-subtle {
  background-color: rgba(239, 68, 68, 0.1) !important;
}

.bg-secondary-subtle {
  background-color: rgba(107, 114, 128, 0.1) !important;
}

/* Mejoras de accesibilidad (áreas táctiles) */
.nav-link,
.btn,
.dropdown-toggle {
  min-height: 44px;
  min-width: 44px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
</style>

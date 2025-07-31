<template>
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb mb-0">
      <!-- Item de Home siempre visible -->
      <li class="breadcrumb-item">
        <router-link to="/admin" class="text-decoration-none">
          <i class="bi bi-house-door me-1"></i> Dashboard
        </router-link>
      </li>

      <!-- Ruta anterior (si existe) -->
      <li v-if="previousRoute" class="breadcrumb-item">
        <router-link :to="previousRoute.path" class="text-decoration-none">
          {{ previousRoute.label }}
        </router-link>
      </li>

      <!-- Ruta actual -->
      <li class="breadcrumb-item active text-capitalize" aria-current="page">
        <span>{{ currentRouteLabel }}</span>
      </li>
    </ol>
  </nav>
</template>

<script lang="ts" setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter, type RouteLocationMatched } from 'vue-router';

interface BreadcrumbItem {
  label: string;
  path: string;
}

// Definir una interfaz extendida para las rutas con meta campos personalizados
interface CustomRouteMeta {
  breadcrumb?: string;
  isLayout?: boolean;
  title?: string;
}

const route = useRoute();
const router = useRouter();

// Referencia reactiva para almacenar la ruta anterior
const previousRoute = ref<BreadcrumbItem | null>(null);

// Clave para almacenar en localStorage
const BREADCRUMB_HISTORY_KEY = 'breadcrumbHistory';

/**
 * Obtiene el label legible de una ruta
 */
function getRouteLabel(routeMatched: RouteLocationMatched): string {
  const meta = routeMatched.meta as CustomRouteMeta;

  // 1. Intentar obtener breadcrumb de meta
  if (meta?.breadcrumb && typeof meta.breadcrumb === 'string') {
    return meta.breadcrumb;
  }

  // 2. Usar el nombre de la ruta si está disponible
  if (routeMatched.name && typeof routeMatched.name === 'string') {
    return formatLabel(routeMatched.name);
  }

  // 3. Extraer del path como último recurso
  const pathParts = routeMatched.path.split('/').filter((part) => part);
  if (pathParts.length > 0) {
    const lastPart = pathParts[pathParts.length - 1];
    return formatLabel(lastPart.replace(/-/g, ' '));
  }

  return 'Unknown';
}

/**
 * Determina si una ruta es válida para el breadcrumb
 */
function isValidBreadcrumbRoute(routeMatched: RouteLocationMatched): boolean {
  if (!routeMatched.name || routeMatched.path === '/') return false;

  const meta = routeMatched.meta as CustomRouteMeta;
  // Filtrar rutas de layout (por nombre o meta)
  const isLayout = meta?.isLayout || (routeMatched.name as string).toLowerCase().includes('layout');

  return !isLayout;
}

/**
 * Formatea el label para ser más legible
 */
function formatLabel(str: string): string {
  return str.replace(/-/g, ' ').replace(/(?:^|\s)\S/g, (match) => match.toUpperCase());
}

/**
 * Obtiene el label de la ruta actual
 */
const currentRouteLabel = computed(() => {
  // Buscar la última ruta válida en la jerarquía
  for (let i = route.matched.length - 1; i >= 0; i--) {
    const candidate = route.matched[i];
    if (isValidBreadcrumbRoute(candidate)) {
      return getRouteLabel(candidate);
    }
  }

  // Si no se encuentra ninguna ruta válida, usar alternativa
  return route.meta?.title || route.name?.toString() || 'Current Page';
});

/**
 * Actualiza el historial de navegación
 */
function updateNavigationHistory() {
  // Obtener historial actual
  const history: BreadcrumbItem[] = JSON.parse(
    localStorage.getItem(BREADCRUMB_HISTORY_KEY) || '[]',
  );

  // Crear item para la ruta actual
  const currentItem = {
    label: currentRouteLabel.value,
    path: route.path,
  };

  // Solo agregar si es diferente a la última entrada
  if (history.length === 0 || history[history.length - 1].path !== currentItem.path) {
    history.push(currentItem);

    // Mantener solo los últimos 5 items
    if (history.length > 5) history.shift();

    localStorage.setItem(BREADCRUMB_HISTORY_KEY, JSON.stringify(history));
  }

  // Establecer la ruta anterior (si existe)
  if (history.length > 1) {
    previousRoute.value = history[history.length - 2];
  } else {
    previousRoute.value = null;
  }
}

// Observar cambios de ruta
watch(
  () => route.path,
  (newPath, oldPath) => {
    if (newPath !== oldPath) {
      updateNavigationHistory();
    }
  },
);

// Inicializar al montar el componente
onMounted(() => {
  updateNavigationHistory();

  // Limpiar historial al recargar la página
  window.addEventListener('beforeunload', () => {
    localStorage.removeItem(BREADCRUMB_HISTORY_KEY);
  });
});

// Historial de rutas para breadcrumb
interface BreadcrumbItem {
  label: string;
  path: string;
}

interface CustomRouteMeta {
  breadcrumb?: string;
  isLayout?: boolean;
  title?: string;
}

watch(
  () => route.path,
  (newPath, oldPath) => {
    if (newPath !== oldPath) {
      updateNavigationHistory();
    }
  },
);
</script>

<style scoped>
.breadcrumb {
  padding: 0.75rem 1rem;
  background-color: #f8f9fa;
  border-radius: 0.375rem;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
}

.breadcrumb-item {
  font-size: 0.9rem;
  display: flex;
  align-items: center;
}

.breadcrumb-item + .breadcrumb-item::before {
  content: '>';
  color: #6c757d;
  padding: 0 0.5rem;
}

.breadcrumb-item a {
  color: #6c757d;
  transition: color 0.15s ease-in-out;
  display: flex;
  align-items: center;
}

.breadcrumb-item a:hover {
  color: #0d6efd;
  text-decoration: none;
}

.breadcrumb-item.active {
  color: #0d6efd;
  font-weight: 500;
}

.breadcrumb-item.active span {
  color: inherit;
}

.breadcrumb {
  padding: 0.5rem 1rem;
  background-color: transparent;
  border-radius: 0.375rem;
}

.breadcrumb-item {
  font-size: 0.875rem;
  display: flex;
  align-items: center;
}

.breadcrumb-item + .breadcrumb-item::before {
  content: '>';
  color: #6c757d;
  padding: 0 0.5rem;
  font-weight: 600;
}

.breadcrumb-item a {
  color: #6c757d;
  transition: color 0.15s ease-in-out;
  display: flex;
  align-items: center;
  font-weight: 500;
}

.breadcrumb-item a:hover {
  color: #0d6efd;
  text-decoration: none;
}

.breadcrumb-item.active {
  color: #495057;
  font-weight: 600;
}

.breadcrumb-item.active span {
  color: inherit;
}

/* Versión móvil del breadcrumb */
.d-md-none .breadcrumb {
  background-color: #f8f9fa;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
}
</style>

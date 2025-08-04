<template>
  <!-- Breadcrumb accesible y responsivo con Bootstrap 5 -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb mb-0">
      <!-- Ítem fijo de inicio -->
      <li class="breadcrumb-item">
        <router-link to="/admin" class="text-decoration-none" aria-label="Ir a inicio">
          <i class="bi bi-house-door me-1"></i> Inicio
        </router-link>
      </li>

      <!-- Iterate sobre el historial mostrado -->
      <li
        v-for="(item, index) in displayedHistory"
        :key="`${item.path}-${item.timestamp}`"
        :class="['breadcrumb-item', { active: index === displayedHistory.length - 1 }]"
        :aria-current="index === displayedHistory.length - 1 ? 'page' : undefined"
      >
        <template v-if="index !== displayedHistory.length - 1">
          <router-link :to="item.path" class="text-decoration-none">
            {{ truncateLabel(item.label) }}
          </router-link>
        </template>
        <template v-else>
          <span>{{ truncateLabel(item.label) }}</span>
        </template>
      </li>
    </ol>
  </nav>
</template>

<script lang="ts" setup>
/**
 * Breadcrumb dinámico que guarda y muestra todo el historial
 * de rutas visitadas, evitando duplicados manteniendo la ruta más reciente.
 * Además incorpora diseño responsive, acceso total en escritorio
 * y resumen en dispositivos móviles, siguiendo las mejores prácticas UI/UX
 * y estándares de accesibilidad.
 */

import { ref, computed, onMounted, watch, nextTick } from 'vue';
import { useRoute, type RouteLocationMatched } from 'vue-router';

// Interfaces para claridad y tipado
interface BreadcrumbItem {
  label: string;
  path: string;
  timestamp: number; // Para diferenciar navegaciones a la misma ruta en diferentes tiempos
}

interface CustomRouteMeta {
  breadcrumb?: string | (() => string);
  isLayout?: boolean;
  title?: string;
}

const route = useRoute();
const BREADCRUMB_HISTORY_KEY = 'breadcrumbHistory';
const breadcrumbHistory = ref<BreadcrumbItem[]>([]);
const windowWidth = ref(window.innerWidth);

/**
 * Obtiene el historial guardado en localStorage de forma segura
 */
const getStoredHistory = (): BreadcrumbItem[] => {
  try {
    const stored = localStorage.getItem(BREADCRUMB_HISTORY_KEY);
    return stored ? JSON.parse(stored) : [];
  } catch (error) {
    // Registro de error para debugging sin romper la app
    console.error('Error parsing breadcrumb history:', error);
    return [];
  }
};

/**
 * Guarda el historial actualizado en localStorage de forma segura
 */
const saveHistory = (history: BreadcrumbItem[]) => {
  try {
    localStorage.setItem(BREADCRUMB_HISTORY_KEY, JSON.stringify(history));
  } catch (error) {
    console.error('Error saving breadcrumb history:', error);
  }
};

/**
 * Formatea de modo amigable etiquetas para mostrar en breadcrumb
 * Capitaliza palabras y elimina sufijos innecesarios
 */
const formatLabel = (str: string): string => {
  return str
    .replace(/-/g, ' ')
    .replace(/\b\w/g, (c) => c.toUpperCase()) // Capitaliza cada palabra
    .replace(/Url$/i, '') // Elimina terminación común
    .trim();
};

/**
 * Obtiene el label legible y consistente desde una ruta
 */
const getRouteLabel = (routeMatched: RouteLocationMatched): string => {
  const meta = routeMatched.meta as CustomRouteMeta;

  // 1. Prioriza label definido en meta.breadcrumb, puede ser string o función
  if (meta?.breadcrumb) {
    return typeof meta.breadcrumb === 'function' ? meta.breadcrumb() : meta.breadcrumb;
  }

  // 2. Si no hay breadcrumb, usa el nombre de la ruta
  if (routeMatched.name) {
    const name =
      typeof routeMatched.name === 'string' ? routeMatched.name : routeMatched.name.toString();
    return formatLabel(name);
  }

  // 3. Como último recurso, usa el último segmento del path
  const pathParts = routeMatched.path.split('/').filter(Boolean);
  if (pathParts.length > 0) {
    return formatLabel(pathParts[pathParts.length - 1]);
  }

  // Fallback para rutas sin info
  return 'Unknown';
};

/**
 * Valida si una ruta es válida para aparecer en el breadcrumb
 * Excluye rutas raíz, sin nombre, o rutas de layout
 */
const isValidBreadcrumbRoute = (routeMatched: RouteLocationMatched): boolean => {
  if (!routeMatched.name || routeMatched.path === '/') return false;

  const meta = routeMatched.meta as CustomRouteMeta;

  if (meta?.isLayout) return false;

  if (typeof routeMatched.name === 'string' && /layout/i.test(routeMatched.name)) return false;

  return true;
};

/**
 * Actualiza el historial del breadcrumb cada vez que cambia la ruta
 *
 * Esta función:
 * - Obtiene el historial actual del localStorage
 * - Busca la ruta válida más profunda del matched
 * - Obtiene label legible
 * - Añade nueva entrada solo si no es igual a la última para evitar duplicados consecutivos
 * - Elimina entradas antiguas duplicadas dejando la más reciente
 * - Limita la longitud máxima para evitar excesos
 * - Guarda el historial actualizado y actualiza el reactive breadcrumbHistory
 */
const updateNavigationHistory = () => {
  // Obtiene historial guardado, puede estar vacío
  const history = getStoredHistory();

  // Encontrar la última ruta válida para breadcrumb
  const validRoute = [...route.matched].reverse().find(isValidBreadcrumbRoute);

  if (!validRoute) return;

  // Obtener etiqueta legible y consistente
  const currentLabel = getRouteLabel(validRoute);

  // Generar nuevo ítem con timestamp para diferenciar visitas
  const newItem: BreadcrumbItem = {
    label: currentLabel,
    path: route.fullPath,
    timestamp: Date.now(),
  };

  const lastItem = history[history.length - 1];

  // Evita agregar repetidos consecutivos (mismo path consecutivo)
  if (!lastItem || lastItem.path !== newItem.path) {
    // Filtrar entradas antiguas repetidas para conservar SOLO la más reciente
    const filteredHistory = history.filter((item) => item.path !== newItem.path);

    // Agregar nuevo ítem al final (la visita más reciente)
    filteredHistory.push(newItem);

    // Limitar a máximo 50 entradas para prevenir crecimiento infinito
    if (filteredHistory.length > 50) filteredHistory.shift();

    // Persistir historial actualizado en localStorage
    saveHistory(filteredHistory);

    // Actualizar reactive para renderizar breadcrumb
    breadcrumbHistory.value = filteredHistory;
  }
};

/**
 * Computed reactivo que determina qué entradas mostrar en breadcrumb
 * - En pantallas grandes muestra todo el historial completo
 * - En pantallas pequeñas muestra un resumen: primer item + "..." + últimos 2 ítems,
 *   para evitar sobrecarga visual y mantener UX óptima.
 */
const displayedHistory = computed(() => {
  if (windowWidth.value > 768) return breadcrumbHistory.value;

  const items = [...breadcrumbHistory.value];
  if (items.length <= 3) return items;

  return [items[0], { label: '...', path: '', timestamp: 0 }, ...items.slice(-2)];
});

/**
 * Función para truncar labels largas según ancho de pantalla
 * Para evitar que el breadcrumb se desborde horizontalmente
 */
const truncateLabel = (label: string): string => {
  if (!label) return '';

  // Define límites de caracteres según breakpoints Bootstrap 5 (xs, sm, md)
  const maxLength = windowWidth.value < 576 ? 15 : windowWidth.value < 768 ? 20 : 30;

  return label.length > maxLength ? `${label.substring(0, maxLength - 3)}...` : label;
};

/**
 * Listener que actualiza el ancho de ventana reactivo para controlar responsive
 */
const onResize = () => {
  windowWidth.value = window.innerWidth;
};

/**
 * Hook onMounted para inicializar el breadcrumb y configurar event listener resize
 */
onMounted(() => {
  updateNavigationHistory(); // Cargar inicialmente la ruta actual en breadcrumb
  window.addEventListener('resize', onResize);
});

/**
 * Watcher profundo para detectar cambios en ruta, params y query
 * Actualiza breadcrumb en cada cambio verdaderamente significativo
 */
watch(
  () => ({
    path: route.path,
    params: { ...route.params },
    query: { ...route.query },
  }),
  (newVal, oldVal) => {
    if (JSON.stringify(newVal) !== JSON.stringify(oldVal)) {
      // Ejecuta la actualización después del siguiente tick para evitar race conditions
      nextTick(updateNavigationHistory);
    }
  },
  { deep: true, immediate: true },
);
</script>

<style scoped lang="scss">
/**
 * Estilos Bootstrap 5 para breadcrumb,
 * mejorados para truncamiento y experiencia UX responsiva
 */
.breadcrumb {
  --breadcrumb-bg: transparent;
  --breadcrumb-padding: 0.75rem 1rem;
  --breadcrumb-radius: 0.5rem;
  --breadcrumb-divider: '>';
  --breadcrumb-font-size: 0.875rem;
  --breadcrumb-color: #6c757d;
  --breadcrumb-hover: #0d6efd;
  --breadcrumb-active: #495057;

  padding: var(--breadcrumb-padding);
  background-color: var(--breadcrumb-bg);
  border-radius: var(--breadcrumb-radius);
  flex-wrap: wrap;
}

.breadcrumb-item {
  font-size: var(--breadcrumb-font-size);
  display: inline-flex;
  align-items: center;
  max-width: 100%;

  & + .breadcrumb-item {
    padding-left: 0.5rem;

    &::before {
      content: var(--breadcrumb-divider);
      color: var(--breadcrumb-color);
      padding-right: 0.5rem;
      font-weight: 600;
    }
  }

  a {
    color: var(--breadcrumb-color);
    transition: color 0.2s ease;
    display: inline-flex;
    align-items: center;
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;

    &:hover {
      color: var(--breadcrumb-hover);
    }

    i {
      margin-right: 0.25rem;
    }
  }

  &.active {
    color: var(--breadcrumb-active);
    font-weight: 600;

    span {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      display: inline-block;
      max-width: 100%;
    }
  }
}

/* Responsive breakpoints según Bootstrap 5 */
@media (max-width: 991.98px) {
  .breadcrumb {
    --breadcrumb-padding: 0.5rem 0.75rem;
    --breadcrumb-font-size: 0.8125rem;
  }
}

@media (max-width: 767.98px) {
  .breadcrumb {
    --breadcrumb-bg: #f8f9fa;
    --breadcrumb-divider: '/';
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    padding: 0.5rem;

    .breadcrumb-item {
      max-width: 33vw;
    }
  }
}

@media (max-width: 575.98px) {
  .breadcrumb {
    --breadcrumb-font-size: 0.75rem;

    .breadcrumb-item {
      max-width: 30vw;
    }
  }
}
</style>

<template>
  <!-- Breadcrumb con diseño moderno y elegante -->
  <nav aria-label="breadcrumb" class="breadcrumb-nav mb-4 bg-body-secondary">
    <div class="breadcrumb mb-0">
      <!-- Ítem fijo de inicio con estilo mejorado -->
      <li class="breadcrumb-item home-item">
        <router-link
          to="/admin"
          class="text-decoration-none d-flex align-items-center"
          aria-label="Ir a inicio"
        >
          <i class="bi bi-house-door-fill me-1"></i> <span class="home-text">Inicio</span>
        </router-link>
      </li>

      <!-- Puntos suspensivos con estilo mejorado -->
      <li v-if="showEllipsis" class="breadcrumb-item ellipsis-item" aria-hidden="true">
        <span class="ellipsis-icon">...</span>
      </li>

      <!-- Historial de rutas visitadas con nuevos estilos -->
      <li
        v-for="(item, index) in displayedHistory"
        :key="`${item.path}-${item.timestamp}`"
        :class="['breadcrumb-item', { active: index === displayedHistory.length - 1 }]"
        :aria-current="index === displayedHistory.length - 1 ? 'page' : undefined"
      >
        <div class="breadcrumb-link-container">
          <template v-if="index !== displayedHistory.length - 1">
            <router-link :to="item.path" class="breadcrumb-link text-decoration-none">
              <span class="breadcrumb-text">{{ truncateLabel(item.label) }}</span>
            </router-link>
          </template>
          <template v-else>
            <span class="breadcrumb-text current-page">{{ truncateLabel(item.label) }}</span>
          </template>
        </div>
      </li>
    </div>
  </nav>
</template>
<script lang="ts" setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { useRoute, type RouteLocationMatched } from 'vue-router';

// Constantes para gestión de historial
const BREADCRUMB_HISTORY_KEY = 'breadcrumbHistory';
const INACTIVITY_TIMEOUT = 5 * 60 * 1000; // 5 minutos en milisegundos
const MAX_HISTORY_ITEMS = 50;
const MAX_DESKTOP_ITEMS = 5; // Home + 5 items = 6 segmentos
const MAX_MOBILE_ITEMS = 2; // Home + 2 items = 3 segmentos

// Interfaces para tipado seguro
interface BreadcrumbItem {
  label: string;
  path: string;
  timestamp: number;
}

interface CustomRouteMeta {
  breadcrumb?: string | (() => string);
  isLayout?: boolean;
  title?: string;
}

// Referencias reactivas
const route = useRoute();
const breadcrumbHistory = ref<BreadcrumbItem[]>([]);
const windowWidth = ref(window.innerWidth);
const lastActivity = ref(Date.now());
let inactivityTimer: ReturnType<typeof setTimeout> | null = null;

/**
 * Obtiene el historial almacenado en localStorage de forma segura
 * con manejo de errores y validación de datos.
 */
const getStoredHistory = (): BreadcrumbItem[] => {
  try {
    const stored = localStorage.getItem(BREADCRUMB_HISTORY_KEY);
    if (!stored) return [];

    const parsed = JSON.parse(stored);

    // Validar estructura del historial
    if (!Array.isArray(parsed)) return [];

    return parsed.filter(
      (item: any) =>
        typeof item?.label === 'string' &&
        typeof item?.path === 'string' &&
        typeof item?.timestamp === 'number' &&
        item.path !== '/admin', // Excluir ruta de inicio
    );
  } catch (error) {
    console.error('Error parsing breadcrumb history:', error);
    return [];
  }
};
/**
 * Guarda el historial en localStorage con validación de estructura
 * y manejo de errores.
 */
const saveHistory = (history: BreadcrumbItem[]) => {
  try {
    // Filtrar solo objetos válidos
    const validHistory = history.filter((item) => item.label && item.path && item.timestamp);

    // Mantener solo las rutas únicas más recientes
    const uniqueHistory = validHistory.reduce((acc: BreadcrumbItem[], current) => {
      const existingIndex = acc.findIndex((item) => item.path === current.path);

      if (existingIndex !== -1) {
        // Conservar la versión más reciente de rutas duplicadas
        if (current.timestamp > acc[existingIndex].timestamp) {
          acc[existingIndex] = current;
        }
      } else {
        acc.push(current);
      }

      return acc;
    }, []);

    localStorage.setItem(BREADCRUMB_HISTORY_KEY, JSON.stringify(uniqueHistory));
  } catch (error) {
    console.error('Error saving breadcrumb history:', error);
  }
};

/**
 * Formatea etiquetas para mostrarlas de manera consistente
 * en el breadcrumb, capitalizando palabras y limpiando texto.
 */
const formatLabel = (str: string): string => {
  if (!str) return '';

  // Limpieza básica de texto
  return str
    .replace(/-/g, ' ')
    .replace(/\b\w/g, (c) => c.toUpperCase()) // Capitalizar cada palabra
    .replace(/Url$/i, '') // Eliminar sufijos comunes
    .trim();
};

/**
 * Obtiene una etiqueta legible para la ruta actual
 * priorizando metadatos, nombre de ruta o segmentos de path.
 */
const getRouteLabel = (routeMatched: RouteLocationMatched): string => {
  const meta = routeMatched.meta as CustomRouteMeta;

  // 1. Priorizar metadatos breadcrumb si existen
  if (meta?.breadcrumb) {
    return typeof meta.breadcrumb === 'function' ? meta.breadcrumb() : meta.breadcrumb;
  }

  // 2. Usar nombre de ruta si está disponible
  if (routeMatched.name) {
    const name =
      typeof routeMatched.name === 'string' ? routeMatched.name : routeMatched.name.toString();
    return formatLabel(name);
  }

  // 3. Extraer del último segmento del path
  const pathParts = routeMatched.path.split('/').filter(Boolean);
  if (pathParts.length > 0) {
    return formatLabel(pathParts[pathParts.length - 1]);
  }

  // Fallback para rutas sin información
  return 'Unknown';
};

/**
 * Determina si una ruta es válida para aparecer en el breadcrumb
 * excluyendo rutas raíz, sin nombre o rutas de layout.
 */
const isValidBreadcrumbRoute = (routeMatched: RouteLocationMatched): boolean => {
  // Excluir rutas raíz
  if (!routeMatched.name || routeMatched.path === '/') return false;

  const meta = routeMatched.meta as CustomRouteMeta;

  // Excluir rutas marcadas como layout
  if (meta?.isLayout) return false;

  // Excluir rutas con nombres que contengan 'layout'
  if (typeof routeMatched.name === 'string' && /layout/i.test(routeMatched.name)) {
    return false;
  }

  return true;
};

/**
 * Actualiza el historial de navegación con la ruta actual
 * evitando duplicados consecutivos y manteniendo una longitud máxima.
 */
const updateNavigationHistory = () => {
  // Obtener historial actualizado
  const history = getStoredHistory();

  // Encontrar la última ruta válida en la jerarquía de rutas
  const validRoute = [...route.matched].reverse().find(isValidBreadcrumbRoute);
  if (!validRoute) return;

  // Obtener etiqueta para la ruta actual
  const currentLabel = getRouteLabel(validRoute);

  // Crear nuevo ítem de historial
  const newItem: BreadcrumbItem = {
    label: currentLabel,
    path: route.fullPath,
    timestamp: Date.now(),
  };

  // Evitar duplicados consecutivos
  const lastItem = history[history.length - 1];
  if (lastItem && lastItem.path === newItem.path) return;

  // Eliminar ocurrencias anteriores del mismo path
  const filteredHistory = history.filter((item) => item.path !== newItem.path);

  // Agregar el nuevo ítem
  filteredHistory.push(newItem);

  // Limitar longitud máxima del historial
  if (filteredHistory.length > MAX_HISTORY_ITEMS) {
    filteredHistory.splice(0, filteredHistory.length - MAX_HISTORY_ITEMS);
  }

  // Guardar y actualizar estado reactivo
  saveHistory(filteredHistory);
  breadcrumbHistory.value = filteredHistory;

  // Actualizar tiempo de última actividad
  lastActivity.value = Date.now();
};

/**
 * Inicia/Reinicia el temporizador de inactividad que limpia el historial
 * después de 5 minutos sin actividad.
 */
const resetInactivityTimer = () => {
  if (inactivityTimer) {
    clearTimeout(inactivityTimer);
  }

  inactivityTimer = setTimeout(() => {
    localStorage.removeItem(BREADCRUMB_HISTORY_KEY);
    breadcrumbHistory.value = [];
  }, INACTIVITY_TIMEOUT);
};

/**
 * Maneja el evento de redimensionamiento de ventana
 * para actualizar el estado responsivo.
 */
const handleResize = () => {
  windowWidth.value = window.innerWidth;
};

/**
 * Historial de rutas a mostrar con formato responsivo:
 * - Pantallas grandes: muestra hasta 5 items (Home + 5 = 6)
 * - Pantallas pequeñas: muestra hasta 2 items (Home + 2 = 3)
 */
const displayedHistory = computed(() => {
  const history = [...breadcrumbHistory.value];
  const maxItems = windowWidth.value > 768 ? MAX_DESKTOP_ITEMS : MAX_MOBILE_ITEMS;

  return history.slice(-maxItems);
});

/**
 * Determina si se deben mostrar puntos suspensivos
 * para indicar rutas truncadas en móviles
 */
const showEllipsis = computed(() => {
  return windowWidth.value <= 768 && breadcrumbHistory.value.length > MAX_MOBILE_ITEMS;
});

/**
 * Trunca etiquetas largas según el ancho de pantalla
 * para evitar desbordamientos en dispositivos pequeños.
 */
const truncateLabel = (label: string): string => {
  if (!label) return '';

  // Definir límites de caracteres según breakpoints
  const maxLength =
    windowWidth.value < 576
      ? 15 // Móviles pequeños
      : windowWidth.value < 768
        ? 20 // Móviles grandes/Tablets
        : 30; // Escritorio

  return label.length > maxLength ? `${label.substring(0, maxLength - 3)}...` : label;
};

// Configuración inicial al montar el componente
onMounted(() => {
  // Cargar historial existente
  breadcrumbHistory.value = getStoredHistory();

  // Registrar eventos
  window.addEventListener('resize', handleResize);
  window.addEventListener('mousemove', resetInactivityTimer);
  window.addEventListener('keydown', resetInactivityTimer);

  // Iniciar temporizador de inactividad
  resetInactivityTimer();
});

// Limpieza al desmontar el componente
onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
  window.removeEventListener('mousemove', resetInactivityTimer);
  window.removeEventListener('keydown', resetInactivityTimer);

  if (inactivityTimer) {
    clearTimeout(inactivityTimer);
  }
});

// Observar cambios de ruta para actualizar el historial
watch(
  () => route.fullPath,
  (newPath, oldPath) => {
    // Evitar actualización si la ruta no ha cambiado realmente
    if (newPath !== oldPath) {
      updateNavigationHistory();
    }
    resetInactivityTimer();
  },
  { immediate: true },
);
</script>

<style scoped lang="scss">
/* Variables CSS actualizadas para un diseño más elegante */
.breadcrumb-nav {
  --breadcrumb-bg: linear-gradient(to right, #f8f9fa, #ffffff);
  --breadcrumb-padding: 0.5rem 1.25rem;
  --breadcrumb-radius: 12px;
  --breadcrumb-divider-color: #c0c6cf;
  --breadcrumb-color: #5a6a85;
  --breadcrumb-hover: #00568d;
  --breadcrumb-active: #2a3f5f;
  --breadcrumb-ellipsis-color: #a0aec0;
  --breadcrumb-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  --breadcrumb-font-size: 0.9rem;
  --breadcrumb-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  --breadcrumb-border: 1px solid rgba(0, 0, 0, 0.05);

  /* Nuevos colores para elementos específicos */
  --home-bg: #00568d;
  --home-color: #ffffff;
  --home-shadow: 0 2px 6px rgba(67, 97, 238, 0.3);
  --separator-icon: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23c0c6cf' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
}

.breadcrumb {

  padding: var(--breadcrumb-padding);
  border-radius: var(--breadcrumb-radius);
  flex-wrap: wrap;
  margin-bottom: 0;
  box-shadow: var(--breadcrumb-shadow);
  border: var(--breadcrumb-border);
  display: flex;
  align-items: center;
}

.breadcrumb-item {
  font-size: var(--breadcrumb-font-size);
  display: flex;
  align-items: center;
  max-width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  transition: var(--breadcrumb-transition);
  position: relative;
  padding: 0 0.5rem;

  &:not(.home-item):not(.ellipsis-item):not(:first-child)::before {
    content: '';
    display: inline-block;
    width: 16px;
    height: 16px;
    background: var(--separator-icon) no-repeat center center;
    margin-right: 0.75rem;
    opacity: 0.7;
    transition: var(--breadcrumb-transition);
  }

  /* Estilo especial para el ítem de inicio */
  &.home-item {
    background: var(--home-bg);
    border-radius: 8px;
    padding: 0.35rem 0.8rem;
    margin-right: 0.5rem;
    box-shadow: var(--home-shadow);

    a {
      color: var(--home-color) !important;
      font-weight: 500;

      .home-text {
        transition: transform 0.2s ease;
      }

      &:hover {
        .home-text {
          transform: translateX(2px);
        }
      }
    }

    i {
      color: var(--home-color);
      transition: transform 0.2s ease;
    }

    &:hover {
      i {
        transform: scale(1.1);
      }
    }
  }

  .breadcrumb-link-container {
    display: flex;
    align-items: center;
  }

  .breadcrumb-link {
    color: var(--breadcrumb-color);
    font-weight: 500;
    transition: var(--breadcrumb-transition);
    position: relative;
    padding: 0.25rem 0;

    .breadcrumb-text {
      position: relative;
      display: inline-block;

      &::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--breadcrumb-hover);
        transition: width 0.3s ease;
      }
    }

    &:hover {
      color: var(--breadcrumb-hover);

      .breadcrumb-text::after {
        width: 100%;
      }
    }
  }

  &.active {
    .breadcrumb-text {
      color: var(--breadcrumb-active);
      font-weight: 600;
      position: relative;

      &.current-page::before {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, #4361ee, #3a0ca3);
        border-radius: 2px;
      }
    }
  }

  /* Estilo para puntos suspensivos */
  &.ellipsis-item {
    padding: 0 0.5rem;
    color: var(--breadcrumb-ellipsis-color);
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    cursor: default;

    .ellipsis-icon {
      transform: translateY(-1px);
    }
  }
}

/* Animación al cargar los items */
.breadcrumb-item:not(.home-item) {
  animation: fadeIn 0.4s ease-out forwards;
  opacity: 0;
  transform: translateY(5px);

  @for $i from 1 through 10 {
    &:nth-child(#{$i}) {
      animation-delay: 0.05s * $i;
    }
  }
}

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive breakpoints */
@media (max-width: 1199.98px) {
  .breadcrumb {
    --breadcrumb-font-size: 0.85rem;
    padding: 0.4rem 1rem;
  }
}

@media (max-width: 991.98px) {
  .breadcrumb {
    --breadcrumb-font-size: 0.82rem;
    --breadcrumb-padding: 0.4rem 0.8rem;

    .breadcrumb-item {
      padding: 0 0.4rem;

      &:not(.home-item):not(.ellipsis-item):not(:first-child)::before {
        margin-right: 0.5rem;
        width: 14px;
        height: 14px;
      }
    }

    .home-item {
      padding: 0.3rem 0.7rem;
    }
  }
}

@media (max-width: 767.98px) {
  .breadcrumb {
    --breadcrumb-bg: #f8f9fa;
    --breadcrumb-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    padding: 0.4rem;
    overflow-x: auto;
    flex-wrap: nowrap;
    white-space: nowrap;
    scrollbar-width: thin;

    &::-webkit-scrollbar {
      height: 4px;
    }

    &::-webkit-scrollbar-thumb {
      background-color: rgba(0, 0, 0, 0.1);
      border-radius: 2px;
    }

    .breadcrumb-item {
      max-width: 40vw;
      flex-shrink: 0;

      &:not(.home-item):not(.ellipsis-item):not(:first-child)::before {
        margin-right: 0.4rem;
      }
    }

    .home-item {
      .home-text {
        display: none;
      }
    }
  }
}

@media (max-width: 575.98px) {
  .breadcrumb {
    --breadcrumb-font-size: 0.78rem;

    .breadcrumb-item {
      max-width: 35vw;

      &.ellipsis-item {
        padding: 0 0.3rem;
      }
    }
  }
}
</style>

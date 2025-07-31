<template>
  <aside
    class="sidenav navbar navbar-vertical navbar-expand-lg bg-dark border-end"
    :class="{ show: sidebarVisible, collapsed: isSidebarCollapsed }"
  >
    <div class="container-fluid flex-column h-100">
      <!-- Encabezado con logo y botones -->
      <div
        class="sidenav-header d-flex align-items-center justify-content-between p-3 border-bottom border-secondary"
      >
        <!-- Logo y toggle button para móvil -->
        <div class="d-flex align-items-center">
          <button
            class="btn btn-link px-0 me-2 d-lg-none"
            @click="toggleSidebar"
            aria-label="Alternar menú"
          >
            <i class="fas fa-bars" style="color: var(--color-secundario)"></i>
          </button>

          <div v-if="!isSidebarCollapsed" class="d-flex align-items-center">
            <i class="fas fa-chart-line text-primary me-2 fs-4"></i>
            <span class="navbar-brand fw-bold text-white text-capitalize">Alcaldia Distrital</span>
          </div>
        </div>

        <!-- Botón de colapso (solo desktop) -->
        <button
          v-if="!isMobile"
          class="btn btn-sm btn-toggle rounded-circle p-0"
          @click="toggleSidebarCollapse"
          aria-label="Alternar colapso"
          :title="isSidebarCollapsed ? 'Expandir menú' : 'Colapsar menú'"
        >
          <i class="fas" :class="isSidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
        </button>
      </div>

      <!-- Menú de navegación principal -->
      <div class="navbar-nav w-100 flex-column pt-3 overflow-auto flex-grow-1">
        <!-- Dashboard -->
        <RouterLink
          to="/dashboard"
          class="nav-link d-flex align-items-center px-3 py-3"
          :class="{ active: $route.path === '/dashboard' }"
          @click="closeMobileSidebar"
        >
          <i class="fas fa-tachometer-alt fs-5"></i>
          <span v-if="!isSidebarCollapsed" class="ms-3">Inicio</span>
        </RouterLink>

        <!-- Menú Santa Marta -->
        <div class="nav-item">
          <a
            class="nav-link d-flex align-items-center px-3 py-3"
            :class="{ active: activeMenu === 'santamarta' }"
            @click="toggleMenu('santamarta')"
          >
            <i class="fas fa-umbrella-beach"></i>
            <span v-if="!isSidebarCollapsed" class="ms-3">Santa Marta</span>
            <i
              v-if="!isSidebarCollapsed"
              class="fas ms-auto fs-6"
              :class="expandedMenu === 'santamarta' ? 'fa-chevron-up' : 'fa-chevron-down'"
            ></i>
          </a>
          <transition name="slide-down">
            <ul
              v-if="expandedMenu === 'santamarta' && !isSidebarCollapsed"
              class="nav flex-column ps-5 py-2"
            >
              <li class="nav-subitem">
                <RouterLink
                  to="/admin/santamarta"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-umbrella-beach me-2"></i>
                  Perfil
                </RouterLink>
              </li>
              <li class="nav-subitem">
                <RouterLink
                  to="/settings/security"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-shield-alt me-2"></i>
                  Seguridad
                </RouterLink>
              </li>
            </ul>
          </transition>
        </div>

        <!-- Menú Nuestra Alcaldía -->
        <div class="nav-item">
          <a
            class="nav-link d-flex align-items-center px-3 py-3"
            :class="{ active: activeMenu === 'settings' }"
            @click="toggleMenu('settings')"
          >
            <i class="fas fa-building-ngo"></i>
            <span v-if="!isSidebarCollapsed" class="ms-3">Nuestra Alcaldia</span>
            <i
              v-if="!isSidebarCollapsed"
              class="fas ms-auto fs-6"
              :class="expandedMenu === 'settings' ? 'fa-chevron-up' : 'fa-chevron-down'"
            ></i>
          </a>
          <transition name="slide-down">
            <ul
              v-if="expandedMenu === 'settings' && !isSidebarCollapsed"
              class="nav flex-column ps-5 py-2"
            >
              <li class="nav-subitem">
                <RouterLink
                  to="/settings/profile"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-user-circle me-2"></i>
                  Perfil
                </RouterLink>
              </li>
              <li class="nav-subitem">
                <RouterLink
                  to="/settings/security"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-shield-alt me-2"></i>
                  Seguridad
                </RouterLink>
              </li>
            </ul>
          </transition>
        </div>

        <!-- Menú Transparencia -->
        <div class="nav-item">
          <a
            class="nav-link d-flex align-items-center px-3 py-3"
            :class="{ active: activeMenu === 'transparencia' }"
            @click="toggleMenu('transparencia')"
          >
            <i class="fas fa-file-contract"></i>
            <span v-if="!isSidebarCollapsed" class="ms-3">Transparencia</span>
            <i
              v-if="!isSidebarCollapsed"
              class="fas ms-auto fs-6"
              :class="expandedMenu === 'transparencia' ? 'fa-chevron-up' : 'fa-chevron-down'"
            ></i>
          </a>
          <transition name="slide-down">
            <ul
              v-if="expandedMenu === 'transparencia' && !isSidebarCollapsed"
              class="nav flex-column ps-5 py-2"
            >
              <li class="nav-subitem">
                <RouterLink
                  to="/users/list"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-list-ul me-2"></i>
                  Lista de usuarios
                </RouterLink>
              </li>
              <li class="nav-subitem">
                <RouterLink
                  to="/users/roles"
                  class="nav-link d-flex align-items-center py-2"
                  @click="closeMobileSidebar"
                >
                  <i class="fas fa-user-tag me-2"></i>
                  Roles
                </RouterLink>
              </li>
            </ul>
          </transition>
        </div>
      </div>

      <!-- Footer del sidebar -->
      <div v-if="!isSidebarCollapsed" class="mt-auto p-3 border-top border-secondary">
        <button
          class="btn btn-outline-light btn-sm w-100 mb-2 d-flex align-items-center justify-content-center"
          @click="closeMobileSidebar"
        >
          <i class="fas fa-question-circle me-2"></i> Soporte
        </button>
      </div>
    </div>
  </aside>

  <!-- Overlay para móvil -->
  <div v-if="sidebarVisible && isMobile" class="sidebar-overlay" @click="closeSidebar"></div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRoute } from 'vue-router';

const props = defineProps({
  sidebarVisible: {
    type: Boolean,
    required: true,
  },
  isSidebarCollapsed: {
    type: Boolean,
    required: true,
  },
});

const emit = defineEmits(['toggle-sidebar-collapse', 'update:sidebar-visible']);

const route = useRoute();
const expandedMenu = ref('');
const activeMenu = ref('');

// Detectar si es dispositivo móvil
const isMobile = computed(() => window.innerWidth < 992);

// Función para alternar el colapso del sidebar
const toggleSidebarCollapse = () => {
  emit('toggle-sidebar-collapse');
  if (!props.isSidebarCollapsed) {
    expandedMenu.value = '';
  }
};

// Alternar menús desplegables
const toggleMenu = (menu: string) => {
  expandedMenu.value = expandedMenu.value === menu ? '' : menu;
  activeMenu.value = menu;
};

// Cerrar sidebar en móvil
const closeSidebar = () => {
  emit('update:sidebar-visible', false);
};

// Cerrar sidebar móvil al hacer clic en un enlace
const closeMobileSidebar = () => {
  if (isMobile.value) {
    closeSidebar();
  }
};

// Manejar el resize de la ventana
const handleResize = () => {
  if (!isMobile.value) {
    emit('update:sidebar-visible', true);
  }
};

// Configurar event listeners
onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize();
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});

// Función para alternar el sidebar (toggle)
const toggleSidebar = () => {
  emit('update:sidebar-visible', !props.sidebarVisible);
};
</script>

<style scoped>
.sidenav {
  --sidebar-bg: #1e293b;
  --sidebar-text: #f1f5f9;
  --sidebar-hover: #334155;
  --sidebar-active: #0ea5e9;
  --sidebar-border: #334155;
  --sidebar-icon: #94a3b8;
  --sidebar-icon-active: #ffffff;
  --transition: all 0.3s ease;

  background: var(--sidebar-bg);
  color: var(--sidebar-text);
  width: 280px;
  height: 100vh;
  transition: var(--transition);
  z-index: 1050;
  position: fixed;
  top: 0;
  left: 0;
  transform: translateX(-100%);
  overflow-y: auto;
}

.sidenav.show {
  transform: translateX(0);
}

.sidenav.collapsed {
  width: 70px;
}

.sidebar-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1040;
  cursor: pointer;
}

.container-fluid {
  padding: 0;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.sidenav-header {
  min-height: 60px;
  border-bottom: 1px solid var(--sidebar-border);
}

.btn-toggle {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(255, 255, 255, 0.1);
  border: none;
  color: var(--sidebar-icon);
  transition: var(--transition);
}

.btn-toggle:hover {
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
  transform: scale(1.1);
}

.nav-link {
  border-radius: 0.5rem;
  margin: 0.15rem 0.75rem;
  transition: var(--transition);
  position: relative;
  display: flex;
  align-items: center;
  padding: 12px 16px;
  color: var(--sidebar-text);
  text-decoration: none;
  cursor: pointer;
}

.nav-link:hover,
.nav-link.active {
  background: var(--sidebar-hover);
  color: white;
}

.nav-link.active {
  background: var(--sidebar-active);
  color: white;
  font-weight: 500;
}

.nav-link.active::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 4px;
  background: white;
  border-radius: 0 4px 4px 0;
}

.nav-link > i:first-child {
  font-size: 1.25rem;
  min-width: 24px;
  color: var(--sidebar-icon);
  transition: var(--transition);
}

.nav-link:hover > i:first-child,
.nav-link.active > i:first-child {
  color: white;
}

.nav-link span {
  font-size: 0.95rem;
  transition: var(--transition);
  flex: 1;
}

.sidenav.collapsed span {
  opacity: 0;
  width: 0;
  height: 0;
  overflow: hidden;
}

.nav-subitem .nav-link {
  padding: 10px 16px 10px 32px;
  border-radius: 8px;
  color: var(--sidebar-icon);
  font-size: 0.9rem;
  position: relative;
}

.nav-subitem .nav-link:hover,
.nav-subitem .nav-link.active {
  color: white;
  background: rgba(255, 255, 255, 0.05);
}

.nav-subitem .nav-link::before {
  content: '';
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--sidebar-icon);
  transition: var(--transition);
}

.nav-subitem .nav-link:hover::before,
.nav-subitem .nav-link.active::before {
  background: white;
}

.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.3s ease;
  overflow: hidden;
}

.slide-down-enter-from,
.slide-down-leave-to {
  max-height: 0 !important;
  opacity: 0;
  transform: translateY(-10px);
}

.slide-down-enter-to,
.slide-down-leave-from {
  max-height: 300px;
  opacity: 1;
  transform: translateY(0);
}

.sidenav.collapsed .sidenav-header {
  justify-content: center;
}

.sidenav.collapsed .nav-link {
  justify-content: center;
  padding: 0.75rem !important;
}

@media (min-width: 992px) {
  .sidenav {
    transform: translateX(0);
  }
  .sidenav.show {
    transform: translateX(0);
  }
  .sidebar-overlay {
    display: none !important;
  }
}
</style>

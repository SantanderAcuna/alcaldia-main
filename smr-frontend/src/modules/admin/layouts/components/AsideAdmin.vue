<!-- src/layouts/admin/components/AsideAdmin.vue -->
<template>
  <BarraAccesibilidad />
  <aside :class="['sidebar', { collapsed: isSidebarCollapsed, show: showMobileSidebar }]">
    <div class="sidebar-header">
      <div class="logo">
        <i class=""></i>
        <span v-if="!isSidebarCollapsed" class="logo-text">AdminPanel</span>
      </div>
      <button @click="toggleSidebar" class="toggle-btn d-none d-md-block">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Botón para cerrar en móviles -->
      <button @click="closeMobileSidebar" class="close-btn d-md-none">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <nav class="sidebar-menu">
      <div v-for="(group, groupName) in groupedMenuItems" :key="groupName">
        <div v-if="!isSidebarCollapsed" class="menu-title">
          <i :class="['me-2', group[0].icon]"></i>
          <span>{{ groupName }}</span>
        </div>
        <div
          v-for="item in group"
          :key="item.key"
          class="menu-item"
          :class="{ active: activeSection === item.key }"
          @click="setActiveSection(item.key); closeMobileSidebar()"
        >
          <i :class="item.icon"></i>
          <span v-if="!isSidebarCollapsed" class="menu-text">{{ item.label }}</span>
        </div>
      </div>
    </nav>

    <!-- Overlay para móviles -->
    <div v-if="showMobileSidebar" class="mobile-overlay d-md-none" @click="closeMobileSidebar"></div>
  </aside>
</template>

<script setup lang="ts">
import BarraAccesibilidad from '@/modules/publico/layouts/components/BarraAccesibilidad.vue';
import { computed, ref, onMounted, onUnmounted } from 'vue';

const isSidebarCollapsed = ref(false);
const showMobileSidebar = ref(false);
const activeSection = ref('dashboard');

const menuItems = [
  { group: 'Dashboard', key: 'dashboard', icon: 'fas fa-home', label: 'Inicio' },
  { group: 'Gestión', key: 'users', icon: 'fas fa-users', label: 'Usuarios' },
  { group: 'Gestión', key: 'content', icon: 'fas fa-file-alt', label: 'Contenido' },
  { group: 'Gestión', key: 'media', icon: 'fas fa-image', label: 'Multimedia' },
  { group: 'Analíticas', key: 'stats', icon: 'fas fa-chart-bar', label: 'Estadísticas' },
  { group: 'Analíticas', key: 'reports', icon: 'fas fa-file-pdf', label: 'Reportes' },
  { group: 'Configuración', key: 'settings', icon: 'fas fa-cog', label: 'Ajustes' },
  { group: 'Configuración', key: 'themes', icon: 'fas fa-palette', label: 'Apariencia' },
];

const groupedMenuItems = computed(() => {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  const groups: Record<string, any[]> = {};
  menuItems.forEach(item => {
    if (!groups[item.group]) {
      groups[item.group] = [];
    }
    groups[item.group].push(item);
  });
  return groups;
});

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};

const setActiveSection = (section: string) => {
  activeSection.value = section;
};

const openMobileSidebar = () => {
  showMobileSidebar.value = true;
  document.body.classList.add('no-scroll');
};

const closeMobileSidebar = () => {
  showMobileSidebar.value = false;
  document.body.classList.remove('no-scroll');
};

// Cerrar sidebar al hacer clic fuera en móviles
const handleClickOutside = (event: MouseEvent) => {
  const sidebar = document.querySelector('.sidebar');
  const toggleBtn = document.querySelector('.mobile-toggle');

  if (showMobileSidebar.value &&
      !sidebar?.contains(event.target as Node) &&
      !toggleBtn?.contains(event.target as Node)) {
    closeMobileSidebar();
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

defineExpose({ openMobileSidebar, closeMobileSidebar });
</script>

<style scoped>
:root {
  --color-alcaldia: #00ade7;
  --color-secundario: #00568d;
  --color-fondo: #ffffff;
  --color-texto: #333333;
  --color-acento: #ffdc2a;
  --sidebar-width: 250px;
  --sidebar-collapsed-width: 70px;
  --header-height: 70px;
}

.sidebar {
  width: var(--sidebar-width);
  background: linear-gradient(180deg, var(--color-alcaldia) 0%, var(--color-secundario) 100%);
  color: white;
  height: 100vh;
  position: fixed;
  transition: all 0.3s ease;
  z-index: 1000;
  overflow-y: auto;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.sidebar.collapsed {
  width: var(--sidebar-collapsed-width);
}

.sidebar-header {
  padding: 1rem;
  background: rgba(0, 0, 0, 0.15);
  height: var(--header-height);
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 700;
  font-size: 1.2rem;
}

.logo-icon {
  color: var(--color-acento);
  font-size: 1.8rem;
}

.toggle-btn, .close-btn {
  background: rgba(255, 255, 255, 0.1);
  border: none;
  color: white;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
}

.toggle-btn:hover, .close-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: rotate(90deg);
}

.close-btn {
  display: none; /* Oculto por defecto */
}

.sidebar-menu {
  padding: 1rem 0;
}

.menu-title {
  padding: 0.5rem 1.5rem;
  font-size: 0.75rem;
  text-transform: uppercase;
  color: rgba(255, 255, 255, 0.7);
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 1rem;
}

.menu-item {
  padding: 0.75rem 1.5rem;
  display: flex;
  align-items: center;
  gap: 15px;
  cursor: pointer;
  transition: all 0.2s;
  border-left: 3px solid transparent;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  margin: 0.25rem 0;
}

.menu-item:hover {
  background: rgba(255, 255, 255, 0.1);
  color: white;
}

.menu-item.active {
  background: rgba(255, 255, 255, 0.15);
  border-left-color: var(--color-acento);
  color: white;
}

.menu-item i {
  min-width: 24px;
  text-align: center;
  font-size: 1.1rem;
}

.sidebar.collapsed .logo-text,
.sidebar.collapsed .menu-text,
.sidebar.collapsed .menu-title {
  display: none;
}

/* Overlay para móviles */
.mobile-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: -1;
}

@media (max-width: 768px) {
  .sidebar {
    width: 280px;
    transform: translateX(-100%);
    transition: transform 0.3s ease-in-out;
  }

  .sidebar.show {
    transform: translateX(0);
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
  }

  .sidebar.collapsed {
    width: 280px;
  }

  .sidebar.show.collapsed .logo-text,
  .sidebar.show.collapsed .menu-text,
  .sidebar.show.collapsed .menu-title {
    display: none;
  }

  .toggle-btn {
    display: none;
  }

  .close-btn {
    display: flex; /* Mostrar solo en móviles */
    background: rgba(255, 255, 255, 0.15);
  }
}
</style>

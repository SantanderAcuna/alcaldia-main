<!-- src/layouts/admin/components/HeaderAdmin.vue -->
<template>
  <header class="header">
    <!-- Botón para mostrar sidebar en móviles con mejor diseño -->
    <button class="mobile-toggle d-md-none" @click="openMobileSidebar">
      <i class="fas fa-bars"></i>
    </button>

    <h1 class="page-title">{{ title }}</h1>

    <div class="user-actions d-flex align-items-center gap-3">
      <div class="notification position-relative">
        <i class="fas fa-bell fs-5"></i>
        <span class="badge">3</span>
      </div>
      <div class="dropdown">
        <div class="user-profile d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="user-avatar me-2">JD</div>
          <div class="user-info d-none d-md-block">
            <div class="user-name">John Doe</div>
            <div class="user-role">Administrador</div>
          </div>
          <i class="fas fa-chevron-down ms-2 text-muted d-none d-md-block"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
          <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2 text-primary"></i>Perfil</a></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2 text-warning"></i>Configuración</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2 text-danger"></i>Cerrar sesión</a></li>
        </ul>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps({
  title: String
});

const emit = defineEmits(['openMobile']);

const openMobileSidebar = () => {
  emit('openMobile');
};
</script>

<style scoped>
.header {
  height: var(--header-height);
  background: var(--color-fondo);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 100;
  padding: 0 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.page-title {
  font-size: 1.4rem;
  font-weight: 600;
  margin: 0;
  color: var(--color-secundario);
}

.mobile-toggle {
  background: none;
  border: none;
  color: var(--color-alcaldia);
  font-size: 1.5rem;
  margin-right: 15px;
  padding: 8px;
  border-radius: 8px;
  transition: background-color 0.2s;
}

.mobile-toggle:hover {
  background-color: rgba(0, 173, 231, 0.1);
}

.user-avatar {
  width: 40px;
  height: 40px;
  background: var(--color-alcaldia);
  border-radius: 50%;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.1rem;
}

.notification {
  position: relative;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: all 0.3s;
  cursor: pointer;
}

.notification:hover {
  background-color: rgba(0, 173, 231, 0.1);
}

.notification .badge {
  position: absolute;
  top: 5px;
  right: 5px;
  background: #dc3545;
  color: white;
  border-radius: 50%;
  width: 18px;
  height: 18px;
  font-size: 0.7rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-name {
  font-weight: 600;
  color: var(--color-dark);
}

.user-role {
  font-size: 0.8rem;
  color: var(--color-gray-600);
}

.dropdown-menu {
  border-radius: 12px;
  padding: 0.5rem;
}

.dropdown-item {
  padding: 0.75rem 1rem;
  border-radius: 8px;
  transition: all 0.2s;
  font-weight: 500;
}

.dropdown-item:hover {
  background-color: var(--color-gray-100);
  transform: translateX(5px);
}

@media (max-width: 768px) {
  .header {
    padding: 0 1rem;
  }

  .page-title {
    font-size: 1.2rem;
  }
}
</style>

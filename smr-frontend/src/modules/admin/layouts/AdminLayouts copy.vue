<!-- src/layouts/admin/AdminLayout.vue -->
<template>
  <div class="app-container">
    <AsideAdmin ref="asideAdmin" />

    <div class="main-content">
      <HeaderAdmin :title="sectionTitle" @openMobile="openMobileSidebar" />

      <section class="content">
        <div class="container-fluid">
          <router-view />
          <VueQueryDevtools />
        </div>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AsideAdmin from './components/AsideAdmin.vue';
import HeaderAdmin from './components/HeaderAdmin.vue';

const asideAdmin = ref<InstanceType<typeof AsideAdmin> | null>(null);
const sectionTitle = ref('Dashboard');

const openMobileSidebar = () => {
  if (asideAdmin.value) {
    asideAdmin.value.openMobileSidebar();
  }
};

onMounted(() => {
  // Inicializar tooltips de Bootstrap
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map((tooltipTriggerEl) => {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
</script>

<style>
:root {
  --color-primary: #00568d;
  --color-secondary: #6c757d;
  --color-success: #198754;
  --color-danger: #dc3545;
  --color-warning: #ffdc2a;
  --color-info: #00ade7;
  --color-light: #f8f9fa;
  --color-dark: #333333;
  --color-gray-100: #f8f9fa;
  --color-gray-200: #e9ecef;
  --color-gray-300: #dee2e6;
  --color-gray-400: #ced4da;
  --color-gray-500: #adb5bd;
  --color-gray-600: #6c757d;
  --color-gray-700: #495057;
  --color-gray-800: #343a40;
  --color-gray-900: #212529;
  --sidebar-width: 250px;
  --sidebar-collapsed-width: 70px;
  --header-height: 70px;
}

body {
  font-family: 'Roboto', sans-serif;
  background-color: #f8fafc;
  overflow-x: hidden;
  color: var(--color-gray-800);
  margin: 0;
}

body.no-scroll {
  overflow: hidden;
}

/* Layout */
.app-container {
  display: flex;
  min-height: 100vh;
}

/* Main Content */
.main-content {
  flex: 1;
  margin-left: var(--sidebar-width);
  transition: margin-left 0.3s ease;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.sidebar.collapsed ~ .main-content {
  margin-left: var(--sidebar-collapsed-width);
}

/* Content */
.content {
  padding: 1.5rem;
  flex: 1;
}

/* Cards */
.card {
  border-radius: 12px;
  border: none;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
  transition:
    transform 0.3s,
    box-shadow 0.3s;
  margin-bottom: 1.5rem;
  background: white;
  overflow: hidden;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.card-header {
  padding: 1rem 1.5rem;
  background: white;
  border-bottom: 1px solid var(--color-gray-200);
}

.card-body {
  padding: 1.5rem;
}

/* Stat Cards */
.stat-card {
  border-left: 4px solid transparent;
}

.stat-card .card-title {
  font-size: 0.9rem;
  color: var(--color-gray-600);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 0.5rem;
}

.stat-card .card-value {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0.5rem 0;
  color: var(--color-dark);
}

.stat-card .card-change {
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-weight: 500;
}

.change-positive {
  color: var(--color-success);
}

.change-negative {
  color: var(--color-danger);
}

.icon-circle {
  width: 54px;
  height: 54px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-circle i {
  font-size: 1.8rem;
}

/* Table */
.table {
  --bs-table-bg: transparent;
  margin-bottom: 0;
}

.table th {
  font-weight: 600;
  color: var(--color-gray-700);
  background-color: var(--color-gray-100);
  padding: 1rem 1.5rem;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
}

.table td {
  padding: 1rem 1.5rem;
  vertical-align: middle;
  border-top: 1px solid var(--color-gray-200);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 173, 231, 0.05);
}

.avatar-sm {
  width: 36px;
  height: 36px;
}

.avatar-title {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  font-size: 0.875rem;
  font-weight: 500;
}

.badge {
  font-weight: 500;
  padding: 0.5rem 0.75rem;
  border-radius: 8px;
}

/* Chart styles */
.doughnut-chart {
  position: relative;
  width: 180px;
  height: 180px;
  border-radius: 50%;
  background: conic-gradient(
    var(--color-success) 0% calc(35% * 360deg / 100),
    var(--color-warning) 0 calc((35% + 25%) * 360deg / 100),
    var(--color-info) 0 calc((35% + 25% + 20%) * 360deg / 100),
    var(--color-danger) 0 360deg
  );
}

.inner-circle {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100px;
  height: 100px;
  background: white;
  border-radius: 50%;
}

.legend-color {
  width: 12px;
  height: 12px;
  border-radius: 4px;
}

/* Responsive */
@media (max-width: 768px) {
  .main-content {
    margin-left: 0 !important;
    transition: none;
  }

  .content {
    padding: 1rem;
  }

  .stat-card .card-value {
    font-size: 1.5rem;
  }

  .icon-circle {
    width: 44px;
    height: 44px;
  }

  .icon-circle i {
    font-size: 1.5rem;
  }

  .doughnut-chart {
    width: 140px;
    height: 140px;
  }

  .inner-circle {
    width: 80px;
    height: 80px;
  }
}

@media (min-width: 769px) {
  .mobile-toggle {
    display: none !important;
  }
}
</style>

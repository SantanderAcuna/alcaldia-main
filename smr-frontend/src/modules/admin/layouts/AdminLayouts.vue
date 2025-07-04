<!-- src/layouts/admin/AdminLayout.vue -->
<template>
  <div class="app-container">
    <AsideAdmin ref="asideAdmin" />

    <div class="main-content">
      <HeaderAdmin :title="sectionTitle" @openMobile="openMobileSidebar" />

      <section class="content">
        <div class="container-fluid">
          <div class="row mb-4">
            <!-- Tarjeta de Usuarios Totales -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <div class="card stat-card border-start border-start-4 border-primary h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="card-title text-muted">Usuarios Totales</div>
                      <div class="card-value">1,258</div>
                      <div class="card-change change-positive">
                        <i class="fas fa-arrow-up me-1"></i>12.3%
                      </div>
                    </div>
                    <div class="icon-circle bg-primary-subtle">
                      <i class="fas fa-users text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tarjeta de Tickets Abiertos -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <div class="card stat-card border-start border-start-4 border-warning h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="card-title text-muted">Tickets Abiertos</div>
                      <div class="card-value">42</div>
                      <div class="card-change change-negative">
                        <i class="fas fa-arrow-down me-1"></i>5.2%
                      </div>
                    </div>
                    <div class="icon-circle bg-warning-subtle">
                      <i class="fas fa-ticket-alt text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tarjeta de Ingresos Mensuales -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <div class="card stat-card border-start border-start-4 border-success h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="card-title text-muted">Ingresos Mensuales</div>
                      <div class="card-value">$24,560</div>
                      <div class="card-change change-positive">
                        <i class="fas fa-arrow-up me-1"></i>8.7%
                      </div>
                    </div>
                    <div class="icon-circle bg-success-subtle">
                      <i class="fas fa-dollar-sign text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tarjeta de Tiempo Respuesta -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
              <div class="card stat-card border-start border-start-4 border-info h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <div class="card-title text-muted">Tiempo Respuesta</div>
                      <div class="card-value">2.4h</div>
                      <div class="card-change change-positive">
                        <i class="fas fa-arrow-down me-1"></i>15.8%
                      </div>
                    </div>
                    <div class="icon-circle bg-info-subtle">
                      <i class="fas fa-clock text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Tabla de Actividad Reciente -->
            <div class="col-12 col-lg-8 mb-4">
              <div class="card h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">Actividad Reciente</h5>
                  <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-sync me-1"></i>Actualizar
                  </button>
                </div>
                <div class="card-body px-0">
                  <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                      <thead class="table-light">
                        <tr>
                          <th>Usuario</th>
                          <th>Acción</th>
                          <th>Fecha</th>
                          <th>Estado</th>
                          <th class="text-end">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar-sm me-2">
                                <div class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">JD</div>
                              </div>
                              <div>John Doe</div>
                            </div>
                          </td>
                          <td>Actualizó perfil</td>
                          <td>Hace 10 min</td>
                          <td><span class="badge bg-success bg-opacity-10 text-success">Completado</span></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-light">
                              <i class="fas fa-eye"></i>
                            </button>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar-sm me-2">
                                <div class="avatar-title bg-warning bg-opacity-10 text-warning rounded-circle">JS</div>
                              </div>
                              <div>Jane Smith</div>
                            </div>
                          </td>
                          <td>Creó nuevo ticket</td>
                          <td>Hace 25 min</td>
                          <td><span class="badge bg-warning bg-opacity-10 text-warning">Pendiente</span></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-light">
                              <i class="fas fa-eye"></i>
                            </button>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar-sm me-2">
                                <div class="avatar-title bg-info bg-opacity-10 text-info rounded-circle">RJ</div>
                              </div>
                              <div>Robert Johnson</div>
                            </div>
                          </td>
                          <td>Subió documento</td>
                          <td>Hace 1 hora</td>
                          <td><span class="badge bg-success bg-opacity-10 text-success">Completado</span></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-light">
                              <i class="fas fa-eye"></i>
                            </button>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="avatar-sm me-2">
                                <div class="avatar-title bg-danger bg-opacity-10 text-danger rounded-circle">MG</div>
                              </div>
                              <div>Maria Garcia</div>
                            </div>
                          </td>
                          <td>Actualizó contraseña</td>
                          <td>Hace 2 horas</td>
                          <td><span class="badge bg-info bg-opacity-10 text-info">En progreso</span></td>
                          <td class="text-end">
                            <button class="btn btn-sm btn-light">
                              <i class="fas fa-eye"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <!-- Gráfico de Distribución -->
            <div class="col-12 col-lg-4 mb-4">
              <div class="card h-100">
                <div class="card-header bg-white border-0 py-3">
                  <h5 class="mb-0">Distribución de Tickets</h5>
                </div>
                <div class="card-body">
                  <div class="chart-container position-relative" style="height:300px">
                    <!-- Placeholder para gráfico -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                      <div class="position-relative mb-4">
                        <div class="doughnut-chart">
                          <div class="slice slice-success" style="--value: 35;"></div>
                          <div class="slice slice-warning" style="--value: 25;"></div>
                          <div class="slice slice-info" style="--value: 20;"></div>
                          <div class="slice slice-danger" style="--value: 20;"></div>
                          <div class="inner-circle"></div>
                        </div>
                      </div>

                      <div class="d-flex flex-wrap justify-content-center gap-3">
                        <div class="d-flex align-items-center">
                          <div class="legend-color bg-success"></div>
                          <span class="ms-2">Completados (35%)</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="legend-color bg-warning"></div>
                          <span class="ms-2">Pendientes (25%)</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="legend-color bg-info"></div>
                          <span class="ms-2">En progreso (20%)</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="legend-color bg-danger"></div>
                          <span class="ms-2">Rechazados (20%)</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
  transition: transform 0.3s, box-shadow 0.3s;
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

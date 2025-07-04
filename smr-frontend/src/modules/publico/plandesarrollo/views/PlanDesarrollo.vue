<!-- Alcalde.vue -->
<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2">Plan de Desarrollo</h1>
      <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Nuevo Plan</button>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="input-group">
          <input
            v-model="searchQuery"
            type="text"
            class="form-control"
            placeholder="Buscar por nombre..."
          />
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Plan de desarrollo</th>
                <th>Documento</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="plan in filteredPlanes" :key="plan.id">
                <td class="text-capitalize">
                  {{ plan.titulo }} {{ formatYear(plan.alcalde.fecha_inicio) }} -
                  {{ formatYear(plan.alcalde.fecha_fin) }}
                </td>
                <td>
                  <a
                    :aria-label="'Descargar ' + plan.titulo"
                    :href="plan.document_url"
                    download
                    target="_blank"
                    class="btn btn-sm btn-outline-primary"
                    onclick="event.stopPropagation();"
                  >
                    <i class="fas fa-download me-1"></i>
                    Descargar
                  </a>
                </td>

                <td>
                  <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-primary">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-primary">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <BotonPaginacion :page="currentPage" :hasMoreData="hasMoreData" />
  </div>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router';
import { ref, computed, watch } from 'vue';
import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { getPlanDesarrolloActions } from '@/modules/publico/plandesarrollo/actions/index.ts';
import BotonPaginacion from '@/modules/publico/layouts/conmom/BotonPaginacion.vue';

const route = useRoute();
const searchQuery = ref('');
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const statusFilter = ref('all');
const queryClient = useQueryClient();

// Corrección crítica: Manejo correcto de la página
const currentPage = ref(1);

// Inicializar página desde query params
if (route.query.page) {
  const pageNum = Number(route.query.page);
  currentPage.value = isNaN(pageNum) ? 1 : pageNum;
}

// Función para formatear años
const formatYear = (dateString: string) => {
  return new Date(dateString).getFullYear();
};

// Query principal con clave reactiva
const { data: planes } = useQuery({
  queryKey: ['planes', { page: currentPage }],
  queryFn: () => getPlanDesarrolloActions(currentPage.value),
  staleTime: 60 * 1000,
});

// Determinar si hay más datos
const hasMoreData = computed(() => {
  return planes.value?.length === 10; // Asumiendo 10 items por página
});

// Watch para cambios en la ruta
watch(
  () => route.query.page,
  (newPage) => {
    const pageNum = Number(newPage);
    currentPage.value = isNaN(pageNum) ? 1 : pageNum;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  },
  { immediate: true },
);

// Prefetch de siguiente página
watch(
  () => currentPage.value,
  (newPage) => {
    queryClient.prefetchQuery({
      queryKey: ['planes', { page: newPage + 1 }],
      queryFn: () => getPlanDesarrolloActions(newPage + 1),
    });
  },
);

// Filtrado de datos
const filteredPlanes = computed(() => {
  if (!planes.value) return [];

  return planes.value.filter((plan) =>
    plan.titulo.toLowerCase().includes(searchQuery.value.toLowerCase()),
  );
});
</script>

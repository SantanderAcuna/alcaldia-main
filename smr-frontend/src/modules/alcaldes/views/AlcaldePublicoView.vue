<!-- Alcalde.vue -->
<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2">Gestión de Alcaldes</h1>
      <button class="btn btn-primary"><i class="fas fa-plus me-2"></i>Nuevo Alcalde</button>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            v-model="searchQuery"
            placeholder="Buscar por nombre..."
          />
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div v-if="!alcaldes || alcaldes.length === 0" class="m-3 text-center py-5">
          <div class="spinner-border text-primary" v-if="!isloading" role="status">
            <span class="visually-hidden text-bg-dark">Cargando...</span>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table-alcalde table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Periodo</th>
                <th>Alcalde</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="alcalde in filteredAlcaldes" :key="alcalde.id">
                <td>
                  <img
                    :src="alcalde.foto_path"
                    class="rounded-circle"
                    object-fit="cover"
                    width="50"
                    height="50"
                    :alt="alcalde + alcalde.nombre_completo"
                  />
                </td>
                <td>{{ alcalde.nombre_completo }}</td>
                <td>
                  {{ new Date(alcalde.fecha_inicio).getFullYear() }} -
                  {{ new Date(alcalde.fecha_fin).getFullYear() }}
                </td>
                <td>
                  <span class="badge bg-primary text-capitalize">
                    {{ alcalde.actual ? 'Mandatario Actual' : 'ExAlcalde' }}
                  </span>
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
  </div>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router';
// import { useAlcaldeStore } from '@/stores/alcaldeStore';

import { getAlcaldeActions } from '@/modules/alcaldes/actions/index.ts';

import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { ref, computed, watch, watchEffect } from 'vue';

const route = useRoute();
const searchQuery = ref('');
const statusFilter = ref('all');

const page = ref(Number(route.query.page || 1));
const queryClient = useQueryClient();

const { data: alcaldes, isloading } = useQuery({
  queryKey: ['alcaldes', { page: page }],
  queryFn: () => getAlcaldeActions(page.value),
  staleTime: 1000 * 60, // refrescar backend despues de 1 minuto
});

watch(
  () => route.query.page,
  (newPage) => {
    page.value = Number(newPage || 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  },
);

watchEffect(() => {
  queryClient.prefetchQuery({
    queryKey: ['alcaldes', { page: page.value + 1 }],
    queryFn: () => getAlcaldeActions(page.value + 1),
  });
});

const filteredAlcaldes = computed(() => {
  let filtered = alcaldes.value;

  // Filtro por búsqueda
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter((a) => a.nombre_completo.toLowerCase().includes(query));
  }

  // Filtro por estado
  if (statusFilter.value !== 'all') {
    const isActive = statusFilter.value === 'active';
    filtered = filtered.filter((a) => a.actual === isActive);
  }

  return filtered;
});
</script>

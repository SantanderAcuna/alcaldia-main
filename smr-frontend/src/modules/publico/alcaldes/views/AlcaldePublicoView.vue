<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2">Gestión de Alcaldes</h1>
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
          <div class="spinner-border text-primary" v-if="!alcaldes" role="status">
            <span class="visually-hidden text-bg-dark">Cargando...</span>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table-alcalde table table-hover mb-0 text-center align-middle">
            <thead class="table-light">
              <tr>
                <th class="text-center align-middle">Foto</th>
                <th class="text-center align-middle">Nombre</th>
                <th class="text-center align-middle">Periodo</th>
                <th class="text-center align-middle">Alcalde</th>
                <th class="text-center align-middle">Plan de Desarrollo</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="(alcalde, index) in orderedAlcaldes"
                :key="index"
                class="text-center align-middle"
              >
                <td class="text-center align-middle">
                  <img
                    :src="alcalde.foto_path"
                    class="rounded-circle object-fit-cover"
                    width="50"
                    height="50"
                    :alt="alcalde + alcalde.nombre_completo"
                  />
                </td>

                <td class="text-center align-middle">
                  {{ alcalde.nombre_completo }}
                </td>

                <div class="periodo-container">
                  <p>
                    {{ alcalde.fecha_inicio ? formatDate(alcalde.fecha_inicio) : 'Actual' }} -
                    {{ alcalde.fecha_fin ? formatDate(alcalde.fecha_fin) : 'Presente' }}
                  </p>
                </div>

                <td class="text-center align-middle">
                  <span class="badge bg-primary text-capitalize">
                    {{
                      alcalde.actual
                        ? alcalde.sexo === 'masculino'
                          ? 'Mandatario actual'
                          : 'Alcaldesa actual'
                        : alcalde.sexo === 'masculino'
                          ? 'Exalcalde'
                          : 'Exalcaldesa'
                    }}
                  </span>
                </td>

                <td class="text-center align-middle">
                  <div class="documentos-container">
                    <h3>Documentos Relacionados</h3>
                    <div v-if="alcalde.plan_desarrollo?.documentos?.length">
                      <div
                        v-for="(doc, index) in alcalde.plan_desarrollo.documentos"
                        :key="doc.id || index"
                        class="documento-item"
                      >
                        <a :href="getDocumentos(doc.path)" target="_blank" class="documento-link">
                          <i class="fas fa-file-pdf"></i> {{ doc.nombre || 'Documento sin nombre' }}
                        </a>
                      </div>
                    </div>
                    <div v-else class="no-documents">No hay documentos disponibles</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <BotonPaginacion :page="page" :has-more-data="!!alcaldes && alcaldes.length < 10" />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router';
// import { useAlcaldeStore } from '@/stores/alcaldeStore';

import { getAlcaldeActions } from '@/modules/admin/alcaldes/actions/index.ts';

import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { ref, computed, watch, watchEffect } from 'vue';
import { usePagination } from '@/modules/composables/usePagination';
import BotonPaginacion from '@/modules/publico/layouts/conmom/BotonPaginacion.vue';
import { getDocumentUrlAction } from '../actions';
// import type { Alcalde } from '@/modules/interfaces/alcaldesInterfaces';

const route = useRoute();
const searchQuery = ref('');
const statusFilter = ref('all');
const { page } = usePagination();

const queryClient = useQueryClient();

const { data: alcaldes } = useQuery({
  queryKey: ['alcaldes', { page: page }],
  queryFn: () => getAlcaldeActions(page.value),
  staleTime: 100 * 60, // refrescar backend despues de 1 minuto
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
    filtered = filtered?.filter((a) => a.nombre_completo.toLowerCase().includes(query));
  }

  // Filtro por estado
  if (statusFilter.value !== 'all') {
    const isActive = statusFilter.value === 'active';
    filtered = filtered?.filter((a) => a.actual === isActive);
  }

  return filtered;
});

const orderedAlcaldes = computed(() => {
  if (!filteredAlcaldes.value) return [];

  return [...filteredAlcaldes.value].sort((a, b) => {
    // 1️⃣  El actual va primero
    if (a.actual && !b.actual) return -1;
    if (!a.actual && b.actual) return 1;

    // 2️⃣  Si empatan, el más reciente primero
    const fechaA = safeDateConstructor(a.fecha_inicio ?? a.fecha_fin);
    const fechaB = safeDateConstructor(b.fecha_inicio ?? b.fecha_fin);
    return fechaB.getTime() - fechaA.getTime();
  });
});

// // Props
// const props = defineProps<{
//   alcalde: Alcalde;
// }>();

// Métodos
const formatDate = (dateString: string | Date) => {
  const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'long', day: 'numeric' };
  const date = typeof dateString === 'string' ? new Date(dateString) : dateString;
  return date.toLocaleDateString('es-CO', options);
};

const getDocumentos = (path: string) => {
  return getDocumentUrlAction(path);
};

// Computed

// const hasDocuments = computed(() => {
//   return (props.alcalde.plan_desarrollo?.documentos?.length ?? 0) > 0;
// });

const safeDateConstructor = (dateStr: string | null | undefined): Date => {
  // Fecha por defecto (1/1/1970) si no hay valor válido
  const defaultDate = new Date(0);

  if (!dateStr) return defaultDate;

  try {
    const date = new Date(dateStr);
    return isNaN(date.getTime()) ? defaultDate : date;
  } catch {
    return defaultDate;
  }
};
</script>

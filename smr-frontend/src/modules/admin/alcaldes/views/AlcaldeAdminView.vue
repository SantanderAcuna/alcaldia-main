<template>
  <div class="bg-body-secondary">
    <main class="container py-5">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h4 class="fw-bold text-primary-emphasis">
          Histórico de Alcaldes Distritales De Santa Marta
        </h4>

        <form class="d-flex ms-auto me-4" @submit.prevent>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"
              ><i class="fas fa-search"></i
            ></span>
            <input
              v-model="searchQuery"
              type="text"
              class="form-control border-start-0"
              placeholder="Buscar"
            />
          </div>
        </form>

        <router-link
          to="/admin/alcaldes/create"
          class="btn btn-primary rounded-pill d-inline-flex align-items-center fw-bold shadow-sm"
        >
          <i class="fas fa-user-plus me-2"></i> Nuevo Alcalde
        </router-link>
      </div>

      <div class="row g-4">
        <div v-for="(alcalde, index) in filteredAlcaldes" :key="index" class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <img
                  :src="alcalde.foto_path"
                  :alt="`Foto de ${alcalde.nombre_completo}`"
                  class="rounded-circle border border-2 me-3"
                  style="width: 72px; height: 72px; object-fit: cover"
                />
                <div>
                  <h5 class="card-title mb-1 text-primary text-capitalize">
                    {{ alcalde.nombre_completo }}
                  </h5>
                  <span
                    class="badge text-capitalize"
                    :class="alcalde.actual ? 'bg-success' : 'bg-primary'"
                  >
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
                  <div class="text-muted small mt-1">
                    Período:
                    {{ alcalde.fecha_inicio ? formatYear(alcalde.fecha_inicio) : 'Actual' }} -
                    {{ alcalde.fecha_fin ? formatYear(alcalde.fecha_fin) : 'Presente' }}
                  </div>
                </div>
              </div>
              <p class="text-muted small mb-3">
                <i class="fas fa-quote-left me-1 text-primary"></i>
                {{ alcalde.presentacion?.slice(0, 80) || 'Sin presentación' }}
                {{ alcalde.presentacion && alcalde.presentacion.length > 80 ? '…' : '' }}
              </p>

              <!-- Sección corregida para el título del plan (ahora como objeto) -->
              <div v-if="alcalde.plan_desarrollo?.titulo" class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase p-2">
                  <i class="fas fa-file-contract me-1"></i>
                  {{ alcalde.plan_desarrollo.titulo }}
                </span>
              </div>

              <!-- Sección corregida para documentos (ahora como objeto) -->
              <div v-if="alcalde.plan_desarrollo?.documentos?.length" class="mb-3">
                <h6 class="fw-semibold mb-2">Documentos:</h6>
                <ul class="list-unstyled mb-0 ps-1">
                  <li
                    v-for="(documento, docIndex) in alcalde.plan_desarrollo.documentos.slice(0, 3)"
                    :key="docIndex"
                    class="d-flex justify-content-between align-items-center py-1 px-2 rounded mb-1 bg-light"
                  >
                    <div class="d-flex align-items-center">
                      <i class="fas fa-file-pdf text-danger me-2"></i>
                      <a
                        :href="getFullDocumentUrl(documento.path)"
                        target="_blank"
                        class="text-decoration-none text-dark"
                        :title="documento.nombre"
                        download
                      >
                        {{ truncateText(documento.nombre, 25) }}
                      </a>
                    </div>
                    <span class="badge bg-secondary rounded-pill fs-12">
                      {{ getFileExtension(documento.nombre) }}
                    </span>
                  </li>

                  <li v-if="alcalde.plan_desarrollo.documentos.length > 2">
                    <router-link
                      :to="`/admin/plan`"
                      class="text-decoration-none small text-primary d-block py-2"
                    >
                      <i class="fas fa-ellipsis-h me-2"></i>
                      Ver {{ alcalde.plan_desarrollo.documentos.length - 3 }} más...
                    </router-link>
                  </li>
                </ul>
              </div>

              <div class="container-fluid px-0">
                <div class="d-flex align-items-center gap-2">
                  <router-link
                    :to="{ name: 'alcalde-actual', params: { id: alcalde.id } }"
                    class="btn btn-primary rounded-pill px-3 py-2 shadow-sm"
                    title="Ver perfil completo"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-user-circle me-2"></i>Perfil
                  </router-link>

                  <router-link
                    :to="`/admin/alcaldes/${alcalde.id}`"
                    class="btn p-2 text-decoration-none"
                    title="Editar información"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-edit text-primary"></i>
                  </router-link>

                  <button
                    class="btn rounded-circle p-2 shadow-sm"
                    title="Eliminar registro"
                    data-bs-toggle="tooltip"
                    @click.prevent="eliminarAlcalde(alcalde.id)"
                  >
                    <i class="fas fa-trash-alt text-primary"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="!filteredAlcaldes || filteredAlcaldes.length === 0" class="col-12">
          <div class="d-flex flex-column justify-content-center align-items-center text-center p-5">
            <div v-if="!filteredAlcaldes" class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
            <div v-else>
              <i class="fas fa-users-slash text-muted mb-3" style="font-size: 3rem"></i>
              <h5>No se encontraron resultados para la búsqueda</h5>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts" setup>
import { useRoute } from 'vue-router';
import { getAlcaldeActions } from '@/modules/admin/alcaldes/actions/index.ts';
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { ref, computed, watch, watchEffect } from 'vue';
import { usePagination } from '@/modules/composables/usePagination';
import { apiConfig } from '@/api/apiConfig';
import type { Alcalde } from '@/modules/interfaces/alcaldesInterfaces';

import { useToast } from 'vue-toast-notification';
import type { Documento } from '@/modules/interfaces';

const $toast = useToast();
const route = useRoute();
const searchQuery = ref('');
const { page } = usePagination();

const formatYear = (date: string | Date) => {
  return new Date(date).getFullYear();
};

const queryClient = useQueryClient();

const { data: alcaldes } = useQuery({
  queryKey: ['alcaldes', { page: page }],
  queryFn: () => getAlcaldeActions(page.value),
  staleTime: 100 * 60,
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

const orderedAlcaldes = computed(() => {
  if (!alcaldes.value) return [];

  return [...alcaldes.value].sort((a, b) => {
    const dateA = a.fecha_inicio ? new Date(a.fecha_inicio).getTime() : 0;
    const dateB = b.fecha_inicio ? new Date(b.fecha_inicio).getTime() : 0;
    return dateA - dateB;
  });
});

const filteredAlcaldes = computed(() => {
  if (!searchQuery.value.trim()) return orderedAlcaldes.value;

  const query = searchQuery.value.toLowerCase();
  return orderedAlcaldes.value.filter((alcalde) => {
    // Buscar en nombre completo
    if (alcalde.nombre_completo?.toLowerCase().includes(query)) return true;

    // Buscar en presentación
    if (alcalde.presentacion?.toLowerCase().includes(query)) return true;

    // Buscar por año
    if (alcalde.fecha_inicio?.toLowerCase().includes(query)) return true;

    // Buscar por año
    if (alcalde.fecha_fin?.toLowerCase().includes(query)) return true;

    // Buscar por estado actual (booleano convertido a texto)
    const estadoActual = alcalde.actual ? 'mandatario actual' : 'exalcalde';

    if (estadoActual.toLowerCase().includes(query)) return true;

    // Buscar en título del plan de desarrollo
    if (alcalde.plan_desarrollo?.titulo?.toLowerCase().includes(query)) return true;

    // Buscar en nombres de documentos
    if (
      alcalde.plan_desarrollo?.documentos?.some((doc: Documento) =>
        doc.nombre?.toLowerCase().includes(query),
      )
    )
      return true;

    return false;
  });
});

const deleteAlcalde = async (alcaldeId: number) => {
  if (!alcaldeId) {
    $toast.error('ID de alcalde no definido');
    return;
  }

  try {
    await apiConfig.delete<Alcalde>(`/admin/alcaldes/${alcaldeId}`);
    $toast.success('Alcalde eliminado con éxito');
  } catch (error) {
    $toast.error('Error eliminando el alcalde:' + `${error}`);
    throw error;
  }
};

const { mutate: eliminarAlcalde } = useMutation({
  mutationFn: deleteAlcalde,
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ['alcaldes'] });
    $toast.success('Lista de alcaldes actualizada');
  },
  onError: () => {
    $toast.error('No se pudo eliminar el alcalde');
  },
});

const truncateText = (text: string, maxLength: number) => {
  return text.length > maxLength ? `${text.substring(0, maxLength)}...` : text;
};

const getFileExtension = (filename: string) => {
  return filename.split('.').pop()?.toUpperCase() || 'FILE';
};

const getFullDocumentUrl = (path: string): string => {
  const baseUrl = import.meta.env.VITE_API_BASE_URL;

  if (!baseUrl) {
    console.error('VITE_API_BASE_URL no está definido');
    return '';
  }

  if (path.startsWith('http')) {
    return path;
  }

  return `${baseUrl}/storage/${path}`;
};
</script>

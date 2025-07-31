<template>
  <div class="bg-body-secondary">
    <!-- Contenido principal -->
    <main class="container py-5">
      <!-- Encabezado y botón crear -->
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h4 class="fw-bold text-primary-emphasis">
          Historico de Alcaldes Distritales De Santa Marta
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
              placeholder="Buscar por nombre..."
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

      <!-- Grid de tarjetas de alcaldes -->
      <div class="row g-4">
        <div v-for="alcalde in orderedAlcaldes" :key="alcalde.id" class="col-lg-4 col-md-6">
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
                    Período: {{ new Date(alcalde.fecha_inicio).getFullYear() }} -
                    {{ new Date(alcalde.fecha_fin).getFullYear() }}
                  </div>
                </div>
              </div>
              <p class="text-muted small mb-3">
                <i class="fas fa-quote-left me-1 text-primary"></i>
                {{ alcalde.presentacion?.slice(0, 80) || 'Sin presentación' }}
                {{ alcalde.presentacion && alcalde.presentacion.length > 80 ? '…' : '' }}
              </p>
              <div v-if="alcalde.plan_desarrollo?.[0]?.titulo" class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase p-2">
                  <i class="fas fa-file-contract me-1"></i>
                  {{ alcalde.plan_desarrollo[0].titulo }}
                </span>
              </div>
              <div class="mb-3" v-if="alcalde.plan_desarrollo?.[0]?.documentos?.length">
                <h6 class="fw-semibold mb-2">Documentos:</h6>
                <ul class="list-unstyled mb-0 ps-1">
                  <!-- Mostrar solo el primer documento -->
                  <li
                    v-if="alcalde.plan_desarrollo[0].documentos.length > 0"
                    class="d-flex justify-content-between align-items-center py-1 px-2 rounded mb-1 bg-light text-primary"
                  >
                    <div>
                      <i class="fas fa-file-download me-2"></i>
                      <a
                        :href="`${API_STORAGE_URL}/${alcalde.plan_desarrollo[0].documentos[0].path}`"
                        target="_blank"
                        class="link-dark btn-sm"
                      >
                        {{ alcalde.plan_desarrollo[0].documentos[0].nombre.slice(0, 20) }}
                        {{ alcalde.plan_desarrollo[0].documentos[0].nombre.length > 20 ? '…' : '' }}
                      </a>
                    </div>
                  </li>

                  <!-- Enlace "Ver más" si hay más de 1 documento -->
                  <li
                    v-if="alcalde.plan_desarrollo[0].documentos.length > 1"
                    class="d-flex justify-content-between align-items-center py-1 px-2 rounded"
                  >
                    <router-link
                      :to="`/admin/alcaldes/${alcalde.id}/documentos`"
                      class="text-decoration-none small text-primary"
                    >
                      <i class="fas fa-ellipsis-h me-2"></i>
                      Ver {{ alcalde.plan_desarrollo[0].documentos.length - 1 }} más...
                    </router-link>
                  </li>
                </ul>
              </div>

              <div class="container-fluid px-0">
                <div class="d-flex align-items-center gap-2">
                  <!-- Botón Perfil -->
                  <router-link
                    :to="{ name: 'alcalde-actual', params: { id: alcalde.id } }"
                    class="btn btn-primary rounded-pill px-3 py-2 shadow-sm"
                    title="Ver perfil completo"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-user-circle me-2"></i>Perfil
                  </router-link>

                  <!-- Botón Editar -->
                  <router-link
                    :to="`/admin/alcaldes/${alcalde.id}`"
                    class="btn p-2 text-decoration-none"
                    title="Editar información"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-edit text-primary"></i>
                  </router-link>

                  <!-- Botón Eliminar -->
                  <button
                    class="btn rounded-circle p-2 shadow-sm"
                    title="Eliminar registro"
                    data-bs-toggle="tooltip"
                    @click.prevent="eliminarAlcalde(`${alcalde.id}`)"
                  >
                    <i class="fas fa-trash-alt text-primary"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mensaje vacío -->
        <div v-if="!alcaldes || alcaldes.length === 0" class="col-12">
          <div class="card border-0 shadow-sm bg-white text-center p-5">
            <div v-if="!alcaldes" class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Cargando...</span>
            </div>
            <div v-else>
              <i class="fas fa-users-slash text-muted mb-3" style="font-size: 3rem"></i>
              <h5>No hay alcaldes registrados</h5>
              <p class="mb-2 text-muted">No se encontraron resultados para la búsqueda</p>
              <router-link to="/admin/alcaldes/create" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i> Agregar nuevo alcalde
              </router-link>
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
import type { Alcaldes } from '@/modules/interfaces/alcaldesInterfaces';
import router from '@/router';
import { useToast } from 'vue-toast-notification';

const $toast = useToast();

const route = useRoute();
const searchQuery = ref('');
const statusFilter = ref('all');
const { page } = usePagination();
const API_STORAGE_URL = `${import.meta.env.VITE_API_BASE_URL}/storage`;

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

const filteredAlcaldes = computed(() => {
  let filtered = alcaldes.value;

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered?.filter((a) => a.nombre_completo.toLowerCase().includes(query));
  }

  if (statusFilter.value !== 'all') {
    const isActive = statusFilter.value === 'active';
    filtered = filtered?.filter((a) => a.actual === isActive);
  }

  return filtered;
});

const orderedAlcaldes = computed(() => {
  if (!filteredAlcaldes.value) return [];

  return [...filteredAlcaldes.value].sort((a, b) => {
    if (a.actual && !b.actual) return -1;
    if (!a.actual && b.actual) return 1;
    const fechaA = new Date(a.fecha_inicio ?? a.fecha_fin);
    const fechaB = new Date(b.fecha_inicio ?? b.fecha_fin);
    return fechaB.getTime() - fechaA.getTime();
  });
});

const deleteAlcalde = async (alcaldeId: number) => {
  if (!alcaldeId) {
    $toast.error('ID de alcalde no definido');
    return;
  }

  try {
    await apiConfig.delete<Alcaldes>(`/admin/alcaldes/${alcaldeId}`);

    $toast.success('Alcalde eliminado con exito');
  } catch (error) {
    $toast.error('Error en elminando el alcalde:' + `${error}`);

    throw error;
  }
};

// // Mutation de Vue Query
const { mutate: eliminarAlcalde, isPending: isDeleting } = useMutation({
  mutationFn: deleteAlcalde,
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ['alcaldes'] });
    $toast.success('Lista de alcaldes actualizada');

    router.push('/admin/alcaldes');
  },
  onError: () => {
    $toast.error('No se pudo eliminar el alcalde');
  },
});
</script>

<style scoped>
.bg-body-secondary {
  background-color: #f8f9fa;
  min-height: 100vh;
}

.navbar {
  padding: 0.75rem 1rem;
}

.card {
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.rounded-pill {
  border-radius: 50rem !important;
}

.hover-lift {
  transition: all 0.2s ease;
}
.hover-lift:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}
</style>

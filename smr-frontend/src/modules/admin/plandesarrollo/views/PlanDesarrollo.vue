<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2 fw-bold text-primary">
        <i class="fas fa-file-contract me-2"></i>Planes de Desarrollo
      </h1>
      <button class="btn btn-primary shadow-sm" @click="navigateToNew">
        <i class="fas fa-plus me-2"></i>Nuevo Plan
      </button>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row mb-4">
      <div class="col-md-8 col-lg-6">
        <div class="input-group shadow-sm rounded-pill overflow-hidden">
          <span class="input-group-text bg-light border-0 ps-4">
            <i class="fas fa-search text-muted"></i>
          </span>
          <input
            v-model="searchQuery"
            type="text"
            class="form-control border-0 py-3"
            placeholder="Buscar planes por título, alcalde o período..."
            @keyup.enter="handleSearch"
          />
          <button class="btn btn-outline-secondary border-0 px-4" @click="handleSearch">
            Buscar
          </button>
        </div>
      </div>
    </div>

    <!-- Mensaje sin resultados -->
    <div v-if="filteredPlanes.length === 0" class="text-center py-5">
      <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
      <h4 class="text-muted">No se encontraron planes</h4>
      <p class="text-muted">Intenta con otros términos de búsqueda</p>
    </div>

    <!-- Listado de planes -->
    <div class="row g-4">
      <div v-for="plan in filteredPlanes" :key="plan.id" class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden">
          <div class="card-header bg-light p-3 d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-0 fw-bold text-dark">
                {{ formatAlcaldePeriodo(plan.alcalde) }}
              </h5>
              <small class="text-muted">
                {{ plan.alcalde?.nombre_completo }}
              </small>
            </div>
          </div>

          <div class="card-body p-0">
            <!-- Documentos - Acordeón -->
            <div class="accordion accordion-flush" :id="`accordion-${plan.id}`">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button bg-white py-3 collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="`#collapse-${plan.id}`"
                    aria-expanded="false"
                    :aria-controls="`collapse-${plan.id}`"
                  >
                    <i class="fas fa-folder-open text-warning me-2"></i>
                    Documentos asociados
                    <span class="badge bg-primary rounded-pill ms-2">
                      {{ plan.documentos?.length || 0 }}
                    </span>
                  </button>
                </h2>
                <div
                  :id="`collapse-${plan.id}`"
                  class="accordion-collapse collapse"
                  :data-bs-parent="`#accordion-${plan.id}`"
                >
                  <div class="accordion-body p-3">
                    <div v-if="plan.documentos && plan.documentos.length" class="row g-3">
                      <div
                        v-for="(doc, i) in plan.documentos"
                        :key="i"
                        class="col-12 col-md-6 col-lg-4 col-xl-3"
                      >
                        <a
                          :href="doc.url"
                          target="_blank"
                          class="card document-card border-0 shadow-sm text-decoration-none text-dark h-100"
                        >
                          <div class="card-body d-flex align-items-center p-3">
                            <div class="document-icon bg-light-primary rounded-circle p-2 me-3">
                              <i class="fas fa-file-pdf text-danger fa-lg"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                              <h6 class="mb-0 text-truncate fw-medium">
                                {{ doc.nombre }}
                              </h6>
                              <small class="text-muted d-block text-truncate">
                                {{ getFileType(doc.nombre) }}
                              </small>
                            </div>
                            <div class="ms-2">
                              <i class="fas fa-download text-primary"></i>
                            </div>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div v-else class="text-center py-4 text-muted">
                      <i class="fas fa-inbox fa-2x mb-2"></i>
                      <p class="mb-0">No hay documentos asociados</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer bg-light p-3 small">
            <div class="d-flex justify-content-between text-muted">
              <span>
                <i class="fas fa-calendar me-1"></i>
                Creado: {{ formatDate(plan.created_at) }}
              </span>
              <span>
                <i class="fas fa-sync-alt me-1"></i>
                Actualizado: {{ formatDate(plan.updated_at) }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Paginación -->
    <div v-if="filteredPlanes.length > 0" class="d-flex justify-content-center mt-5">
      <nav>
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <button
              class="page-link"
              @click="changePage(currentPage - 1)"
              :disabled="currentPage === 1"
            >
              <i class="fas fa-chevron-left"></i>
            </button>
          </li>

          <li class="page-item active">
            <span class="page-link">{{ currentPage }}</span>
          </li>

          <li class="page-item" :class="{ disabled: !hasMoreData }">
            <button class="page-link" @click="changePage(currentPage + 1)" :disabled="!hasMoreData">
              <i class="fas fa-chevron-right"></i>
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useQuery } from '@tanstack/vue-query';
import type { PlanDesarrollo, Alcalde } from '@/modules/interfaces';
import { getPlanDesarrolloActions } from '@/modules/admin/plandesarrollo/actions/getPlanDesarrolloActions';

// Router
const router = useRouter();
const route = useRoute();

// Estado
const searchQuery = ref<string>('');
const currentPage = ref<number>(Number(route.query.page) || 1);
const perPage = ref<number>(10);

// Query
const { data: planes } = useQuery({
  queryKey: ['planes', currentPage.value],
  queryFn: () => getPlanDesarrolloActions(currentPage.value, perPage.value),
  staleTime: 60_000,
});

// Detectar si hay más datos
const hasMoreData = computed<boolean>(() => {
  return (planes.value?.data?.length || 0) === perPage.value;
});

// Planes filtrados
const filteredPlanes = computed<PlanDesarrollo[]>(() => {
  if (!planes.value || !planes.value.data) return [];

  return planes.value.data.filter(
    (plan: PlanDesarrollo) =>
      plan.titulo.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      (plan.alcalde?.nombre_completo || '')
        .toLowerCase()
        .includes(searchQuery.value.toLowerCase()) ||
      formatAlcaldePeriodo(plan.alcalde).toLowerCase().includes(searchQuery.value.toLowerCase()),
  );
});

// Funciones
const formatAlcaldePeriodo = (alcalde?: Alcalde | null): string => {
  if (!alcalde?.fecha_inicio || !alcalde?.fecha_fin) {
    return 'Período no disponible';
  }

  try {
    const startYear = new Date(alcalde.fecha_inicio).getFullYear();
    const endYear = new Date(alcalde.fecha_fin).getFullYear();
    return `${startYear} - ${endYear}`;
  } catch (error) {
    console.error('Error formateando fechas:', error);
    return 'Formato inválido';
  }
};

const formatDate = (dateString: string | undefined): string => {
  if (!dateString) return 'N/A';

  try {
    const date = new Date(dateString);
    return date.toLocaleDateString('es-CO', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    });
  } catch (error) {
    console.error('Error formateando fecha:', error);
    return 'Fecha inválida';
  }
};

const getFileType = (fileName: string): string => {
  const extension = fileName.split('.').pop()?.toLowerCase() || '';

  const types: Record<string, string> = {
    pdf: 'PDF',
    doc: 'DOC',
    docx: 'DOCX',
    xls: 'Excel',
    xlsx: 'Excel',
    ppt: 'PowerPoint',
    pptx: 'PowerPoint',
    txt: 'Texto',
    jpg: 'Imagen',
    jpeg: 'Imagen',
    png: 'Imagen',
    zip: 'Archivo comprimido',
    rar: 'Archivo comprimido',
  };

  return types[extension] || extension.toUpperCase();
};

const navigateToNew = () => router.push('/admin/plandesarrollo/nuevo');

const handleSearch = () => {
  currentPage.value = 1;
};

const changePage = (page: number) => {
  currentPage.value = page;
  router.push({ query: { page: page.toString() } });
};

// Watchers
watch(
  () => route.query.page,
  (newPage) => {
    const page = Number(newPage) || 1;
    if (page !== currentPage.value) {
      currentPage.value = page;
    }
  },
);
</script>

<style scoped>
.document-card {
  transition: all 0.2s ease;
  border-left: 3px solid #0d6efd;
  border-radius: 8px;
  overflow: hidden;
}

.document-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
  border-left: 3px solid #fd7e14;
}

.document-icon {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.bg-light-primary {
  background-color: rgba(13, 110, 253, 0.1);
}

.accordion-button:not(.collapsed) {
  background-color: #f8f9fa;
  box-shadow: none;
  color: #1e40af;
}

.card-header {
  transition: background-color 0.3s ease;
}

.card:hover .card-header {
  background-color: #f1f5f9;
}

.page-item.active .page-link {
  background-color: #0d6efd;
  border-color: #0d6efd;
}

.page-link {
  color: #0d6efd;
}

.pagination {
  --bs-pagination-padding-x: 0.75rem;
  --bs-pagination-padding-y: 0.375rem;
  --bs-pagination-font-size: 0.9rem;
}

.input-group {
  border-radius: 50px !important;
}

.input-group-text {
  border-radius: 50px 0 0 50px !important;
}
</style>

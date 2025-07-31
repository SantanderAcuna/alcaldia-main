<template>
  <div class="container mt-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2 mb-0">Plan de Desarrollo</h1>
      <button class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Nuevo Plan
      </button>
    </div>

    <!-- Buscador -->
    <div class="row mb-4">
      <div class="col">
        <div class="input-group">
          <input
            v-model="searchQuery"
            type="text"
            class="form-control"
            placeholder="Buscar por nombre..."
          />
          <span class="input-group-text">
            <i class="fas fa-search"></i>
          </span>
        </div>
      </div>
    </div>

    <!-- Tabla de resultados -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th class="w-40">Plan de Desarrollo</th>
                <th>Documento(s)</th>
                <th class="text-center w-15">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="plan in filteredPlanes" :key="plan.id">
                <!-- Título y período -->
                <td>
                  <div class="d-flex flex-column">
                    <strong class="text-capitalize">{{ plan.titulo }}</strong>
                    <small class="text-muted mt-1">
                      {{ plan.alcalde?.fecha_inicio ? formatYear(plan.alcalde.fecha_inicio) : '' }}
                      -
                      {{ plan.alcalde?.fecha_fin ? formatYear(plan.alcalde.fecha_fin) : '' }}
                    </small>
                  </div>
                </td>

                <!-- Documentos -->
                <td>
                  <div v-if="hasDocuments(plan)" class="document-container">
                    <div v-for="(doc, i) in getDocumentList(plan)" :key="i" class="document-item">
                      <span class="document-name">
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        {{ doc.nombre }}
                      </span>
                      <a
                        :href="doc.url"
                        :download="doc.nombre"
                        class="btn btn-sm btn-outline-primary download-btn"
                        target="_blank"
                        @click.stop
                      >
                        <i class="fas fa-download"></i>
                      </a>
                    </div>
                  </div>
                  <span v-else class="text-muted">Sin documento</span>
                </td>

                <!-- Acciones -->
                <td class="text-center">
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

    <!-- Paginación -->
    <BotonPaginacion :page="currentPage" :hasMoreData="hasMoreData" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { getPlanDesarrolloActions } from '@/modules/publico/plandesarrollo/actions/index.ts';
import BotonPaginacion from '@/modules/publico/layouts/conmom/BotonPaginacion.vue';

// Estado básico
const route = useRoute();
const queryClient = useQueryClient();
const searchQuery = ref('');
const currentPage = ref(1);

// Inicializar página desde query param
if (route.query.page) {
  const p = Number(route.query.page);
  currentPage.value = isNaN(p) ? 1 : p;
}

// Formatear fecha a año
const formatYear = (iso: string) => new Date(iso).getFullYear();

// Obtener datos con Vue Query
const { data } = useQuery({
  queryKey: ['planes', { page: currentPage }],
  queryFn: () => getPlanDesarrolloActions(currentPage.value),
  staleTime: 60_000,
});

// Verificar si un plan tiene documentos
const hasDocuments = (plan: any) => {
  return (plan.document_path?.length > 0) || (plan.document_url?.length > 0);
};

// Obtener lista unificada de documentos con nombres y URLs
const getDocumentList = (plan: any) => {
  const documents = [];

  // Caso 1: Tenemos document_path con nombres y document_url con URLs
  if (plan.document_path?.length > 0 && plan.document_url?.length > 0) {
    for (let i = 0; i < plan.document_path.length; i++) {
      documents.push({
        nombre: plan.document_path[i]?.nombre || `Documento ${i + 1}`,
        url: plan.document_url[i]
      });
    }
  }
  // Caso 2: Solo tenemos document_path con nombres
  else if (plan.document_path?.length > 0) {
    for (let i = 0; i < plan.document_path.length; i++) {
      documents.push({
        nombre: plan.document_path[i]?.nombre || `Documento ${i + 1}`,
        url: `${import.meta.env.VITE_API_BASE_URL}/storage/${plan.document_path[i]?.path}`
      });
    }
  }
  // Caso 3: Solo tenemos document_url (sin nombres)
  else if (plan.document_url?.length > 0) {
    for (let i = 0; i < plan.document_url.length; i++) {
      documents.push({
        nombre: `Documento ${i + 1}`,
        url: plan.document_url[i]
      });
    }
  }

  return documents;
};

// Paginación y prefetch
const hasMoreData = computed(() => (data.value?.length ?? 0) === 10);

watch(
  () => route.query.page,
  newPage => {
    const n = Number(newPage);
    currentPage.value = isNaN(n) ? 1 : n;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  },
  { immediate: true }
);

watch(
  () => currentPage.value,
  n => {
    queryClient.prefetchQuery({
      queryKey: ['planes', { page: n + 1 }],
      queryFn: () => getPlanDesarrolloActions(n + 1),
    });
  }
);

// Filtrado de búsqueda
const filteredPlanes = computed(() => {
  const list = data.value ?? [];
  return list.filter(p =>
    p.titulo.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});
</script>

<style scoped>
/* Diseño responsivo */
@media (max-width: 992px) {
  .w-40 {
    width: 40% !important;
  }

  .w-15 {
    width: 15% !important;
  }
}

@media (max-width: 768px) {
  .w-40 {
    width: 35% !important;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .btn-group .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }
}

@media (max-width: 576px) {
  .w-40 {
    width: 30% !important;
  }

  .document-container {
    max-width: 150px;
  }

  .document-name {
    font-size: 0.75rem;
  }

  .download-btn {
    padding: 0.2rem 0.4rem;
  }
}

/* Estilos para documentos */
.document-container {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.document-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #f8f9fa;
  border-radius: 4px;
  padding: 0.4rem 0.8rem;
  transition: background-color 0.2s;
}

.document-item:hover {
  background-color: #e9ecef;
}

.document-name {
  flex: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 0.9rem;
}

.download-btn {
  flex-shrink: 0;
  margin-left: 0.5rem;
  transition: transform 0.2s;
}

.download-btn:hover {
  transform: scale(1.1);
}

/* Mejoras visuales */
.table-hover tbody tr:hover {
  background-color: rgba(13, 110, 253, 0.05);
}

.card {
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.input-group-text {
  background-color: #f8f9fa;
  border-color: #ced4da;
}

.text-muted {
  color: #6c757d !important;
}
</style>

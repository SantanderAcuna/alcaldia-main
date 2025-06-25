<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-center align-items-center mb-4">
      <h1 class="h2">Histórico de Alcaldes de Santa Marta</h1>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
      <div class="col-md-8">
        <div class="input-group">
          <input
            v-model="searchQuery"
            type="text"
            class="form-control"
            placeholder="Buscar por alcalde..."
            aria-label="Buscar alcaldes por nombre"
          />
          <span class="input-group-text" aria-hidden="true">
            <i class="fas fa-search" aria-hidden="true"></i>
          </span>
        </div>
      </div>
      <div class="col-md-4">
        <select
          v-model="statusFilter"
          class="form-select"
          aria-label="Filtrar alcaldes por estado: todos, activos o inactivos"
        >
          <option value="all">Todos</option>
          <option value="active">Activos</option>
          <option value="inactive">Inactivos</option>
        </select>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div v-if="loading" class="text-center py-5" role="status" aria-live="polite">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
        </div>

        <div v-if="error" class="alert alert-danger m-3" role="alert">
          {{ error.message }}
        </div>

        <div v-if="!loading" class="table-responsive" aria-busy="false">
          <table class="table table-hover mb-0" role="table" aria-label="Tabla de histórico de alcaldes">
            <thead class="table-light">
              <tr>
                <th scope="col">Foto</th>
                <th scope="col">Nombre</th>
                <th scope="col">Periodo</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="alcalde in filteredAlcaldes" :key="alcalde.id">
                <td>
                  <img
                    v-if="alcalde.foto_path"
                    :src="getPublicUrl(alcalde.foto_path)"
                    class="rounded-circle"
                    width="50"
                    height="50"
                    :alt="`Foto del alcalde ${alcalde.nombre_completo}`"
                  />
                </td>
                <td>{{ alcalde.nombre_completo }}</td>
                <td>
                  {{ formatDate(alcalde.fecha_inicio) }} -
                  {{ alcalde.fecha_fin ? formatDate(alcalde.fecha_fin) : "Actual" }}
                </td>
                <td>
                  <span
                    :class="['status-badge', alcalde.actual ? 'active' : 'inactive']"
                    :aria-label="alcalde.actual ? 'Mandatario/a Actual' : 'Mandatario/a Anterior'"
                  >
                    {{ alcalde.actual ? "Mandatario/a Actual" : "Mandatario/a Anterior" }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group" aria-label="Acciones sobre el alcalde">
                    <button
                      @click="openViewModal(alcalde)"
                      class="btn btn-outline-primary"
                      :aria-label="`Ver detalles del alcalde ${alcalde.nombre_completo}`"
                      title="Ver detalles del alcalde"
                    >
                      <i class="fas fa-eye" aria-hidden="true"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modales -->
    <AlcaldeViewModal
      v-model:show="showViewModal"
      :alcalde="currentAlcalde"
      role="dialog"
      aria-modal="true"
      aria-label="Detalles del alcalde"
    />
  </div>
</template>


<script setup>
import { ref, computed, onMounted } from "vue";
import { useAlcaldeStore } from "@/stores/alcaldeStore";
import { getPublicUrl } from "@/services/api";
import { formatDate } from "@/utils/dateFormatter";

// Componentes

import AlcaldeViewModal from "@/components/alcaldia/publico/AlcaldeList.vue";
import ConfirmationModal from "@/components/ui/ConfirmationModal.vue";

const store = useAlcaldeStore();

// Estado
const searchQuery = ref("");
const statusFilter = ref("all");
const showFormModal = ref(false);
const showViewModal = ref(false);
const showConfirmModal = ref(false);
const currentAlcalde = ref(null);
const isEditMode = ref(false);
const alcaldeToDelete = ref(null);

// Computed
const filteredAlcaldes = computed(() => {
  let filtered = store.alcaldes;

  // Filtro por búsqueda
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter((a) =>
      a.nombre_completo.toLowerCase().includes(query)
    );
  }

  // Filtro por estado
  if (statusFilter.value !== "all") {
    const isActive = statusFilter.value === "active";
    filtered = filtered.filter((a) => a.actual === isActive);
  }

  return filtered;
});

const loading = computed(() => store.loading);
const error = computed(() => store.error);

// Métodos
const openCreateModal = () => {
  currentAlcalde.value = null;
  isEditMode.value = false;
  showFormModal.value = true;
};

const openEditModal = (alcalde) => {
  currentAlcalde.value = { ...alcalde };
  isEditMode.value = true;
  showFormModal.value = true;
};

const openViewModal = (alcalde) => {
  currentAlcalde.value = alcalde;
  showViewModal.value = true;
};

const confirmDelete = (id) => {
  alcaldeToDelete.value = id;
  showConfirmModal.value = true;
};

const executeDelete = async () => {
  try {
    await store.delete(alcaldeToDelete.value);
    showConfirmModal.value = false;
  } catch (error) {
    console.error("Error al eliminar:", error);
  }
};

const handleSaved = () => {
  showFormModal.value = false;
};

// Carga inicial
onMounted(() => {
  store.fetchAll();
});
</script>

<style scoped>
.table img {
  object-fit: cover;
}

.alcalde-status {
  display: inline-block;
}

.status-badge {
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  font-weight: 500;
}

.status-badge.active {
  background-color: #00568d;
  color: #f8f9fa;
}

.status-badge.inactive {
  background-color: #00568d;
  color: #f8f9fa;
}
</style>

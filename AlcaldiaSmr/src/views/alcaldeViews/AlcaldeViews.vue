<!-- Alcalde.vue -->
<template>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h2">Gestión de Alcaldes</h1>
      <button @click="openCreateModal" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Nuevo Alcalde
      </button>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
      <div class="col-md-8">
        <div class="input-group">
          <input v-model="searchQuery" type="text" class="form-control" placeholder="Buscar por nombre...">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
      </div>
      <div class="col-md-4">
        <select v-model="statusFilter" class="form-select">
          <option value="all">Todos</option>
          <option value="active">Activos</option>
          <option value="inactive">Inactivos</option>
        </select>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
          </div>
        </div>

        <div v-if="error" class="alert alert-danger m-3">
          {{ error.message }}
        </div>

        <div v-if="!loading" class="table-responsive">
          <table class="table table-hover mb-0">
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
                  <img v-if="alcalde.foto_path" 
                       :src="getPublicUrl(alcalde.foto_path)" 
                       class="rounded-circle" 
                       width="50" 
                       height="50"
                       alt="Foto alcalde">
                </td>
                <td>{{ alcalde.nombre_completo }}</td>
                <td>
                  {{ formatDate(alcalde.fecha_inicio) }} - 
                  {{ alcalde.fecha_fin ? formatDate(alcalde.fecha_fin) : 'Actual' }}
                </td>
                <td>
                  <span :class="['badge', alcalde.actual ? 'bg-success' : 'bg-secondary']">
                    {{ alcalde.actual ? 'Actual' : 'Ex Alcalde' }}
                  </span>
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <button @click="openViewModal(alcalde)" class="btn btn-outline-primary">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button @click="openEditModal(alcalde)" class="btn btn-outline-primary">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button @click="confirmDelete(alcalde.id)" class="btn btn-outline-primary">
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

    <!-- Modales -->
    <AlcaldeFormModal
      v-model:show="showFormModal"
      :alcalde="currentAlcalde"
      :is-edit="isEditMode"
      @saved="handleSaved"
    />

    <AlcaldeViewModal 
      v-model:show="showViewModal" 
      :alcalde="currentAlcalde" 
    />

    <ConfirmationModal
      v-model:show="showConfirmModal"
      title="Confirmar eliminación"
      message="¿Estás seguro de eliminar este registro? Esta acción no se puede deshacer."
      @confirm="executeDelete"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAlcaldeStore } from '@/stores/alcaldeStore'
import { getPublicUrl } from '@/services/api'
import { formatDate } from '@/utils/dateFormatter'

// Componentes

import AlcaldeFormModal from '@/components/alcalde/AlcaldeFormModal.vue'
import AlcaldeViewModal from '@/components/alcalde/AlcaldeViewModal.vue'
import ConfirmationModal from '@/components/ui/ConfirmationModal.vue';

//import AlcaldeFormModal from '@/components/AlcaldeFormModal.vue'
//import AlcaldeFormModal from '@/components/AlcaldeViewModal.vue'
//import ConfirmationModal from '@/components/ui/ConfirmationModal.vue'

const store = useAlcaldeStore()

// Estado
const searchQuery = ref('')
const statusFilter = ref('all')
const showFormModal = ref(false)
const showViewModal = ref(false)
const showConfirmModal = ref(false)
const currentAlcalde = ref(null)
const isEditMode = ref(false)
const alcaldeToDelete = ref(null)

// Computed
const filteredAlcaldes = computed(() => {
  let filtered = store.alcaldes

  // Filtro por búsqueda
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(a => a.nombre_completo.toLowerCase().includes(query))
  }

  // Filtro por estado
  if (statusFilter.value !== 'all') {
    const isActive = statusFilter.value === 'active'
    filtered = filtered.filter(a => a.actual === isActive)
  }

  return filtered
})

const loading = computed(() => store.loading)
const error = computed(() => store.error)

// Métodos
const openCreateModal = () => {
  currentAlcalde.value = null
  isEditMode.value = false
  showFormModal.value = true
}

const openEditModal = (alcalde) => {
  currentAlcalde.value = { ...alcalde }
  isEditMode.value = true
  showFormModal.value = true
}

const openViewModal = (alcalde) => {
  currentAlcalde.value = alcalde
  showViewModal.value = true
}

const confirmDelete = (id) => {
  alcaldeToDelete.value = id
  showConfirmModal.value = true
}

const executeDelete = async () => {
  try {
    await store.delete(alcaldeToDelete.value)
    showConfirmModal.value = false
  } catch (error) {
    console.error('Error al eliminar:', error)
  }
}

const handleSaved = () => {
  showFormModal.value = false
}

// Carga inicial
onMounted(() => {
  store.fetchAll()
})
</script>

<style scoped>
.table img {
  object-fit: cover;
}
</style>
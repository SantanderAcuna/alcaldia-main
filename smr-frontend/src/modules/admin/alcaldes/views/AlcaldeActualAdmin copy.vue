<template>
  <div class="container-xl py-4 py-lg-5 position-relative">
    <!-- Overlay de carga -->
    <div v-if="loading" class="overlay-loader">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Cargando...</span>
      </div>
    </div>

    <!-- Mensaje de error -->
    <div v-if="error" class="alert alert-danger mt-4">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      {{ error }}
      <button class="btn btn-link p-0" @click="retryLoading">Reintentar</button>
    </div>

    <!-- Contenido principal cuando los datos están cargados -->
    <template v-if="!loading && !error">
      <!-- Sección Hero -->
      <div class="hero-section bg-light rounded-4 shadow-sm mb-5">
        <div class="row g-0">
          <div class="col-md-5 d-flex align-items-center justify-content-center p-4 p-lg-5">
            <div class="profile-avatar position-relative">
              <div class="avatar-frame bg-white shadow-sm">
                <img
                  :src="filePaths.photo"
                  :alt="alcalde.nombre_completo"
                  class="img-fluid rounded-3"
                  loading="lazy"
                  @error="handleImageError"
                />
              </div>
              <div class="badge-container position-absolute top-0 end-0 mt-3 me-3">
                <span v-if="alcalde.actual" class="badge bg-success py-2 px-3 shadow-sm">
                  <i class="bi bi-star-fill me-1"></i>
                  Alcalde {{ alcalde.sexo === 'femenino' ? 'Actual' : 'Actual' }}
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-7 d-flex align-items-center p-4 p-lg-5">
            <div class="hero-content">
              <div class="d-flex align-items-center flex-wrap mb-3">
                <h1 class="display-5 fw-bold mb-0 me-3">{{ alcalde.nombre_completo }}</h1>
                <span class="badge bg-dark-subtle text-dark py-2 mt-2 mt-md-0">
                  <i class="bi bi-gender-ambiguous me-1"></i>
                  {{ formatSexo(alcalde.sexo) }}
                </span>
              </div>
              <h2 class="h5 text-secondary mb-4">
                Alcalde Distrital de Santa Marta | {{ formatDate(alcalde.fecha_inicio) }} -
                {{ formatDate(alcalde.fecha_fin) }}
              </h2>

              <p class="lead text-dark mb-4">
                {{ alcalde.presentacion || 'Sin presentación disponible' }}
              </p>

              <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-light text-dark border py-2 px-3">
                  <i class="bi bi-calendar-range me-1"></i>
                  Período: {{ formatDate(alcalde.fecha_inicio) }} -
                  {{ formatDate(alcalde.fecha_fin) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sección de Plan de Desarrollo -->
      <div
        v-if="hasDevelopmentPlan"
        class="development-plan bg-white rounded-4 shadow-sm mb-5 overflow-hidden"
      >
        <div class="row g-0">
          <div class="col-lg-8 p-4 p-lg-5">
            <div class="d-flex align-items-center mb-4">
              <div class="icon-wrapper bg-primary-subtle p-3 rounded-3 me-4">
                <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
              </div>
              <div>
                <h2 class="h3 fw-bold mb-1">Plan de Desarrollo</h2>
                <p class="text-muted mb-0">
                  {{ alcalde.plan_desarrollo?.titulo || 'Plan no disponible' }}

                  {{ periodoElecto(alcalde.fecha_inicio) }} -
                  {{ periodoElecto(alcalde.fecha_fin) }}
                </p>
              </div>
            </div>

            <p class="text-dark mb-4">
              {{ alcalde.plan_desarrollo?.descripcion || 'Descripción no disponible' }}
            </p>
          </div>

          <!-- Resumen del Plan -->
          <div class="col-lg-4 bg-light d-flex align-items-center p-4 p-lg-5 border-start">
            <div class="w-100">
              <div class="text-center mb-4">
                <i class="bi bi-journal-text display-3 text-primary mb-3"></i>
                <h3 class="h5 fw-bold text-capitalize">periodos del Plan de desarrollo</h3>
                <p v-if="planUpdatedAt" class="text-muted small mb-0">
                  {{ periodoElecto(alcalde.fecha_inicio) }} -
                  {{ periodoElecto(alcalde.fecha_fin) }}
                </p>
              </div>

              <!-- Documentos del Plan -->
              <div v-if="hasDocuments" class="mb-4">
                <h4 class="h5 fw-bold mb-3">Documentos:</h4>
                <div class="row g-3">
                  <div v-for="(doc, index) in visibleDocuments" :key="index" class="col-md-6">
                    <div
                      class="document-card bg-light p-3 rounded-3 border-start border-3 border-primary"
                    >
                      <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf fs-4 text-danger me-3"></i>
                        <div>
                          <h5 class="fw-bold mb-1 text-truncate" style="max-width: 100px">
                            {{ doc.nombre || 'Documento sin nombre' }}
                          </h5>
                          <a
                            :href="getDocumentUrl(doc.path)"
                            target="_blank"
                            class="btn btn-sm btn-outline-danger mt-2"
                          >
                            <i class="bi bi-download me-1"></i>
                            Descargar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Ver más documentos -->
                <button
                  v-if="hasMoreDocuments"
                  class="btn btn-link text-decoration-none mt-3"
                  @click="showAllDocuments = true"
                >
                  <i class="bi bi-chevron-down me-1"></i>
                  Ver {{ alcalde.plan_desarrollo?.documentos?.length - 2 || 0 }} documentos más
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mensaje cuando no hay plan de desarrollo -->
      <div v-else class="alert alert-info rounded-4 shadow-sm mb-5">
        <div class="d-flex align-items-center">
          <i class="bi bi-info-circle-fill fs-3 me-3 text-info"></i>
          <div>
            <h3 class="h5 fw-bold mb-1">Plan de desarrollo no disponible</h3>
            <p class="mb-0">Este alcalde no tiene un plan de desarrollo registrado.</p>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getAlcaldeById } from '@/api/alcaldes';

// Interfaz corregida y simplificada
interface Documento {
  id?: number;
  path: string;
  nombre: string;
  created_at?: string;
}

interface PlanDesarrollo {
  id?: number;
  titulo: string;
  descripcion: string;
  documentos: Documento[];
  updated_at?: string;
  created_at?: string;
}

interface Alcalde {
  id?: number;
  nombre_completo: string;
  presentacion: string;
  fecha_inicio: string | null;
  fecha_fin: string | null;
  sexo: 'masculino' | 'femenino';
  actual: boolean;
  foto_path: string;
  plan_desarrollo?: PlanDesarrollo | null;
  created_at?: string;
  updated_at?: string;
  deleted_at?: string | null;
}

interface MetaData {
  last_updated: string;
  version: number;
}

// Estado del componente
const loading = ref(true);
const error = ref<string | null>(null);
const showAllDocuments = ref(false);
const defaultImage = ref('/placeholder-avatar.jpg');

// Datos principales con la interfaz corregida
const alcalde = ref<Alcalde>({
  id: 0,
  nombre_completo: '',
  sexo: 'masculino',
  fecha_inicio: null,
  fecha_fin: null,
  presentacion: '',
  foto_path: '',
  actual: false,
  plan_desarrollo: null,
});

const meta = ref<MetaData>({
  last_updated: new Date().toISOString(),
  version: 1,
});

const route = useRoute();
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Computed properties
const filePaths = computed(() => ({
  photo: alcalde.value.foto_path
    ? `${API_BASE_URL}/storage/${alcalde.value.foto_path}`
    : defaultImage.value,
}));

const hasDevelopmentPlan = computed(() => {
  return (
    alcalde.value.plan_desarrollo &&
    (alcalde.value.plan_desarrollo.titulo ||
      alcalde.value.plan_desarrollo.descripcion ||
      hasDocuments.value)
  );
});

const hasDocuments = computed(() => {
  return (
    alcalde.value.plan_desarrollo?.documentos && alcalde.value.plan_desarrollo.documentos.length > 0
  );
});

const planUpdatedAt = computed(() => {
  return alcalde.value.plan_desarrollo?.updated_at;
});

const visibleDocuments = computed(() => {
  if (!hasDocuments.value) return [];

  const docs = alcalde.value.plan_desarrollo?.documentos || [];

  if (showAllDocuments.value) {
    return docs;
  }

  return docs.slice(0, 2);
});

const hasMoreDocuments = computed(() => {
  return (
    hasDocuments.value &&
    (alcalde.value.plan_desarrollo?.documentos?.length || 0) > 2 &&
    !showAllDocuments.value
  );
});

// Métodos
const formatDate = (dateString: string | Date | null): string => {
  if (!dateString) return 'Actual';

  try {
    const date = new Date(dateString);
    return isNaN(date.getTime())
      ? 'Fecha inválida'
      : date.toLocaleDateString('es-ES', {
          year: 'numeric',
          month: 'short',
        });
  } catch {
    return 'Fecha inválida';
  }
};

const formatDateTime = (dateString: string | undefined): string => {
  if (!dateString) return 'N/A';

  try {
    const date = new Date(dateString);
    return isNaN(date.getTime())
      ? 'Fecha inválida'
      : date.toLocaleString('es-ES', {
          day: 'numeric',
          month: 'short',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
        });
  } catch {
    return 'Fecha inválida';
  }
};

const periodoElecto = (fecha: Date | string | null | undefined) => {
  if (!fecha) return 'N/A';
  try {
    const date = new Date().getFullYear();

    return date;
  } catch (error) {
    console.log(error);
  }
};

const formatSexo = (sexo: string): string => {
  return sexo === 'masculino' ? 'Hombre' : 'Mujer';
};

const getDocumentUrl = (path: string): string => {
  return `${API_BASE_URL}/storage/${path}`;
};

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement;
  img.src = defaultImage.value;
};

const retryLoading = async () => {
  error.value = null;
  await loadAlcaldeData();
};

const loadAlcaldeData = async () => {
  try {
    loading.value = true;
    const id = Number(route.params.id);

    if (isNaN(id)) {
      throw new Error('ID de alcalde inválido');
    }

    const response = await getAlcaldeById(id);
    console.log('API Response:', response);

    // Validar estructura básica de la respuesta
    if (!response.data || typeof response.data !== 'object') {
      throw new Error('Estructura de datos inesperada');
    }

    // Manejar la estructura anidada de plan_desarrollo
    let planDesarrollo = null;
    if (response.data.plan_desarrollo) {
      // Si es un array, tomar el primer elemento
      if (Array.isArray(response.data.plan_desarrollo)) {
        planDesarrollo =
          response.data.plan_desarrollo.length > 0 ? response.data.plan_desarrollo[0] : null;
      }
      // Si es un objeto directo
      else if (typeof response.data.plan_desarrollo === 'object') {
        planDesarrollo = response.data.plan_desarrollo;
      }
    }

    // Asignar los datos con la nueva estructura
    alcalde.value = {
      id: response.data.id || 0,
      nombre_completo: response.data.nombre_completo || '',
      sexo: response.data.sexo || 'masculino',
      fecha_inicio: response.data.fecha_inicio || null,
      fecha_fin: response.data.fecha_fin || null,
      presentacion: response.data.presentacion || '',
      foto_path: response.data.foto_path || '',
      actual: response.data.actual || false,
      plan_desarrollo: planDesarrollo,
      created_at: response.data.created_at,
      updated_at: response.data.updated_at,
    };

    // Actualizar metadatos si están disponibles
    if (response.meta) {
      meta.value = {
        last_updated: response.meta.last_updated || new Date().toISOString(),
        version: response.meta.version || 1,
      };
    }
  } catch (err) {
    console.error('Error cargando detalles del alcalde:', err);
    error.value = 'Error al cargar los datos. Por favor intente nuevamente.';
    if (err instanceof Error) {
      error.value = err.message;
    }
  } finally {
    loading.value = false;
  }
};

// Ciclo de vida
onMounted(() => {
  loadAlcaldeData();
});
</script>

<style scoped>
/* Sistema de diseño optimizado */
:root {
  --border-radius: 0.75rem;
  --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  --transition: all 0.3s ease;
}

.container-xl {
  max-width: 1400px;
}

/* Hero Section */
.hero-section {
  overflow: hidden;
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: var(--transition);
}

.hero-section:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.profile-avatar {
  position: relative;
}

.avatar-frame {
  padding: 8px;
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow);
  transition: var(--transition);
  background-color: #fff;
  border: 1px solid #eee;
}

.avatar-frame:hover {
  transform: translateY(-5px) scale(1.02);
}

.avatar-frame img {
  transition: transform 0.5s ease;
  max-height: 250px;
  width: auto;
  object-fit: cover;
}

.avatar-frame:hover img {
  transform: scale(1.05);
}

.badge-container {
  z-index: 10;
}

/* Development Plan */
.development-plan {
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: var(--transition);
}

.development-plan:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.icon-wrapper {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.document-card {
  transition: var(--transition);
  height: 100%;
  border: 1px solid #eee;
}

.document-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--box-shadow);
  border-color: #ddd;
}

/* Professional Journey */
.journey-timeline {
  max-width: 800px;
  margin: 0 auto;
}

.timeline-line {
  width: 2px;
  left: 2.25rem;
  background: linear-gradient(to bottom, #6c757d, transparent);
  height: 95%;
}

.timeline-badge {
  width: 16px;
  height: 16px;
  left: 2.15rem;
  top: 10px;
  border: 2px solid white;
}

.timeline-content {
  transition: var(--transition);
  border: 1px solid rgba(0, 0, 0, 0.04);
  background-color: #f8f9fa;
}

.timeline-content:hover {
  box-shadow: var(--box-shadow);
  border-color: rgba(0, 0, 0, 0.08);
  transform: translateX(5px);
}

/* Footer */
.footer-section {
  background: rgba(0, 0, 0, 0.02);
  border-radius: var(--border-radius);
}

.brand-logo {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #2c3e50, #1a1a2e);
}

/* Loader */
.overlay-loader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.92);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
  backdrop-filter: blur(2px);
}

/* Responsive Design */
@media (max-width: 992px) {
  .hero-section .row {
    flex-direction: column;
  }

  .profile-avatar {
    margin-bottom: 2rem;
  }

  .display-5 {
    font-size: 2.2rem;
  }
}

@media (max-width: 768px) {
  .development-plan .row {
    flex-direction: column-reverse;
  }

  .col-lg-4.border-start {
    border-left: none !important;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
  }

  .p-4,
  .p-lg-5 {
    padding: 1.5rem !important;
  }

  .icon-wrapper {
    margin-right: 1rem !important;
    margin-bottom: 1rem;
  }
}

@media (max-width: 576px) {
  .display-5 {
    font-size: 1.8rem;
  }

  .hero-content {
    text-align: center;
  }

  .d-flex.align-items-center.mb-3 {
    flex-direction: column;
    gap: 1rem;
  }

  .d-flex.flex-wrap.gap-2 {
    justify-content: center;
  }

  .d-flex.align-items-center.mb-4 {
    flex-direction: column;
    align-items: flex-start !important;
  }

  .professional-journey .d-flex {
    flex-direction: column;
    align-items: flex-start;
  }

  .footer-section .row > div {
    text-align: center !important;
    margin-bottom: 1rem;
  }

  .footer-section .text-md-end {
    justify-content: center !important;
  }

  .timeline-line {
    left: 1.5rem;
  }

  .timeline-badge {
    left: 1.4rem;
  }
}
</style>

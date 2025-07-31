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

    <!-- Contenido principal -->
    <template v-if="!loading && !error">
      <!-- Sección Hero modificado: foto arriba, texto abajo -->
      <!-- Sección Hero modificado: foto arriba, texto debajo usando ancho completo -->
      <div class="hero-section bg-light rounded-4 shadow-sm mb-5">
        <div class="row g-0">
          <div class="col-12 d-flex flex-column align-items-center p-4 p-lg-5">
            <!-- Foto centrada arriba -->
            <div
              class="profile-avatar position-relative mb-4"
              style="max-width: 300px; width: 100%"
            >
              <div class="avatar-frame bg-white shadow-sm mx-auto">
                <img
                  :src="filePaths.photo"
                  :alt="
                    alcalde.nombre_completo
                      ? `Foto de ${alcalde.nombre_completo}`
                      : 'Foto no disponible'
                  "
                  class="img-fluid rounded-3"
                  loading="lazy"
                  @error="handleImageError"
                />
              </div>
              <div class="badge-container position-absolute top-0 end-0 mt-3 me-3">
                <span
                  v-if="alcalde.actual"
                  class="badge bg-success py-2 px-3 shadow-sm"
                  aria-label="Alcalde actual"
                >
                  {{ alcalde.sexo === 'femenino' ? 'Alcaldesa Actual' : 'Alcalde Actual' }}
                </span>
              </div>
            </div>

            <!-- Texto debajo, centrado pero ocupa todo el ancho disponible -->
            <div class="hero-content text-container text-center w-100">
              <h1 class="display-5 fw-bold mb-3">{{ alcalde.nombre_completo }}</h1>
              <h2 class="h5 text-secondary mb-4">
                Alcalde Distrital de Santa Marta | {{ periodoElecto(alcalde.fecha_inicio) }} -
                {{ periodoElecto(alcalde.fecha_fin) }}
              </h2>

              <!-- Párrafo con ancho 100%, justificado, sin limitación específica de max-width ni margen auto -->
              <p class="lead text-dark mb-4 text-justify" style="width: 100%">
                {{ alcalde.presentacion || 'Sin presentación disponible' }}
              </p>
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
          <div class="col-lg-8 p-4 p-lg-5 text-container">
            <div class="d-flex align-items-center mb-4">
              <div class="icon-wrapper bg-primary-subtle p-3 rounded-3 me-4">
                <i class="fas fa-bookmark fs-1 text-primary"></i>
              </div>
              <div>
                <h2 class="h3 fw-bold mb-1">
                  {{ alcalde.plan_desarrollo?.titulo || 'Plan no disponible' }}
                  {{ periodoElecto(alcalde.fecha_inicio) }} - {{ periodoElecto(alcalde.fecha_fin) }}
                </h2>
                <p class="text-muted mb-0"></p>
              </div>
            </div>

            <p class="text-dark mb-4 text-justify">
              {{ alcalde.plan_desarrollo?.descripcion || 'Descripción no disponible' }}
            </p>
          </div>

          <!-- Resumen del Plan -->
          <div class="col-lg-4 bg-light d-flex align-items-center p-4 p-lg-5 border-start">
            <div class="w-100 text-container">
              <div class="text-center mb-4">
                <i class="bi bi-journal-text display-3 text-primary mb-3"></i>
                <h3 class="h5 fw-bold">
                  {{ alcalde.plan_desarrollo?.titulo || 'Titulo no disponible' }}
                </h3>
              </div>

              <!-- Documentos del Plan -->
              <div v-if="hasDocuments" class="mb-4">
                <h4 class="h5 fw-bold mb-3">Documentos:</h4>

                <div class="table-responsive">
                  <table class="table table-borderless align-middle mb-0">
                    <thead>
                      <tr class="bg-light">
                        <th scope="col" class="fw-semibold text-dark">Plan de Desarrollo</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(doc, index) in visibleDocuments"
                        :key="doc.id || index"
                        class="border-bottom"
                      >
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="icon-wrapper bg-light rounded-2 p-2 me-3">
                              <a
                                :href="getDocumentUrl(doc.path)"
                                target="_blank"
                                class="btn btn-sm btn-outline-danger"
                                title="Descargar documento"
                                rel="noopener noreferrer"
                                :download="doc.nombre || ''"
                                :aria-label="`Descargar ${doc.nombre || 'documento'}`"
                              >
                                <!-- Ícono de descarga FontAwesome -->
                                <i class="fas fa-download me-1"></i>
                              </a>
                            </div>
                            <div class="d-flex flex-column">
                              <span
                                class="fw-medium text-truncate"
                                style="max-width: 200px"
                                :title="doc.nombre"
                              >
                                {{ doc.nombre || 'Documento sin nombre' }}
                              </span>
                              <span class="text-muted small">
                                <!-- Ícono calendario FontAwesome -->
                                <font-awesome-icon icon="calendar" class="me-1" />
                                {{ formatDateTime(doc.created_at) }}
                              </span>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <button
                  v-if="hasMoreDocuments"
                  class="btn btn-link text-decoration-none mt-3 w-100 text-center"
                  @click="showAllDocuments = true"
                >
                  <i class="fas fa-chevron-down me-1"></i>

                  Ver {{ alcalde.plan_desarrollo?.documentos?.length - 3 || 0 }} documentos más
                </button>
              </div>
              <div v-else class="alert alert-warning rounded-3 py-2">
                <i class="bi bi-exclamation-circle me-2"></i>
                No hay documentos disponibles
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

/**
 * Interfaz para documentos adjuntos
 *
 * Prevención de errores:
 * - Campos opcionales para compatibilidad con diferentes estructuras de datos
 * - Validación de path en getDocumentUrl para evitar enlaces rotos
 */
interface Documento {
  id?: number;
  path: string;
  nombre: string;
  created_at?: string;
}

/**
 * Interfaz para el plan de desarrollo
 *
 * Prevención de errores:
 * - Manejo de documentos como array vacío por defecto
 * - Validación de existencia antes de acceder a propiedades
 */
interface PlanDesarrollo {
  id?: number;
  titulo: string;
  descripcion: string;
  documentos: Documento[];
  updated_at?: string;
  created_at?: string;
}

/**
 * Interfaz principal para el alcalde
 *
 * Prevención de errores:
 * - Campos opcionales para evitar errores en renderizado inicial
 * - Valor por defecto para plan_desarrollo (null)
 * - Validación de fechas nulas en funciones de formato
 */
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

// Estado reactivo del componente
const loading = ref(true);
const error = ref<string | null>(null);
const showAllDocuments = ref(false);
const defaultImage = ref('/placeholder-avatar.jpg');

// Datos principales con valores por defecto seguros
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

const route = useRoute();
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

// Propiedades computadas
const filePaths = computed(() => ({
  photo: alcalde.value.foto_path
    ? `${API_BASE_URL}/storage/${alcalde.value.foto_path}`
    : defaultImage.value,
}));

const hasDevelopmentPlan = computed(() => {
  return (
    !!alcalde.value.plan_desarrollo &&
    (alcalde.value.plan_desarrollo.titulo ||
      alcalde.value.plan_desarrollo.descripcion ||
      hasDocuments.value)
  );
});

const hasDocuments = computed(() => {
  return !!alcalde.value.plan_desarrollo?.documentos?.length;
});

const visibleDocuments = computed(() => {
  if (!hasDocuments.value) return [];

  const docs = alcalde.value.plan_desarrollo?.documentos || [];
  return showAllDocuments.value ? docs : docs.slice(0, 3);
});

const hasMoreDocuments = computed(() => {
  return (
    hasDocuments.value &&
    (alcalde.value.plan_desarrollo?.documentos?.length || 0) > 3 &&
    !showAllDocuments.value
  );
});

// Métodos
/**
 * Formatea una fecha para mostrar en UI
 *
 * Prevención de errores:
 * - Manejo de valores nulos
 * - Validación de fechas inválidas
 * - Formato seguro para fechas
 */
const formatDate = (dateString: string | null): string => {
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

/**
 * Formatea fecha y hora para documentos
 *
 * Prevención de errores:
 * - Manejo de valores undefined
 * - Validación de fechas inválidas
 */
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

/**
 * Extrae el año de una fecha para el período
 *
 * Prevención de errores:
 * - Manejo de valores nulos/undefined
 * - Validación de fechas inválidas
 */
const periodoElecto = (fecha: string | null | undefined): string => {
  if (!fecha) return 'N/A';

  try {
    const date = new Date(fecha);
    return isNaN(date.getTime()) ? 'Año inválido' : date.getFullYear().toString();
  } catch (error) {
    console.error('Error al formatear año:', error);
    return 'N/A';
  }
};

/**
 * Traduce el género a formato legible
 *
 * Prevención de errores:
 * - Valor por defecto para entradas inesperadas
 */
const formatSexo = (sexo: string): string => {
  return sexo === 'masculino' ? 'Hombre' : sexo === 'femenino' ? 'Mujer' : 'No especificado';
};

/**
 * Genera URL completa para documentos
 *
 * Prevención de errores:
 * - Validación de path vacío
 * - Manejo de URLs mal formadas
 */
const getDocumentUrl = (path: string): string => {
  if (!path) return '#';

  try {
    return `${API_BASE_URL}/storage/${path}`;
  } catch (error) {
    console.error('Error generando URL de documento:', error);
    return '#';
  }
};

/**
 * Maneja errores de carga de imágenes
 *
 * Prevención de errores:
 * - Fallback a imagen por defecto
 */
const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement;
  img.src = defaultImage.value;
};

/**
 * Reintenta cargar datos después de un error
 *
 * Prevención de errores:
 * - Reset de estado de error
 * - Manejo de reintentos
 */
const retryLoading = async () => {
  error.value = null;
  loading.value = true;
  await loadAlcaldeData();
};

/**
 * Carga datos del alcalde desde API
 *
 * Prevención de errores:
 * - Validación de ID de ruta
 * - Manejo de diferentes estructuras de respuesta
 * - Asignación segura de datos
 */
const loadAlcaldeData = async () => {
  try {
    const id = Number(route.params.id);

    if (isNaN(id) || id <= 0) {
      throw new Error('ID de alcalde inválido');
    }

    const response = await getAlcaldeById(id);

    // Validar estructura básica de la respuesta
    if (!response?.data || typeof response.data !== 'object') {
      throw new Error('Estructura de datos inesperada');
    }

    // Normalizar estructura de plan_desarrollo
    let planDesarrollo = null;
    if (response.data.plan_desarrollo) {
      // Manejar diferentes formatos de respuesta
      if (Array.isArray(response.data.plan_desarrollo)) {
        planDesarrollo = response.data.plan_desarrollo[0] || null;
      } else if (typeof response.data.plan_desarrollo === 'object') {
        planDesarrollo = response.data.plan_desarrollo;
      }
    }

    // Asignación segura con valores por defecto
    alcalde.value = {
      id: response.data.id || 0,
      nombre_completo: response.data.nombre_completo || '',
      sexo: response.data.sexo || 'masculino',
      fecha_inicio: response.data.fecha_inicio || null,
      fecha_fin: response.data.fecha_fin || null,
      presentacion: response.data.presentacion || '',
      foto_path: response.data.foto_path || '',
      actual: Boolean(response.data.actual),
      plan_desarrollo: planDesarrollo,
      created_at: response.data.created_at,
      updated_at: response.data.updated_at,
    };
  } catch (err: unknown) {
    console.error('Error cargando detalles del alcalde:', err);

    // Manejo de errores amigable para el usuario
    error.value = 'Error al cargar los datos. ';

    if (err instanceof Error) {
      error.value += err.message || 'Por favor intente nuevamente.';
    } else {
      error.value += 'Por favor intente nuevamente.';
    }
  } finally {
    loading.value = false;
  }
};

// Ciclo de vida - Carga inicial de datos
onMounted(() => {
  loadAlcaldeData();
});
</script>

<style scoped>
/* Fuentes profesionales */
@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600&display=swap');

/* Variables de diseño */
:root {
  --border-radius: 0.75rem;
  --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  --transition: all 0.3s ease;
}

/* Estilos tipográficos */
.text-container {
  font-family: 'Open Sans', Arial, sans-serif;
  color: #343a40;
  font-size: 1rem;
  line-height: 1.6;
  letter-spacing: 0.02em;
}

.text-justify {
  text-align: justify;
  text-justify: inter-word;
  hyphens: auto;
}

h1,
h2,
h3,
h4,
h5 {
  font-family: 'Merriweather', serif;
  font-weight: 700;
  color: #212529;
  line-height: 1.3;
  margin-bottom: 0.75rem;
  letter-spacing: 0.03em;
}

/* Layout principal */
.container-xl {
  max-width: 1200px;
}

/* Sección Hero */
.hero-section {
  overflow: hidden;
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: var(--transition);
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.hero-section:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
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
  max-height: 300px;
  width: auto;
  object-fit: cover;
  border-radius: var(--border-radius);
}

/* Sección Plan de Desarrollo */
.development-plan {
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: var(--transition);
  background-color: #fff;
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
  background-color: #e8f4ff;
}

/* Tabla de documentos */
.table-borderless td,
.table-borderless th {
  border: none;
}

.document-icon-wrapper {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  background-color: rgba(220, 53, 69, 0.1);
  transition: transform 0.3s ease;
}

.document-icon-wrapper:hover {
  transform: scale(1.05);
}

.border-bottom {
  border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
}

/* Overlay de carga */
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
    flex-direction: column;
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

  h1 {
    font-size: 2rem;
  }
  h2 {
    font-size: 1.75rem;
  }
  h3 {
    font-size: 1.25rem;
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

  .text-container {
    font-size: 0.95rem;
    line-height: 1.5;
  }

  h1 {
    font-size: 1.8rem;
  }
  h2 {
    font-size: 1.5rem;
  }
  h3 {
    font-size: 1.2rem;
  }

  /* Optimización botones en móviles */
  .btn-sm .d-md-inline {
    display: none;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
  }

  .text-truncate {
    max-width: 100px !important;
  }
}
</style>

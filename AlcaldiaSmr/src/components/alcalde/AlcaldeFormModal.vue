<template>
  <BaseModal
  :model-value="show"
  @update:modelValue="emit('update:show', $event)"
  >
  <div v-if="errors.general" class="alert alert-danger">
  {{ errors.general[0] }}
</div>
    <div class="modal-content">
      <h2 class="modal-title">
        {{ isEdit ? "Editar Alcalde" : "Nuevo Alcalde" }}
      </h2>

      <form @submit.prevent="handleSubmit" class="form-grid">
        <!-- Sección 1: Información Básica -->
        <div class="form-section">
          <h3 class="section-title">Información Básica</h3>

          <div class="form-group">
            <label for="nombre_completo" class="form-label"
              >Nombre completo *</label
            >
            <input
              id="nombre_completo"
              v-model="form.nombre_completo"
              type="text"
              class="form-control"
              required
              :class="{ 'is-invalid': errors.nombre_completo }"
            />
            <div v-if="errors.nombre_completo" class="invalid-feedback">
              {{ errors.nombre_completo[0] }}
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="fecha_inicio" class="form-label"
                >Fecha inicio *</label
              >
              <input
                id="fecha_inicio"
                v-model="form.fecha_inicio"
                type="date"
                class="form-control"
                required
                :class="{ 'is-invalid': errors.fecha_inicio }"
              />
              <div v-if="errors.fecha_inicio" class="invalid-feedback">
                {{ errors.fecha_inicio[0] }}
              </div>
            </div>

            <div class="form-group">
              <label for="fecha_fin" class="form-label">Fecha fin</label>
              <input
                id="fecha_fin"
                v-model="form.fecha_fin"
                type="date"
                class="form-control"
                :min="form.fecha_inicio"
                :class="{ 'is-invalid': errors.fecha_fin }"
              />
              <div v-if="errors.fecha_fin" class="invalid-feedback">
                {{ errors.fecha_fin[0] }}
              </div>
            </div>
          </div>

          <div class="form-group form-check">
            <input
              id="actual"
              v-model="form.actual"
              type="checkbox"
              class="form-check-input"
              :class="{ 'is-invalid': errors.actual }"
            />
            <label for="actual" class="form-check-label">Alcalde actual</label>
            <div v-if="errors.actual" class="invalid-feedback">
              {{ errors.actual[0] }}
            </div>
          </div>
        </div>

        <!-- Sección 2: Presentación y Foto -->
        <div class="form-section">
          <div class="form-group">
            <label for="presentacion" class="form-label">Presentación</label>
            <textarea
              id="presentacion"
              v-model="form.presentacion"
              class="form-control"
              rows="4"
              :class="{ 'is-invalid': errors.presentacion }"
            ></textarea>
            <div v-if="errors.presentacion" class="invalid-feedback">
              {{ errors.presentacion[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="foto_path" class="form-label">Foto</label>
            <input
              id="foto_path"
              type="file"
              class="form-control"
              @change="handleFileUpload('foto_path', $event)"
              accept="image/*"
              :class="{ 'is-invalid': errors.foto_path }"
            />
            <div v-if="errors.foto_path" class="invalid-feedback">
              {{ errors.foto_path[0] }}
            </div>
            <div v-if="form.foto_path_url" class="mt-2">
              <img :src="form.foto_path_url" class="img-preview" />
            </div>
          </div>
        </div>

        <!-- Sección 3: Plan de Desarrollo -->
        <div class="form-section">
          <h3 class="section-title">Plan de Desarrollo</h3>

          <div class="form-group">
            <label for="titulo" class="form-label">Título *</label>
            <input
              id="titulo"
              v-model="form.titulo"
              type="text"
              class="form-control"
              required
              :class="{ 'is-invalid': errors.titulo }"
            />
            <div v-if="errors.titulo" class="invalid-feedback">
              {{ errors.titulo[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea
              id="descripcion"
              v-model="form.descripcion"
              class="form-control"
              rows="3"
              :class="{ 'is-invalid': errors.descripcion }"
            ></textarea>
            <div v-if="errors.descripcion" class="invalid-feedback">
              {{ errors.descripcion[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="document_path" class="form-label">Documento</label>
            <input
              id="document_path"
              type="file"
              class="form-control"
              @change="handleFileUpload('document_path', $event)"
              accept=".pdf,.doc,.docx"
              :class="{ 'is-invalid': errors.document_path }"
            />
            <div v-if="errors.document_path" class="invalid-feedback">
              {{ errors.document_path[0] }}
            </div>
            <div v-if="form.document_path_url" class="mt-2">
              <a
                :href="form.document_path_url"
                target="_blank"
                class="document-link"
              >
                <i class="fas fa-file-alt me-1"></i> Ver documento actual
              </a>
            </div>
          </div>
        </div>

        <!-- Acciones -->
        <div class="form-actions">
          <button
            type="button"
            class="btn btn-secondary"
            @click="close"
            :disabled="loading"
          >
            Cancelar
          </button>
          <button type="submit" class="btn btn-primary" :disabled="loading">
            <span
              v-if="loading"
              class="spinner-border spinner-border-sm me-1"
            ></span>
            {{ isEdit ? "Actualizar" : "Guardar" }}
          </button>
        </div>
      </form>
    </div>
  </BaseModal>
</template>

<script setup>
import { ref, watch } from "vue";
import { useAlcaldeStore } from "@/stores/alcaldeStore";
import api ,{ getPublicUrl } from "@/services/api";
import BaseModal from '@/components/alcalde/BaseModal.vue'; 


const props = defineProps({
  show: Boolean,
  alcalde: Object,
  isEdit: Boolean,
});

const emit = defineEmits(["update:show", "saved"]);

const store = useAlcaldeStore();
const loading = ref(false);
const errors = ref({});

const form = ref({
  nombre_completo: "",
  fecha_inicio: "",
  fecha_fin: "",
  presentacion: "",
  actual: false,
  foto_path: null,
  foto_path_url: null,
  titulo: "",
  descripcion: "",
  document_path: null,
  document_path_url: null,
});

watch(
  () => props.alcalde,
  (alcalde) => {
    if (props.isEdit && alcalde) {
      form.value = {
        nombre_completo: alcalde.nombre_completo || "",
        fecha_inicio: alcalde.fecha_inicio?.split("T")[0] || "",
        fecha_fin: alcalde.fecha_fin?.split("T")[0] || "",
        presentacion: alcalde.presentacion || "",
        actual: alcalde.actual || false,
        foto_path: null,
        foto_path_url: alcalde.foto_path
          ? getPublicUrl(alcalde.foto_path)
          : null,
        titulo: alcalde.plan_desarrollo?.titulo || "",
        descripcion: alcalde.plan_desarrollo?.descripcion || "",
        document_path: null,
        document_path_url: alcalde.plan_desarrollo?.document_path
          ? getPublicUrl(alcalde.plan_desarrollo.document_path)
          : null,
      };
    } else {
      resetForm();
    }
  },
  { immediate: true }
);

function resetForm() {
  form.value = {
    nombre_completo: "",
    fecha_inicio: "",
    fecha_fin: "",
    presentacion: "",
    actual: false,
    foto_path: null,
    foto_path_url: null,
    titulo: "",
    descripcion: "",
    document_path: null,
    document_path_url: null,
  };
  errors.value = {};
}

function handleFileUpload(field, event) {
  const file = event.target.files[0];
  if (file) {
    form.value[field] = file;
    if (field === "foto_path") {
      form.value.foto_path_url = URL.createObjectURL(file);
    }
  }
}

async function handleSubmit() {
  loading.value = true;
  errors.value = {};

  try {
    // Validación básica de campos requeridos
    if (!form.value.nombre_completo || !form.value.fecha_inicio || !form.value.titulo) {
      throw new Error('Faltan campos obligatorios');
    }

    const formData = new FormData();
    
    // Campos básicos
    formData.append('nombre_completo', form.value.nombre_completo);
    formData.append('fecha_inicio', form.value.fecha_inicio);
    formData.append('titulo', form.value.titulo);
    formData.append('actual', form.value.actual ? '1' : '0');

    // Campos opcionales
    if (form.value.fecha_fin) formData.append('fecha_fin', form.value.fecha_fin);
    if (form.value.presentacion) formData.append('presentacion', form.value.presentacion);
    if (form.value.descripcion) formData.append('descripcion', form.value.descripcion);

    // Manejo de archivos
    if (form.value.foto_path instanceof File) {
      formData.append('foto_path', form.value.foto_path);
    }

    if (form.value.document_path instanceof File) {
      formData.append('document_path', form.value.document_path);
    }

    // Configuración de headers
    const config = {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    };

    let response;
    
    if (props.isEdit) {
      // Para edición, usar PUT con FormData
      formData.append('_method', 'PUT');
      response = await api.post(`/alcaldes/${props.alcalde.id}`, formData, config);
    } else {
      // Para creación, POST normal
      response = await api.post('/alcaldes', formData, config);
    }

    if (response.status === 200 || response.status === 201) {
      emit('saved');
      close();
    }
  } catch (error) {
    console.error('Error en handleSubmit:', error);
    
    if (error.response?.data?.errors) {
      errors.value = error.response.data.errors;
    } else {
      // Manejo de errores genéricos
      errors.value.general = [error.message || 'Error al procesar la solicitud'];
    }
  } finally {
    loading.value = false;
  }
}


function close() {
  emit("update:show", false);
}
</script>

<style scoped>
.modal-content {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.modal-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.form-grid {
  display: grid;
  gap: 1.5rem;
}

.form-section {
  background: #f8f9fa;
  border-radius: 0.5rem;
  padding: 1.25rem;
}

.section-title {
  font-size: 1.1rem;
  font-weight: 500;
  color: #2c3e50;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #e9ecef;
}

.form-group {
  margin-bottom: 1rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #495057;
}

.form-control {
  width: 100%;
  padding: 0.5rem 0.75rem;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  border-color: #80bdff;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-input {
  margin-right: 0.5rem;
}

.form-check-label {
  user-select: none;
}

.invalid-feedback {
  width: 100%;
  margin-top: 0.25rem;
  font-size: 0.875rem;
  color: #dc3545;
}

.is-invalid {
  border-color: #dc3545;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}

.img-preview {
  max-width: 150px;
  max-height: 150px;
  border-radius: 0.25rem;
  border: 1px solid #dee2e6;
}

.document-link {
  display: inline-flex;
  align-items: center;
  color: #0d6efd;
  text-decoration: none;
}

.document-link:hover {
  text-decoration: underline;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  padding-top: 1rem;
  border-top: 1px solid #e9ecef;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-weight: 500;
  transition: all 0.15s ease;
  cursor: pointer;
}

.btn-primary {
  color: #fff;
  background-color: #0d6efd;
  border: 1px solid #0d6efd;
}

.btn-primary:hover {
  background-color: #0b5ed7;
  border-color: #0a58ca;
}

.btn-secondary {
  color: #212529;
  background-color: #e9ecef;
  border: 1px solid #dee2e6;
}

.btn-secondary:hover {
  background-color: #dde0e3;
  border-color: #d1d5d8;
}

.btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.spinner-border {
  vertical-align: text-bottom;
  border: 0.15em solid currentColor;
  border-right-color: transparent;
  border-radius: 50%;
  animation: spinner-border 0.75s linear infinite;
}

@keyframes spinner-border {
  to {
    transform: rotate(360deg);
  }
}
</style>

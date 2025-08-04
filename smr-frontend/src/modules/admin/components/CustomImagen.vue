<template>
  <div class="image-uploader-container p-3 border bg-light-subtle rounded-3">
    <!-- Vista previa de la imagen -->
    <div v-if="showPreview" class="image-preview mb-3">
      <img
        :src="currentImageUrl"
        alt="Vista previa de la imagen"
        class="img-fluid rounded border"
        style="max-height: 200px; object-fit: cover"
        @error="handleImageError"
      />
    </div>

    <!-- Zona de arrastrar y soltar -->
    <div
      v-if="!modelValue"
      class="drop-zone rounded border border-2 border-dashed p-4 text-center mb-2"
      :class="{ 'drag-active': isDragging }"
      @dragover.prevent="handleDragOver"
      @dragleave="handleDragLeave"
      @drop.prevent="handleDrop"
    >
      <i class="bi bi-cloud-arrow-up display-5 text-muted mb-2"></i>
      <p class="mb-1">Arrastra y suelta tu imagen aquí</p>
      <p class="small text-muted mb-0">o</p>

      <!-- Input de archivo oculto -->

      <input
        type="file"
        ref="fileInput"
        accept="image/jpeg, image/png, image/webp"
        class="d-none"
        @change="handleFileChange"
      />

      <button type="button" class="btn btn-primary mt-2" @click="triggerFileInput">
        <i class="bi bi-folder2-open me-2"></i>Seleccionar imagen
      </button>
    </div>

    <!-- Controles cuando hay imagen -->
    <div v-if="modelValue" class="image-controls d-flex gap-2">
      <button
        type="button"
        class="btn btn-outline-primary flex-grow-1"
        @click="triggerFileInput"
        :disabled="isUploading"
      >
        <i class="bi bi-arrow-repeat me-2"></i>Cambiar imagen
      </button>

      <button type="button" class="btn btn-danger" @click="removeImage" :disabled="isUploading">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>

    <!-- Información y validación -->
    <div class="upload-info mt-2">
      <small class="text-muted d-block">
        <i class="bi bi-info-circle me-1"></i>
        Formatos: JPG, PNG, WEBP (Máx. {{ maxSize }}MB)
      </small>

      <div v-if="error" class="error-message text-danger small mt-1">
        <i class="bi bi-exclamation-circle me-1"></i>
        {{ error }}
      </div>
    </div>

    <!-- Barra de progreso -->
    <div v-if="isUploading" class="upload-progress mt-2">
      <div class="progress" style="height: 8px">
        <div
          class="progress-bar progress-bar-striped progress-bar-animated"
          role="progressbar"
          :style="{ width: `${uploadProgress}%` }"
          :aria-valuenow="uploadProgress"
          aria-valuemin="0"
          aria-valuemax="100"
        ></div>
      </div>
      <small class="text-muted d-block text-center mt-1"> Subiendo: {{ uploadProgress }}% </small>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue';
import { apiConfig } from '@/api/apiConfig';
import type { AxiosError } from 'axios';

interface ImageUploadResponse {
  path: string;
  url?: string;
}

interface ApiErrorResponse {
  errors?: {
    [key: string]: string[];
  };
  message?: string;
}

const props = defineProps({
  modelValue: {
    type: String,

    default: '',
  },
  folder: {
    type: String,
    required: true,
    validator: (value: string) => {
      // Validación básica para nombres de carpeta
      return /^[a-z0-9_-]+\/[a-z0-9_-]+$/i.test(value);
    },
  },
  maxSize: {
    type: Number,
    default: 5,
    validator: (value: number) => value > 0 && value <= 10,
  },
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void;
  (e: 'upload-start'): void;
  (e: 'upload-complete'): void;
  (e: 'error', message: string): void;
}>();

// Referencias reactivas
const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(null);
const isUploading = ref(false);
const uploadProgress = ref(0);
const error = ref<string | null>(null);
const isDragging = ref(false);

// Constantes de configuración
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || '';
const API_STORAGE_URL = `${API_BASE_URL}/storage`;
const VALID_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

// Computed properties
const currentImageUrl = computed(() => {
  if (previewUrl.value) return previewUrl.value;
  if (!props.modelValue) return '';

  return props.modelValue.startsWith('http')
    ? props.modelValue
    : `${API_STORAGE_URL}/${props.modelValue}`;
});

const showPreview = computed(() => {
  return !!previewUrl.value || !!props.modelValue;
});

// Watchers
watch(
  () => props.modelValue,
  (newValue) => {
    if (!newValue) {
      previewUrl.value = null;
    }
  },
);

// Métodos
const triggerFileInput = () => {
  fileInput.value?.click();
};

const handleDragOver = (e: DragEvent) => {
  e.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = () => {
  isDragging.value = false;
};

const handleDrop = (e: DragEvent) => {
  e.preventDefault();
  isDragging.value = false;

  const files = e.dataTransfer?.files;
  if (files?.length) {
    handleFile(files[0]);
  }
};

const handleFileChange = (e: Event) => {
  const input = e.target as HTMLInputElement;
  if (input.files?.length) {
    handleFile(input.files[0]);
  }
};

const handleFile = (file: File) => {
  resetUploadState();

  // Validación de tipo
  if (!VALID_MIME_TYPES.includes(file.type)) {
    setError('Formato no soportado. Use JPG, PNG o WEBP');
    return;
  }

  // Validación de tamaño
  if (file.size > props.maxSize * 1024 * 1024) {
    setError(`El archivo excede el límite de ${props.maxSize}MB`);
    return;
  }

  // Crear vista previa
  previewUrl.value = URL.createObjectURL(file);

  // Iniciar subida
  uploadFile(file);
};

const uploadFile = async (file: File) => {
  isUploading.value = true;
  uploadProgress.value = 0;
  emit('upload-start');

  try {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('folder', props.folder);

    const response = await apiConfig.post<ImageUploadResponse>('/uploads', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress: (progressEvent) => {
        if (progressEvent.total) {
          uploadProgress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        }
      },
    });

    if (response.data.path) {
      emit('update:modelValue', response.data.path);
    }
  } catch (err) {
    handleUploadError(err as AxiosError);
  } finally {
    isUploading.value = false;
    emit('upload-complete');
  }
};

const handleUploadError = (error: AxiosError) => {
  let errorMessage = 'Error al subir la imagen';

  // Cast seguro a nuestro tipo definido
  const errorData = error.response?.data as ApiErrorResponse;

  if (error.response) {
    switch (error.response.status) {
      case 404:
        errorMessage = 'Endpoint no encontrado. Verifique la URL.';
        break;
      case 413:
        errorMessage = 'El archivo es demasiado grande';
        break;
      case 422:
        if (errorData.errors?.foto_path) {
          errorMessage = errorData.errors.foto_path.join(', ');
        } else {
          errorMessage = errorData.message || 'Datos de formulario inválidos';
        }
        break;
      case 401:
        errorMessage = 'No autorizado. Por favor inicie sesión.';
        break;
      default:
        errorMessage = errorData.message || `Error del servidor (${error.response.status})`;
    }
  } else if (error.request) {
    errorMessage = 'No se recibió respuesta del servidor';
  }

  setError(errorMessage);
  previewUrl.value = null;
};

const removeImage = () => {
  resetUploadState();
  emit('update:modelValue', '');
  if (fileInput.value) fileInput.value.value = '';
};

const handleImageError = () => {
  setError('Error al cargar la imagen');
  previewUrl.value = null;
};

const setError = (message: string) => {
  error.value = message;
  emit('error', message);
  setTimeout(() => (error.value = null), 5000);
};

const resetUploadState = () => {
  if (previewUrl.value) {
    URL.revokeObjectURL(previewUrl.value);
    previewUrl.value = null;
  }
  error.value = null;
  uploadProgress.value = 0;
};
</script>

<style scoped>
.image-uploader-container {
  transition: all 0.3s ease;
}

.drop-zone {
  transition: all 0.3s;
  background-color: rgba(13, 110, 253, 0.02);
  cursor: pointer;
}

.drop-zone.drag-active {
  background-color: rgba(13, 110, 253, 0.05);
  border-color: #0d6efd;
  transform: scale(1.01);
}

.image-preview img {
  transition: opacity 0.3s;
}

.image-preview img:hover {
  opacity: 0.9;
}

.error-message {
  animation: fadeIn 0.3s;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.upload-progress {
  animation: slideUp 0.3s;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<template>
  <div class="document-uploader mb-4">
    <!-- Título accesible -->
    <label class="form-label fw-bold mb-2">
      <i class="bi bi-file-earmark me-2"></i>{{ label }}
    </label>

    <!-- Documentos existentes -->
    <div v-if="existingDocs.length" class="mb-3">
      <h6 class="fw-bold mb-2">Documentos existentes:</h6>
      <ul class="list-group list-group-flush">
        <li
          v-for="(doc, index) in existingDocs"
          :key="`existing-${doc.id || index}`"
          class="list-group-item d-flex justify-content-between align-items-center"
        >
          <div>
            <i :class="getIcon(doc.nombre)" class="me-2 text-primary"></i>
            <a :href="getDocumentUrl(doc.path)" target="_blank" class="text-decoration-none">
              {{ truncate(doc.nombre, 30) }}
            </a>
          </div>
          <button
            type="button"
            class="btn btn-sm btn-primary"
            @click="removeExisting(index)"
            :disabled="isUploading"
            :aria-label="`Eliminar documento ${doc.nombre}`"
          >
            <i class="fas fa-trash-alt"></i>
          </button>
        </li>
      </ul>
    </div>

    <!-- Selector de archivos -->
    <div class="mb-3">
      <input
        ref="fileInput"
        type="file"
        multiple
        class="form-control"
        :disabled="isUploading"
        @change="handleFiles"
      />
      <div class="form-text">Formatos permitidos: PDF, Word, Excel, PowerPoint, imágenes</div>
    </div>

    <!-- Barra de progreso -->
    <div v-if="isUploading" class="upload-progress mt-3">
      <div class="d-flex justify-content-between small mb-1">
        <span>Subiendo {{ currentFileName }}...</span>
        <span>{{ uploadProgress }}%</span>
      </div>
      <div
        class="progress"
        role="progressbar"
        :aria-valuenow="uploadProgress"
        aria-valuemin="0"
        aria-valuemax="100"
      >
        <div
          class="progress-bar progress-bar-striped progress-bar-animated"
          :style="{ width: uploadProgress + '%' }"
        ></div>
      </div>
    </div>

    <!-- Archivos nuevos -->
    <ul v-if="fileList.length" class="list-group list-group-flush mt-2">
      <li
        v-for="(file, idx) in fileList"
        :key="`new-${idx}`"
        class="list-group-item d-flex justify-content-between align-items-center"
      >
        <div class="d-flex align-items-center">
          <i :class="'me-2 text-primary ' + getIcon(file.nombre)"></i>
          <span class="file-name">{{ truncate(file.nombre, 25) }}</span>
          <small class="text-muted ms-2">{{ formatFileSize(file.size || 0) }}</small>
        </div>
        <button
          type="button"
          class="btn btn-sm btn-danger"
          @click="removeFile(idx)"
          :disabled="isUploading"
        >
          <i class="fas fa-trash-alt"></i>
        </button>
      </li>
    </ul>

    <!-- Mensajes de error -->
    <div v-if="errorMsg" class="alert alert-danger small mt-2 mb-3">
      <i class="fas fa-exclamation-circle me-2"></i>{{ errorMsg }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { apiConfig } from '@/api/apiConfig';

interface Documento {
  id?: number;
  nombre: string;
  path: string;
  size?: number;
}

const props = withDefaults(
  defineProps<{
    modelValue?: Documento[];
    label?: string;
    folder: string;
    maxSize?: number;
    existingDocs?: Documento[];
    resetKey?: number;
  }>(),
  {
    modelValue: () => [],
    label: 'Documentos',
    maxSize: 10,
    existingDocs: () => [],
    resetKey: 0,
  },
);

const emit = defineEmits<{
  (e: 'update:modelValue', docs: Documento[]): void;
  (e: 'remove-existing-doc', id: number): void;
}>();

// Estado del componente
const fileList = ref<Documento[]>([]);
const fileInput = ref<HTMLInputElement | null>(null);
const isUploading = ref(false);
const uploadProgress = ref(0);
const currentFileName = ref('');
const errorMsg = ref('');

// Tipos MIME permitidos
const ALLOWED_MIME_TYPES = [
  'application/pdf',
  'application/msword',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/vnd.ms-excel',
  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  'application/vnd.ms-powerpoint',
  'application/vnd.openxmlformats-officedocument.presentationml.presentation',
  'image/jpeg',
  'image/png',
  'image/gif',
  'text/plain',
];

// Obtener icono según extensión
const getIcon = (filename: string) => {
  const ext = filename.split('.').pop()?.toLowerCase();
  const iconMap: Record<string, string> = {
    pdf: 'far fa-file-pdf',
    doc: 'far fa-file-word',
    docx: 'far fa-file-word',
    xls: 'far fa-file-excel',
    xlsx: 'far fa-file-excel',
    ppt: 'far fa-file-powerpoint',
    pptx: 'far fa-file-powerpoint',
    jpg: 'far fa-file-image',
    jpeg: 'far fa-file-image',
    png: 'far fa-file-image',
    gif: 'far fa-file-image',
    svg: 'far fa-file-image',
    txt: 'far fa-file-alt',
    zip: 'far fa-file-archive',
    rar: 'far fa-file-archive',
    '7z': 'far fa-file-archive',
    mp3: 'far fa-file-audio',
    wav: 'far fa-file-audio',
    ogg: 'far fa-file-audio',
    mp4: 'far fa-file-video',
    avi: 'far fa-file-video',
    mov: 'far fa-file-video',
    mkv: 'far fa-file-video',
    csv: 'far fa-file-csv',
    html: 'far fa-file-code',
    htm: 'far fa-file-code',
  };

  return iconMap[ext || ''] || 'far fa-file';
};

const truncate = (text: string, length: number) =>
  text.length > length ? `${text.substring(0, length)}...` : text;

const formatFileSize = (bytes: number) => {
  if (bytes === 0) return '0 Bytes';
  const k = 1024;
  const sizes = ['Bytes', 'KB', 'MB', 'GB'];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return `${parseFloat((bytes / Math.pow(k, i)).toFixed(2))} ${sizes[i]}`;
};

const getDocumentUrl = (path: string) =>
  path.startsWith('http') ? path : `${import.meta.env.VITE_API_BASE_URL}/storage/${path}`;

const validateFile = (file: File): boolean => {
  const maxBytes = props.maxSize * 1024 * 1024;
  const extension = file.name.split('.').pop()?.toUpperCase() || '';

  if (file.size > maxBytes) {
    errorMsg.value = `"${file.name}" excede el tamaño máximo de ${props.maxSize}MB`;
    return false;
  }

  if (!ALLOWED_MIME_TYPES.includes(file.type)) {
    errorMsg.value = `Tipo de archivo no permitido (${extension}): ${file.name}`;
    return false;
  }

  errorMsg.value = '';
  return true;
};

const uploadSingleFile = async (file: File, onProgress: (progress: number) => void) => {
  const formData = new FormData();
  formData.append('file', file);
  formData.append('folder', props.folder);

  try {
    const response = await apiConfig.post('/uploads', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
      onUploadProgress: (progressEvent) => {
        if (progressEvent.total) {
          const progress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
          onProgress(progress);
        }
      },
    });

    if (response.status === 201) {
      return {
        nombre: file.name,
        path: response.data.path || response.data.url,
        size: file.size,
      };
    }
    throw new Error('Error al subir archivo');
  } catch (error) {
    console.error('Upload error:', error);
    errorMsg.value = 'Error al subir el archivo. Intente nuevamente.';
    return null;
  }
};

const uploadFiles = async (files: File[]) => {
  isUploading.value = true;
  const uploadedFiles: Documento[] = [];

  // Filtrar archivos válidos
  const validFiles = files.filter((file) => {
    const isValid = validateFile(file);
    if (!isValid) {
      return false;
    }
    return true;
  });

  if (validFiles.length === 0) {
    isUploading.value = false;
    return;
  }

  // Subir archivos secuencialmente
  for (const file of validFiles) {
    currentFileName.value = file.name;
    uploadProgress.value = 0;

    try {
      const uploadedDoc = await uploadSingleFile(file, (progress) => {
        uploadProgress.value = progress;
      });

      if (uploadedDoc) {
        uploadedFiles.push(uploadedDoc);
      }
    } catch (error) {
      console.error('Error uploading file:', error);
    }
  }

  // Actualizar solo archivos nuevos
  if (uploadedFiles.length > 0) {
    fileList.value = [...fileList.value, ...uploadedFiles];
    emitChanges();
  }

  isUploading.value = false;
  uploadProgress.value = 0;
  currentFileName.value = '';
};

const handleFiles = async (event: Event) => {
  const input = event.target as HTMLInputElement;
  if (!input.files?.length) return;

  errorMsg.value = '';
  await uploadFiles(Array.from(input.files));

  // Resetear input para permitir nueva selección
  if (input) input.value = '';
};

const removeFile = (index: number) => {
  fileList.value.splice(index, 1);
  emitChanges();
};

const removeExisting = (index: number) => {
  const doc = props.existingDocs[index];
  if (doc.id) {
    emit('remove-existing-doc', doc.id);
  }
};

// Emitir cambios al padre
const emitChanges = () => {
  // Combinar existentes con nuevos
  const allDocs = [...props.existingDocs, ...fileList.value];
  emit('update:modelValue', allDocs);
};

// Sincronización inicial y con cambios de resetKey
watch(
  () => [props.modelValue, props.resetKey],
  ([newValue]) => {
    // Filtrar solo documentos sin ID (nuevos)
    const existingPaths = props.existingDocs.map((doc) => doc.path);
    fileList.value = Array.isArray(newValue)
      ? newValue.filter((doc) => !doc.id && !existingPaths.includes(doc.path))
      : [];
  },
  { immediate: true, deep: true },
);
</script>

<style scoped>
/* Estilos anteriores se mantienen igual */
</style>

<style scoped>
.document-uploader {
  position: relative;
}

.list-group-item {
  font-size: 0.9rem;
  padding: 0.75rem 1.25rem;
}

.file-name {
  max-width: 200px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.upload-progress {
  background: #f8f9fa;
  border-radius: 0.25rem;
  padding: 0.75rem;
}

@media (max-width: 768px) {
  .file-name {
    max-width: 120px;
  }
}
</style>

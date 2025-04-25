<template>
  <form @submit.prevent="submitForm" enctype="multipart/form-data">
    <!-- Nombre Completo -->
    <div class="mb-3">
      <label class="form-label">Nombre Completo</label>
      <input type="text" class="form-control" v-model="form.nombre_completo" required />
    </div>

    <!-- Cargo -->
    <div class="mb-3">
      <label class="form-label">Cargo</label>
      <input type="text" class="form-control" v-model="form.cargo" required />
    </div>

    <!-- Fecha Inicio -->
    <div class="mb-3">
      <label class="form-label">Fecha Inicio</label>
      <input type="date" class="form-control" v-model="form.fecha_inicio" required />
    </div>

    <!-- Fecha Fin -->
    <div class="mb-3">
      <label class="form-label">Fecha Fin</label>
      <input type="date" class="form-control" v-model="form.fecha_fin" />
    </div>

    <!-- ¿Es Actual? -->
    <div class="mb-3">
      <label class="form-label">¿Es el Alcalde Actual?</label>
      <select class="form-select" v-model="form.actual">
        <option :value="true">Sí</option>
        <option :value="false">No</option>
      </select>
    </div>

    <!-- Objetivo / Presentación -->
    <div class="mb-3">
      <label class="form-label">Presentación / Objetivo</label>
      <textarea class="form-control" rows="4" v-model="form.objetivo" placeholder="Descripción u objetivo del alcalde..."></textarea>
    </div>

    <!-- Foto del Alcalde -->
    <div class="mb-3">
      <label class="form-label">Foto del Alcalde</label>
      <input type="file" class="form-control" @change="handleFileChange($event, 'foto')" accept="image/*" />

      <!-- Miniatura de foto existente -->
      <div v-if="fotoPreview" class="mt-2">
        <img :src="fotoPreview" class="img-thumbnail" style="max-width: 180px;" />
      </div>
    </div>

    <!-- Plan de Desarrollo -->
    <div class="mb-3">
      <label class="form-label">Plan de Desarrollo (PDF o DOC)</label>
      <input type="file" class="form-control" @change="handleFileChange($event, 'plan')" accept=".pdf,.doc,.docx" />

      <!-- Enlace al documento existente -->
      <div v-if="form.planDesarrolloUrl" class="mt-2">
        <a :href="form.planDesarrolloUrl" target="_blank" class="btn btn-outline-primary btn-sm">Ver documento actual</a>
      </div>
    </div>

    <!-- Botones -->
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-success me-2">Guardar</button>
      <button type="button" class="btn btn-secondary" @click="$emit('cancel')">Cancelar</button>
    </div>
  </form>
</template>

<script setup>
import { ref, reactive, watch, defineProps, defineEmits } from 'vue';

const emit = defineEmits(['save', 'cancel']);
const props = defineProps({ modelValue: Object });

// Formulario reactivo
const form = reactive({
  nombre_completo: '',
  cargo: '',
  fecha_inicio: '',
  fecha_fin: '',
  actual: false,
  objetivo: '',
  foto: null,
  plan_desarrollo: null,
  fotoUrl: '',              // Para edición
  planDesarrolloUrl: ''     // Para edición
});

const fotoPreview = ref('');

// Cargar datos si estamos en edición
watch(
  () => props.modelValue,
  (newVal) => {
    if (newVal) {
      Object.assign(form, {
        ...newVal,
        fecha_inicio: newVal.fecha_inicio?.slice(0, 10) || '',
        fecha_fin: newVal.fecha_fin?.slice(0, 10) || '',
        fotoUrl: newVal.foto?.ruta_publica || '',
        planDesarrolloUrl: newVal.plan_desarrollo?.ruta_publica || ''
      });
      fotoPreview.value = form.fotoUrl;
    }
  },
  { immediate: true }
);

// Manejar archivos
function handleFileChange(event, tipo) {
  const archivo = event.target.files[0];
  if (!archivo) return;

  if (tipo === 'foto') {
    form.foto = archivo;
    fotoPreview.value = URL.createObjectURL(archivo); // Vista previa temporal
  }

  if (tipo === 'plan') {
    form.plan_desarrollo = archivo;
  }
}

// Preparar datos para envío
function submitForm() {
  const formData = new FormData();
  for (const key in form) {
    if (
      form[key] !== null &&
      typeof form[key] !== 'function' &&
      !key.endsWith('Url') // evitar enviar URLs
    ) {
      formData.append(key, form[key]);
    }
  }
  emit('save', formData);
}
</script>

<template>
  <BaseModal
    :model-value="show"
    @update:modelValue="emit('update:show', $event)"
  >
    <div class="modal-content">
      <h2 class="modal-title">Detalle del Alcalde</h2>

      <div class="alcalde-header">
        <div v-if="fotoUrl" class="alcalde-photo">
          <img :src="fotoUrl" alt="Foto del alcalde" class="photo-img" />
        </div>
        <div class="alcalde-info">
          <h3 class="alcalde-name">{{ alcalde?.nombre_completo || "—" }}</h3>
          <div class="alcalde-status">
            <span
              :class="['status-badge', alcalde?.actual ? 'active' : 'inactive']"
            >
              {{ alcalde?.actual ? "Activo" : "Inactivo" }}
            </span>
          </div>
        </div>
      </div>

      <div class="detail-item">
        <span class="detail-label">Fecha de inicio</span>
        <span class="detail-value">{{
          alcalde?.fecha_inicio ? extractYear(alcalde.fecha_inicio) : "Actual"
        }}</span>
      </div>
      <div class="detail-item">
        <span class="detail-label">Fecha de fin</span>
        <span class="detail-value">{{
          alcalde?.fecha_fin ? extractYear(alcalde.fecha_fin) : "Actual"
        }}</span>
      </div>

      <div v-if="alcalde?.presentacion" class="detail-section">
        <h3 class="section-title">Presentación</h3>
        <div class="presentation-content">
          {{ alcalde.presentacion }}
        </div>
      </div>

      <div v-if="alcalde?.plan_desarrollo" class="detail-section">
        <h3 class="section-title">Plan de Desarrollo</h3>
        <div class="detail-grid">
          <div class="detail-item">
            <span class="detail-label">Título</span>
            <span class="detail-value">{{
              alcalde.plan_desarrollo.titulo || "—"
            }}</span>
          </div>
          <div class="detail-item full-width">
            <span class="detail-label">Descripción</span>
            <span class="detail-value">{{
              alcalde.plan_desarrollo.descripcion || "—"
            }}</span>
          </div>
          <div v-if="documentoUrl" class="detail-item full-width">
            <span class="detail-label">Documento</span>
            <a :href="documentoUrl" target="_blank" class="document-link">
              <i class="fas fa-file-download me-1"></i> Descargar documento
            </a>
          </div>
        </div>
      </div>

      <div class="modal-actions">
        <button @click="close" class="btn btn-close">Cerrar</button>
      </div>
    </div>
  </BaseModal>
</template>

<script setup>
import { computed } from "vue";
import { getPublicUrl } from "@/services/api";
import BaseModal from "@/components/alcaldia/admin/BaseModal.vue";
import { parse, getYear } from "date-fns";

const props = defineProps({
  show: Boolean,
  alcalde: Object,
});

const emit = defineEmits(["update:show"]);

const fotoUrl = computed(() =>
  props.alcalde?.foto_path ? getPublicUrl(props.alcalde.foto_path) : null
);

const documentoUrl = computed(() =>
  props.alcalde?.plan_desarrollo?.document_path
    ? getPublicUrl(props.alcalde.plan_desarrollo.document_path)
    : null
);

function close() {
  emit("update:show", false);
}

const extractYear = (dateString) => {
  const extractYear = (dateString) => {
    if (!dateString) return "—";

    try {
      // Parsear formatos complejos usando patrones
      const date = parse(
        dateString.replace(/MHz|"|\|/g, "").trim(), // Limpieza
        "yyyy-MM-dd HH:mm:ss", // Patrón esperado
        new Date()
      );

      return getYear(date).toString();
    } catch (error) {
      console.error("Error parsing date:", dateString);
      return "—";
    }
  };
};
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

.alcalde-header {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e9ecef;
}

.alcalde-photo {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  overflow: hidden;
  border: 3px solid #f8f9fa;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.photo-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.alcalde-info {
  flex: 1;
}

.alcalde-name {
  font-size: 1.25rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 0.5rem;
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
  color: #5f5d5d;
}
.detail-section {
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

.detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1rem;
}

.detail-item {
  display: flex;
  flex-direction: column;
}

.detail-item.full-width {
  grid-column: 1 / -1;
}

.detail-label {
  font-size: 0.875rem;
  font-weight: 500;
  color: #6c757d;
  margin-bottom: 0.25rem;
}

.detail-value {
  font-size: 1rem;
  color: #212529;
}

.presentation-content {
  white-space: pre-line;
  line-height: 1.6;
}

.document-link {
  display: inline-flex;
  align-items: center;
  color: #0d6efd;
  text-decoration: none;
  padding: 0.375rem 0.75rem;
  border-radius: 0.25rem;
  background-color: #f8f9fa;
  border: 1px solid #dee2e6;
}

.document-link:hover {
  background-color: #e9ecef;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
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

.btn-close {
  color: #212529;
  background-color: #e9ecef;
  border: 1px solid #dee2e6;
}

.btn-close:hover {
  background-color: #dde0e3;
  border-color: #d1d5d8;
}
</style>

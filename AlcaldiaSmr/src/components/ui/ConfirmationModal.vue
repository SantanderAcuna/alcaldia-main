<template>
  <BaseModal :model-value="show" @update:modelValue="emit('update:show', $event)">
    <div class="confirmation-modal">
      <h3 class="modal-title">{{ title }}</h3>
      <p class="modal-message">{{ message }}</p>
      <div class="modal-actions">
        <button @click="cancel" class="btn btn-secondary">Cancelar</button>
        <button @click="confirm" class="btn btn-danger">Confirmar</button>
      </div>
    </div>
  </BaseModal>
</template>

<script setup>
import BaseModal from '@/components/alcalde/BaseModal.vue';

const props = defineProps({
  show: Boolean,
  title: {
    type: String,
    default: 'Confirmación'
  },
  message: {
    type: String,
    required: true
  }
});

const emit = defineEmits(['update:show', 'confirm']);

const confirm = () => {
  emit('confirm');
  emit('update:show', false);
};

const cancel = () => {
  emit('update:show', false);
};
</script>

<style scoped>
.confirmation-modal {
  padding: 1.5rem;
  max-width: 500px;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: #2c3e50;
}

.modal-message {
  margin-bottom: 1.5rem;
  color: #495057;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-secondary {
  background-color: #e9ecef;
  border: 1px solid #dee2e6;
  color: #212529;
}

.btn-danger {
  background-color: #00568d;
  border: 1px solid #00568d;
  color: white;
}

.btn-danger:hover {
  background-color: #00568d;
  border-color: #00568d;
}
</style>
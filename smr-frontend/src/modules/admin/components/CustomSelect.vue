<template>
  <div>
    <select
      ref="sel"
      :value="modelValue"
      @change="$emit('update:modelValue', ($event.target as HTMLSelectElement).value)"
      @blur="onBlur"
      required
      :class="['form-select', { 'is-invalid': touched && error }]"
    >
      <option value="" disabled>Seleccionar..</option>
      <option value="Masculino">Masculino</option>
      <option value="Femenino">Femenino</option>
      <option value="Otro">Otro</option>
    </select>
    <div class="invalid-feedback" v-if="touched && error">
      {{ error }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

interface Props {
  modelValue: string | number;
  error?: string;
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'update:modelValue', val: string | number): void;
  (e: 'blur'): void;
}>();

const touched = ref(false);
const sel = ref<HTMLSelectElement>();

function onBlur() {
  touched.value = true;
  // validación nativa
  if (sel.value?.validity.valueMissing) {
    // aquí podrías asignar un mensaje genérico si quisieras
  }
  emit('blur');
}
</script>

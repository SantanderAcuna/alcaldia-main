<template>
  <label class="form-label">{{ label }}</label>
  <input
    ref="inp"
    :type="type"
    :value="displayValue"
    @input="onInput"
    @blur="handleBlur"
    :class="['form-control', 'form-control-md', { 'is-invalid': !!error }]"
  />
  <div v-if="error" class="invalid-feedback">
    {{ error }}
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';

interface Props {
  modelValue?: string | Date;
  error?: string;
  type?: 'text' | 'number' | 'date';
  label: string;
}

const props = withDefaults(defineProps<Props>(), { type: 'date' });

const emit = defineEmits<{
  (e: 'update:modelValue', v: string | Date): void;
  (e: 'blur'): void;
}>();

/** Ref al input nativo (útil si en algún momento quieres validar nativamente). */
const inp = ref<HTMLInputElement | null>(null);

/** Formato que el `<input type="date">` entiende: `YYYY-MM-DD`. */
const displayValue = computed<string>(() => {
  if (props.type !== 'date') return String(props.modelValue ?? '');
  if (props.modelValue instanceof Date) return props.modelValue.toISOString().slice(0, 10);
  return String(props.modelValue ?? '');
});

function onInput(e: Event) {
  const raw = (e.target as HTMLInputElement).value;

  // ──> Devolvemos un Date al padre para mantener el tipo coherente
  if (props.type === 'date') {
    const [y, m, d] = raw.split('-').map(Number);
    emit('update:modelValue', new Date(y, m - 1, d));
  } else {
    emit('update:modelValue', raw);
  }
}

function handleBlur() {
  emit('blur');
}
</script>

<style scoped>
/* Sutileza visual: icono de calendario más neutro en modo oscuro */
input[type='date']::-webkit-calendar-picker-indicator {
  filter: invert(0.5);
}
</style>

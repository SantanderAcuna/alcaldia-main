<template>
  <label class="form-label">{{ label }}</label>
  <input
    :type="type"
    :value="modelValue"
    @input="$emit('update:modelValue', ($event.target as HTMLSelectElement)?.value ?? '')"
    @blur="$emit('blur')"
    :class="['form-control', 'form-control-md', { 'is-invalid': error }]"
  />
  <div class="invalid-feedback" error>
    {{ error }}
  </div>
</template>
<script setup lang="ts">
interface Props {
  modelValue?: string | number;
  error?: string;
  type?: 'text' | 'number';
  label: string;
}

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = withDefaults(defineProps<Props>(), {
  type: 'text',
});

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number): void;
  (e: 'blur'): void;
}>();
</script>

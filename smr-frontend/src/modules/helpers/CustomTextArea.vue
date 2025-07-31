<template>
  <div class="mb-4">
    <label class="form-label">{{ label }}</label>
    <textarea
      :type="type"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement)?.value ?? '')"
      @blur="$emit('blur')"
      :class="['form-control', 'form-control-md', { 'is-invalid': error }]"
      rows="3"
    ></textarea>
    <div class="invalid-feedback" error>
      {{ error }}
    </div>
  </div>
</template>
<script setup lang="ts">
interface Props {
  modelValue?: string | number;
  error?: string;
  label: string;
  type?: 'text' | 'number';
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

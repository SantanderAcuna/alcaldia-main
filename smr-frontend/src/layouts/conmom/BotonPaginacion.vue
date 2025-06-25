<template>
  <div class="d-flex justify-content-center py-5 gap-3 bg-light">
    <!-- Botón Anterior -->
    <button
      :disabled="page === 1"
      @click.prevent="$router.push({ query: { page: page - 1 } })"
      class="btn btn-primary d-flex align-items-center gap-2 py-2 px-4"
      style="min-width: 120px"
    >
      <ArrowLeft />
      <span>Anteriores</span>
    </button>

    <!-- Botón Siguiente -->
    <button
      :disabled="hasMoreData"
      @click.prevent="$router.push({ query: { page: page + 1 } })"
      class="btn btn-primary d-flex align-items-center gap-2 py-2 px-4"
      style="min-width: 120px"
    >
      <span>Siguientes</span>
      <ArrowRight />
    </button>
  </div>
</template>

<script setup lang="ts">
import ArrowLeft from '@/layouts/icons/ArrowLeft.vue';
import ArrowRight from '@/layouts/icons/ArrowRight.vue';

interface Props {
  page: number;
  hasMoreData: boolean;
}

defineProps<Props>();
</script>

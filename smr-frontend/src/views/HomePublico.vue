<template>
  <router-view />
  <VueQueryDevtools />
  <CarruselNab v-if="isHomePage" />

  <TramiteServicios v-if="isHomePage" />
  <Noticias v-if="isHomePage" />
  <Documentos v-if="isHomePage" />
</template>
<script lang="ts" setup>
import { computed } from 'vue';

import { useRouter } from 'vue-router';

import { VueQueryDevtools } from '@tanstack/vue-query-devtools';

const router = useRouter();

const isHomePage = computed(() => router.currentRoute.value.path === '/');

console.log(isHomePage);

// ✅ Importación de componentes usados en el template
import CarruselNab from '@/layouts/components/CarruselNab.vue';
import TramiteServicios from '@/layouts/components/TramiteServicios.vue';

import Documentos from '@/layouts/components/Documentos.vue';

import Noticias from '@/layouts/components/Noticias.vue';
</script>

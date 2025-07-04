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
import CarruselNab from '@/modules/publico/layouts/components/CarruselNab.vue';
import TramiteServicios from '@/modules/publico/layouts/components/TramiteServicio.vue';

import Documentos from '@/modules/publico/layouts/components/Documentos.vue';

import Noticias from '@/modules/publico/layouts/components/Noticias.vue';
</script>

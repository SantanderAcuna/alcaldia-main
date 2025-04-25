<template>
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">{{ alcalde.nombre_completo }}</h5>
        <p><strong>Cargo:</strong> {{ alcalde.cargo }}</p>
        <p><strong>Inicio:</strong> {{ formatDate(alcalde.fecha_inicio) }}</p>
        <p><strong>Fin:</strong> {{ alcalde.fecha_fin ? formatDate(alcalde.fecha_fin) : 'N/A' }}</p>
        <p><strong>Actual:</strong> {{ alcalde.actual ? 'Sí' : 'No' }}</p>
        <p><strong>Objetivo:</strong> {{ alcalde.objetivo }}</p>
  
        <div v-if="alcalde.foto?.ruta_publica">
          <strong>Foto:</strong><br />
          <img :src="alcalde.foto.ruta_publica" class="img-thumbnail" width="200" />
        </div>
  
        <div v-if="alcalde.plan_desarrollo?.ruta_publica" class="mt-2">
          <strong>Plan de Desarrollo:</strong>
          <a :href="alcalde.plan_desarrollo.ruta_publica" target="_blank">Ver Documento</a>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from "vue";
  import dayjs from "dayjs";
  import "dayjs/locale/es";
  dayjs.locale("es");
  
  const props = defineProps({ alcalde: Object });
  const formatDate = (date) => dayjs(date).format("D [de] MMMM [de] YYYY");
  </script>
  
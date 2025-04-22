<template>
    <section>
      <h1>Listado de Alcaldes</h1>
      <div v-if="loading">Cargando...</div>
      <ul v-else>
        <li v-for="a in alcaldes" :key="a.id">
          {{ a.nombre_completo }} — {{ a.cargo }}
        </li>
      </ul>
    </section>
  </template>
  
  <script setup>
  import { onMounted } from 'vue'
  import { useAlcaldePublicoStore } from '@/store/Publico/indexPublico'
  
  const store = useAlcaldePublicoStore()
  const { alcaldes, loading } = store
  
  onMounted(() => {
    store.fetchAlcaldes()
  })
  </script>
  
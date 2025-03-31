<template>
    <div class="pqrsd-container">
      <h2>Lista de PQRSD</h2>
      <ul>
        <li v-for="pqrsd in pqrsds" :key="pqrsd.id">
          <p><strong>{{ pqrsd.tipo }}</strong> - {{ pqrsd.descripcion }}</p>
          <router-link :to="'/pqrsds/' + pqrsd.id">Ver Detalles</router-link>
          <button @click="eliminarPqrsd(pqrsd.id)">Eliminar</button>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { getPqrsds, deletePqrsd } from '../services/apiService.js';
  
  const pqrsds = ref([]);
  
  const cargarPqrsds = async () => {
    try {
      pqrsds.value = await getPqrsds();
    } catch (error) {
      console.error('Error cargando PQRSD:', error);
    }
  };
  
  const eliminarPqrsd = async (id) => {
    try {
      await deletePqrsd(id);
      pqrsds.value = pqrsds.value.filter(pqrsd => pqrsd.id !== id);
    } catch (error) {
      console.error('Error eliminando PQRSD:', error);
    }
  };
  
  onMounted(() => {
    cargarPqrsds();
  });
  </script>
  
  <style scoped>
  .pqrsd-container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
  }
  router-link {
    margin-right: 10px;
    color: blue;
    text-decoration: underline;
  }
  button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
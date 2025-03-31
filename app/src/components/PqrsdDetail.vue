<template>
    <div class="pqrsd-detail">
      <h2>Detalles de la PQRSD</h2>
      <div v-if="pqrsd">
        <p><strong>Tipo:</strong> {{ pqrsd.tipo }}</p>
        <p><strong>Descripción:</strong> {{ pqrsd.descripcion }}</p>
        <p><strong>Estado:</strong> {{ pqrsd.estado }}</p>
        <p><strong>Fecha de Creación:</strong> {{ pqrsd.created_at }}</p>
        <button @click="volver">Volver</button>
      </div>
      <div v-else>
        <p>Cargando detalles...</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import api from '../services/apiService';
  
  const route = useRoute();
  const router = useRouter();
  const pqrsd = ref(null);
  
  const cargarPqrsd = async () => {
    try {
      const response = await api.get(`/pqrsds/${route.params.id}`);
      pqrsd.value = response.data;
    } catch (error) {
      console.error('Error obteniendo detalles de la PQRSD:', error);
    }
  };
  
  const volver = () => {
    router.push('/pqrsd');
  };
  
  onMounted(() => {
    cargarPqrsd();
  });
  </script>
  
  <style scoped>
  .pqrsd-detail {
    max-width: 600px;
    margin: auto;
    padding: 20px;
  }
  
  button {
    margin-top: 10px;
    background-color: blue;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
  }
  </style>
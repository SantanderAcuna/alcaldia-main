<template>
    <div class="edit-pqrsd-form">
      <h2>Editar PQRSD</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="tipo">Tipo:</label>
          <select v-model="pqrsd.tipo" required>
            <option value="Reclamo">Reclamo</option>
            <option value="Denuncia">Denuncia</option>
            <option value="Queja">Queja</option>
            <option value="Sugerencia">Sugerencia</option>
          </select>
        </div>
  
        <div class="form-group">
          <label for="descripcion">Descripción:</label>
          <textarea v-model="pqrsd.descripcion" required></textarea>
        </div>
  
        <div class="form-group">
          <label for="estado">Estado:</label>
          <select v-model="pqrsd.estado" required>
            <option value="Abierto">Abierto</option>
            <option value="En Proceso">En Proceso</option>
            <option value="Cerrado">Cerrado</option>
          </select>
        </div>
  
        <div class="form-buttons">
          <button type="submit" class="btn-save">Guardar</button>
          <button type="button" class="btn-cancel" @click="cancelEdit">Cancelar</button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, defineProps, defineEmits, onMounted } from 'vue';
  import { updatePqrsd } from '../services/apiService.js';
  
  const props = defineProps(['pqrsdData']);
  const emit = defineEmits(['close']);
  
  const pqrsd = ref({ ...props.pqrsdData });
  
  const submitForm = async () => {
    try {
      await updatePqrsd(pqrsd.value.id, pqrsd.value);
      alert('PQRSD actualizado correctamente');
      emit('close'); // Cerrar el formulario después de actualizar
    } catch (error) {
      console.error('Error actualizando PQRSD:', error);
    }
  };
  
  const cancelEdit = () => {
    emit('close'); // Cierra el formulario sin guardar cambios
  };
  </script>
  
  <style scoped>
  .edit-pqrsd-form {
    max-width: 500px;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    background: #f8f9fa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  h2 {
    text-align: center;
    color: #333;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    font-weight: bold;
  }
  
  select, textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
  }
  
  .form-buttons {
    display: flex;
    justify-content: space-between;
  }
  
  .btn-save {
    background-color: green;
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
  }
  
  .btn-cancel {
    background-color: red;
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
  }
  </style>
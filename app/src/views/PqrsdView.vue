<template>
  <div class="pqrsd-page">
    <h1>Gestión de PQRSD</h1>
    <button @click="openCreateForm" class="btn-create">Crear Nueva PQRSD</button>
    <PqrsdDataTable @edit="openEditForm" />

    <PqrsdModal v-if="modalOpen" 
                :isOpen="modalOpen" 
                :pqrsdData="selectedPqrsd" 
                :editMode="editMode" 
                @close="closeModal" 
                @refreshData="refreshTable" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import PqrsdDataTable from '@/components/PqrsdDataTable.vue';
import PqrsdModal from '../components/PqrsdModal.vue';

const modalOpen = ref(false);
const selectedPqrsd = ref({});
const editMode = ref(false);

const openCreateForm = () => {
  selectedPqrsd.value = { tipo: '', descripcion: '', estado: 'Abierto' };
  editMode.value = false;
  modalOpen.value = true;
};

const openEditForm = (pqrsd) => {
  selectedPqrsd.value = { ...pqrsd };
  editMode.value = true;
  modalOpen.value = true;
};

const closeModal = () => {
  modalOpen.value = false;
};

const refreshTable = () => {
  closeModal();
};
</script>

<style scoped>
.btn-create {
  background-color: blue;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
  margin-bottom: 10px;
}
</style>
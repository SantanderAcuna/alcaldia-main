<template>
  <div class="pqrsd-table">
    <h2>Gestión de PQRSD jhon</h2>
    <table id="pqrsdTable" class="display">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="pqrsd in pqrsds" :key="pqrsd.id">
          <td>{{ pqrsd.id }}</td>
          <td>{{ pqrsd.tipo }}</td>
          <td>{{ pqrsd.descripcion }}</td>
          <td>{{ pqrsd.estado }}</td>
          <td>
            <button @click="verDetalle(pqrsd.id)" class="">
              <i class="fas fa-eye"></i>
            </button>
            <button @click="$emit('edit', pqrsd)" class="">
              <i class="fas fa-edit"></i>
            </button>
            <button @click="eliminarPqrsd(pqrsd.id)" class="">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import $ from 'jquery'; // Importa jQuery
import 'datatables.net-dt/css/dataTables.dataTables.css'; // Importa estilos
import 'datatables.net'; // Importa núcleo de DataTables
import '@fortawesome/fontawesome-free/css/all.css';
import { useRouter } from 'vue-router';
import { getPqrsds, deletePqrsd } from '../services/apiService.js';

const router = useRouter();
const pqrsds = ref([]);


const cargarPqrsds = async () => {
  try {
    pqrsds.value = await getPqrsds();
  } catch (error) {
    console.error('Error cargando PQRSD:', error);
  }
};

const verDetalle = (id) => {
  router.push(`/pqrsds/${id}`);
};

const editarPqrsd = (id) => {
  alert(`Editar PQRSD con ID: ${id}`);
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
  cargarPqrsds().then(() => {
    $('#pqrsdTable').DataTable({
      responsive: true,
      paging: true,
      searching: true,
      ordering: true,
      language: {
        search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ registros",
        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
        paginate: { previous: "Anterior", next: "Siguiente" }
      }
    });
  });
});
</script>

<style scoped>
.pqrsd-table {
  max-width: 95%;
  margin: auto;
  padding: 20px;
}

.display {
  width: 100%;
  border-collapse: collapse;
}

.btn {
  border: none;
  padding: 5px 10px;
  margin: 2px;
  cursor: pointer;
  font-size: 14px;
}

.btn-view {
  color: blue;
}

.btn-edit {
  color: green;
}

.btn-delete {
  color: red;
}
</style>
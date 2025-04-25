<template>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th>Nombre Completo</th>
        <th>Cargo</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Actual</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="alcalde in alcaldes" :key="alcalde.id">
        <td>{{ alcalde.nombre_completo }}</td>
        <td>{{ alcalde.cargo }}</td>
        <td>{{ dayjs(alcalde.fecha_inicio).format('D [de] MMMM [de] YYYY') }}</td>
        <td>
          {{ alcalde.fecha_fin
              ? dayjs(alcalde.fecha_fin).format('D [de] MMMM [de] YYYY')
              : 'N/A' }}
        </td>
        <td>{{ alcalde.actual ? 'Sí' : 'No' }}</td>
        <td>
          <button class="btn btn-sm btn-info me-2" @click="$emit('view', alcalde)">Ver</button>
          <button class="btn btn-sm btn-primary me-2" @click="$emit('edit', alcalde)">Editar</button>
          <button class="btn btn-sm btn-danger" @click="$emit('delete', alcalde.id)">Eliminar</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import dayjs from 'dayjs';
import 'dayjs/locale/es';
dayjs.locale('es');

const props = defineProps({
  alcaldes: Array
});
</script>

<style scoped>
.table {
  font-size: 0.95rem;
}
</style>

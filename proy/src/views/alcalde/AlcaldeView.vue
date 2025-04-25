<template>
  <div class="container mt-4">
    <h2>Alcaldes</h2>

    <div class="text-end my-3">
      <button class="btn btn-primary" @click="nuevoAlcalde">Nuevo Alcalde</button>
    </div>

    <AlcaldeTable :alcaldes="store.alcaldes" @edit="editarAlcalde" @delete="eliminarAlcalde" @view="verAlcalde" />

    <div class="modal fade show d-block" v-if="mostrarFormulario" style="background-color: rgba(0,0,0,0.4)">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5>{{ alcaldeEnEdicion?.id ? 'Editar' : 'Nuevo' }} Alcalde</h5>
            <button class="btn-close" @click="cancelar"></button>
          </div>
          <div class="modal-body">
            <AlcaldeForm :modelValue="alcaldeEnEdicion" @save="guardarAlcalde" @cancel="cancelar" />
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade show d-block" v-if="mostrarDetalle" style="background-color: rgba(0,0,0,0.4)">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Detalle del Alcalde</h5>
            <button class="btn-close" @click="cerrarDetalle"></button>
          </div>
          <div class="modal-body">
            <AlcaldeDetail :alcalde="alcaldeSeleccionado" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useAlcaldeStore } from "@/stores/alcalde/alcaldeStore";
import AlcaldeTable from "@/components/alcalde/AlcaldeTable.vue";
import AlcaldeForm from "@/components/alcalde/AlcaldeForm.vue";
import AlcaldeDetail from "@/views/alcalde/AlcaldeDetail.vue";

const store = useAlcaldeStore();
const mostrarFormulario = ref(false);
const mostrarDetalle = ref(false);
const alcaldeEnEdicion = ref(null);
const alcaldeSeleccionado = ref(null);

onMounted(() => store.fetchAll());

function nuevoAlcalde() {
  alcaldeEnEdicion.value = {
    nombre_completo: "",
    cargo: "",
    fecha_inicio: "",
    fecha_fin: "",
    actual: false,
    objetivo: "",
  };
  mostrarFormulario.value = true;
}

function editarAlcalde(alcalde) {
  alcaldeEnEdicion.value = { ...alcalde };
  mostrarFormulario.value = true;
}

async function guardarAlcalde(data) {
  if (alcaldeEnEdicion.value.id) {
    await store.updateAlcalde(alcaldeEnEdicion.value.id, data);
  } else {
    await store.createAlcalde(data);
  }
  mostrarFormulario.value = false;
}

function verAlcalde(alcalde) {
  alcaldeSeleccionado.value = alcalde;
  mostrarDetalle.value = true;
}

function cancelar() {
  mostrarFormulario.value = false;
  alcaldeEnEdicion.value = null;
}

function cerrarDetalle() {
  mostrarDetalle.value = false;
}
</script>

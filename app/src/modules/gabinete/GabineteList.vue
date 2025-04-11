<template>
  <div class="container py-4">
    <h2 class="mb-4">Gabinete</h2>
    <div class="row">
      <div class="col-md-4 mb-3" v-for="miembro in gabinete" :key="miembro.id">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">{{ miembro.nombre }}</h5>
            <p class="card-text"><strong>Cargo:</strong> {{ miembro.cargo }}</p>
            <p class="card-text"><strong>Dependencia:</strong> {{ miembro.dependencia }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import useGabinete from './useGabinete'

const { gabinete, cargarGabinete } = useGabinete()

onMounted(() => {
  cargarGabinete()
})
</script>

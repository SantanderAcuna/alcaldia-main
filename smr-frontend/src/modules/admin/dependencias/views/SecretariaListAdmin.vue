<template>
  <div class="bg-body-secondary">
    <main class="container py-5">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <h4 class="fw-bold text-primary-emphasis">Gabinete Distrital De Santa Marta</h4>

        <form class="d-flex ms-auto me-4" @submit.prevent>
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"
              ><i class="fas fa-search"></i
            ></span>
            <input
              v-model="searchQuery"
              type="text"
              class="form-control border-start-0"
              placeholder="Buscar"
            />
          </div>
        </form>

        <router-link
          to="/admin/secretarias/create"
          class="btn btn-primary rounded-pill d-inline-flex align-items-center fw-bold shadow-sm"
        >
          <i class="fas fa-landmark me-2"></i>Nueva Secretaria
        </router-link>
      </div>

      <div class="row g-4">
        <div
          v-for="(secretaria, index) in filteredSecretarias"
          :key="index"
          class="col-lg-4 col-md-6"
        >
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <img
                  :src="secretaria.organigrama || '/placeholder-image.jpg'"
                  :alt="`Logo de ${secretaria.nombre}`"
                  class="rounded-circle border border-2 me-3"
                  style="width: 72px; height: 72px; object-fit: cover"
                />
                <div>
                  <h5 class="card-title mb-1 text-primary text-capitalize">
                    {{ secretaria.nombre }}
                  </h5>
                  <p class="text-muted small mb-0">{{ secretaria.descripcion }}</p>
                </div>
              </div>

              <div v-if="secretaria.funcionarios && secretaria.funcionarios.length" class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase p-2">
                  <i class="fas fa-user me-1"></i>
                  {{ secretaria.funcionarios[0].nombres }}
                  {{ secretaria.funcionarios[0].apellidos }}
                </span>
                <p class="small text-muted mt-1 mb-0">
                  {{ secretaria.funcionarios[0].cargo}}
                </p>
              </div>

              <div class="container-fluid px-0">
                <div class="d-flex align-items-center gap-2">
                  <router-link
                    :to="{ name: 'secretaria-detalle', params: { id: secretaria.id } }"
                    class="btn btn-primary rounded-pill px-3 py-2 shadow-sm"
                    title="Ver perfil completo"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-user-circle me-2"></i>Perfil
                  </router-link>

                  <router-link
                    :to="`/admin/secretarias/${secretaria.id}`"
                    class="btn p-2 text-decoration-none"
                    title="Editar información"
                    data-bs-toggle="tooltip"
                  >
                    <i class="fas fa-edit text-primary"></i>
                  </router-link>

                  <button
                    class="btn rounded-circle p-2 shadow-sm"
                    title="Eliminar registro"
                    data-bs-toggle="tooltip"
                    @click.prevent="eliminarSecretaria(secretaria.id)"
                  >
                    <i class="fas fa-trash-alt text-primary"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="filteredSecretarias.length === 0" class="col-12">
          <div class="d-flex flex-column justify-content-center align-items-center text-center p-5">
            <i class="fas fa-users-slash text-muted mb-3" style="font-size: 3rem"></i>
            <h5>No se encontraron resultados para la búsqueda</h5>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue';
import type { Dependencia } from '@/modules/interfaces/';

// Datos simulados de la API
const apiData = {
  status: true,
  data: [
    {
      id: 3,
      nombre: 'Desarrollo de Aplicaciones',
      tipo: 'SUB_DEPENDENCIA',
      dependencia_padre_id: 1,
      descripcion: 'Creación de software institucional',
      mision: 'Desarrollar soluciones tecnológicas',
      vision: 'Ser el área líder en innovación',
      organigrama: null,
      parent: {
        id: 1,
        nombre: 'Secretaría TIC',
        parent: null,
        children: [],
      },
      children: [],
      funcionarios: [
        {
          id: 3,
          nombres: 'Ana',
          apellidos: 'Rodríguez Vargas',
          cargo_id: 3,
          dependencia_id: 3,
          genero: 'F',
          departamento: 'Valle del Cauca',
          municipio: 'Cali',
          estado: true,
          cargo: {
            id: 3,
            cargo: 'Analista Senior',
            nivel: 'OPERATIVO',
            grado: '3',
          },
        },
      ],
      competencias: [
        {
          id: 3,
          competencia: 'Desarrollo de APIs REST',
          orden: 3,
          dependencia_id: 3,
        },
      ],
      tramites: [
        {
          id: 3,
          tramite: 'Reporte de fallas técnicas',
          codigo: 'TRAM-FT01',
          descripcion: 'Reporte de problemas en sistemas institucionales',
          dependencia_id: 3,
        },
      ],
      macroprocesos: [
        {
          id: 3,
          macrop: 'Desarrollo de Software',
          dependencia_id: 3,
          codigo: 'MP-DS01',
          descripcion: 'Ciclo de vida de desarrollo',
          procesos: [
            {
              id: 2,
              proceso: 'Desarrollo Frontend',
              codigo: 'PROC-FE01',
              descripcion: 'Creación de interfaces de usuario',
              macroproceso_id: 3,
            },
          ],
        },
      ],
    },
    {
      id: 2,
      nombre: 'División Fotomultas',
      tipo: 'SUB_DEPENDENCIA',
      dependencia_padre_id: 1,
      descripcion: 'Gestión de sistema de fotodetección',
      mision: 'Controlar infracciones de tránsito',
      vision: 'Reducir accidentes viales en 40%',
      organigrama: null,
      parent: {
        id: 1,
        nombre: 'Secretaría TIC',
        parent: null,
        children: [],
      },
      children: [],
      funcionarios: [
        {
          id: 2,
          nombres: 'Carlos',
          apellidos: 'Ruiz López',
          cargo_id: 2,
          dependencia_id: 2,
          genero: 'M',
          departamento: 'Cundinamarca',
          municipio: 'Bogotá',
          estado: true,
          cargo: {
            id: 2,
            cargo: 'Coordinador Técnico',
            nivel: 'JEFATURA',
            grado: '2',
          },
        },
      ],
      competencias: [
        {
          id: 2,
          competencia: 'Gestión de infracciones digitales',
          orden: 2,
          dependencia_id: 2,
        },
      ],
      tramites: [
        {
          id: 1,
          tramite: 'Apelación de fotomulta',
          codigo: 'TRAM-FM01',
          descripcion: 'Proceso para apelar multas por fotodetección',
          dependencia_id: 2,
        },
      ],
      macroprocesos: [
        {
          id: 2,
          macrop: 'Control de Infracciones',
          dependencia_id: 2,
          codigo: 'MP-FM01',
          descripcion: 'Procesamiento de fotomultas',
          procesos: [
            {
              id: 1,
              proceso: 'Procesamiento de Infracciones',
              codigo: 'PROC-FM01',
              descripcion: 'Validación y procesamiento de fotomultas',
              macroproceso_id: 2,
            },
          ],
        },
      ],
    },
    {
      id: 1,
      nombre: 'Secretaría TIC',
      tipo: 'SECRETARIA',
      dependencia_padre_id: null,
      descripcion: 'Gestión de tecnologías de información',
      mision: 'Impulsar la transformación digital',
      vision: 'Ser referente nacional en gobierno digital',
      organigrama: null,
      parent: null,
      children: [
        {
          id: 2,
          nombre: 'División Fotomultas',
          dependencia_padre_id: 1,
          parent: {
            id: 1,
            nombre: 'Secretaría TIC',
            parent: null,
            children: [],
          },
          children: [],
        },
        {
          id: 3,
          nombre: 'Desarrollo de Aplicaciones',
          dependencia_padre_id: 1,
          parent: {
            id: 1,
            nombre: 'Secretaría TIC',
            parent: null,
            children: [],
          },
          children: [],
        },
      ],
      funcionarios: [
        {
          id: 1,
          nombres: 'María',
          apellidos: 'Gómez Pérez',
          cargo_id: 1,
          dependencia_id: 1,
          genero: 'F',
          departamento: 'Antioquia',
          municipio: 'Medellín',
          estado: true,
          cargo: {
            id: 1,
            cargo: 'Secretario',
            nivel: 'DIRECTIVO',
            grado: '1',
          },
        },
      ],
      competencias: [
        {
          id: 1,
          competencia: 'Desarrollo de aplicaciones móviles',
          orden: 1,
          dependencia_id: 1,
        },
      ],
      tramites: [
        {
          id: 2,
          tramite: 'Solicitud de certificado digital',
          codigo: 'TRAM-CD01',
          descripcion: 'Obtención de certificado de firma digital',
          dependencia_id: 1,
        },
      ],
      macroprocesos: [
        {
          id: 1,
          macrop: 'Gestión Tecnológica',
          dependencia_id: 1,
          codigo: 'MP-TIC01',
          descripcion: 'Procesos relacionados con TI',
          procesos: [
            {
              id: 3,
              proceso: 'Soporte Técnico',
              codigo: 'PROC-ST01',
              descripcion: 'Atención a usuarios finales',
              macroproceso_id: 1,
            },
          ],
        },
      ],
    },
  ],
};

const searchQuery = ref('');
const secretarias = ref<Dependencia[]>([]);

// Filtrar solo secretarías (no subdependencias)
const filteredSecretarias = computed(() => {
  if (!secretarias.value) return [];

  return secretarias.value.filter(
    (secretaria) =>
      secretaria.tipo === 'SECRETARIA' &&
      secretaria.nombre?.toLowerCase().includes(searchQuery.value.toLowerCase()),
  );
});

// Simular obtención de datos de la API
onMounted(() => {
  // Aquí normalmente harías la llamada a la API
  // Por ahora usamos los datos de ejemplo
  if (apiData.status && apiData.data) {
    secretarias.value = apiData.data;
  }
});

const eliminarSecretaria = (id: number | null | undefined) => {
  if (!id) return;

  // Lógica para eliminar la secretaría
  console.log('Eliminando secretaría con ID:', id);
  secretarias.value = secretarias.value.filter((s) => s.id !== id);
};
</script>

<style scoped>
.card {
  transition: transform 0.2s;
}

.card:hover {
  transform: translateY(-5px);
}

.badge {
  font-size: 0.75rem;
}
</style>

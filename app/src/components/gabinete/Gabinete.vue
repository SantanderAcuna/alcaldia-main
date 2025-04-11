<template>
  <div class="gabinete-container">
    <!-- Contenido principal -->
    <main class="container my-5">
      <div class="row g-4 justify-content-center">
        <!-- Tarjeta - Usando v-for -->
        <div class="col-lg-6" v-for="miembro in miembros" :key="miembro.id">
          <div
            class="card border-0 shadow-sm h-100 hover-effect"
            @mouseenter="hoverCard"
            @mouseleave="unhoverCard"
          >


          <router-link to="/">Home</router-link> |
          <router-link to="/about">About</router-link>



            <div class="card-body p-4">
              <!-- Encabezado con foto -->
              <div class="d-flex align-items-center mb-4">
                <div class="flex-shrink-0 position-relative">
                  <div
                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                    :style="{
                      width: '90px',
                      height: '90px',
                      fontSize: '1.75rem',
                      fontWeight: 'bold',
                    }"
                  >
                    {{ miembro.iniciales }}
                  </div>
                  <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"
                  >
                    <i class="bi bi-check"></i>
                  </span>
                </div>
                <div class="flex-grow-1 ms-4">
                  <h3 class="h4 mb-1 text-primary">{{ miembro.nombre }}</h3>
                  <p class="text-muted mb-2">
                    <i :class="miembro.iconoCargo"></i> {{ miembro.cargo }}
                  </p>
                  <div class="d-flex gap-2">
                    <span
                      class="badge bg-light text-dark"
                      v-for="(badge, index) in miembro.badges"
                      :key="index"
                    >
                      <i :class="badge.icono"></i> {{ badge.texto }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Sección de perfil -->
              <div class="mb-4 p-3 bg-light rounded">
                <h4 class="h6 text-uppercase text-muted mb-3">
                  <i class="bi bi-person-lines-fill"></i> PERFIL PROFESIONAL
                </h4>
                <p class="mb-0">{{ miembro.perfil }}</p>
              </div>

              <!-- Sección de dependencia -->
              <div class="mb-4 p-3 bg-light rounded">
                <h4 class="h6 text-uppercase text-muted mb-3">
                  <i class="bi bi-building-gear"></i> DEPENDENCIA A CARGO
                </h4>
                <div class="d-flex align-items-center">
                  <i
                    :class="miembro.dependencia.icono"
                    class="text-success fs-4 me-3"
                  ></i>
                  <div>
                    <p class="fw-bold mb-0">{{ miembro.dependencia.nombre }}</p>
                    <small class="text-muted">{{
                      miembro.dependencia.descripcion
                    }}</small>
                  </div>
                </div>
              </div>

              <!-- Botones con iconos -->
              <div class="d-flex gap-3 mt-4">
                <button
                  class="btn btn-outline-primary flex-grow-1"
                  @click="verPerfil(miembro.id)"
                >
                  <i class="bi bi-file-person"></i> Ver perfil completo
                </button>
                <button
                  class="btn btn-primary flex-grow-1"
                  @click="contactar(miembro.id)"
                >
                  <i class="bi bi-envelope"></i> Contactar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
      <div class="container text-center">
        <img
          src="https://www.santamarta.gov.co/sites/default/files/escudo-santamarta_0.png"
          alt="Escudo de Santa Marta"
          height="40"
          class="mb-3"
        />
        <p class="mb-1">Alcaldía Distrital de Santa Marta</p>
        <p class="small text-muted mb-0">
          Carrera 1ra #14-44 | Teléfono: (+57) 605 4211854
        </p>
      </div>
    </footer>
  </div>
</template>

<script>
import { ref } from "vue";

export default {
  name: "GabineteDistrital",
  setup() {
    // Datos reactivos
    const miembros = ref([
      {
        id: 1,
        nombre: "Camilo George Díaz",
        cargo: "Secretario de Gobierno",
        iniciales: "CGD",
        iconoCargo: "bi bi-building",
        perfil:
          "Abogado especializado en Derecho Administrativo con amplia experiencia en el sector público. Lideró importantes reformas en la administración distrital durante los últimos años.",
        badges: [
          { icono: "bi bi-person-vcard", texto: "Abogado" },
          { icono: "bi bi-award", texto: "15 años exp." },
        ],
        dependencia: {
          nombre: "Secretaría de Gobierno",
          descripcion: "Coordinación interinstitucional y políticas públicas",
          icono: "bi bi-shield-check",
        },
      },
      {
        id: 2,
        nombre: "Safuat Atunes Celedon",
        cargo: "Jefe Oficina Despacho",
        iniciales: "SAC",
        iconoCargo: "bi bi-briefcase",
        perfil:
          "Administrador Público con maestría en Gestión de Organizaciones. Especialista en procesos administrativos y coordinación interinstitucional.",
        badges: [
          { icono: "bi bi-mortarboard", texto: "Administrador" },
          { icono: "bi bi-star", texto: "Gestión" },
        ],
        dependencia: {
          nombre: "Oficina del Alcalde",
          descripcion: "Coordinación general de la administración",
          icono: "bi bi-buildings",
        },
      },
    ]);

    // Métodos
    const hoverCard = (event) => {
      event.currentTarget.style.transform = "translateY(-5px)";
      event.currentTarget.style.transition = "all 0.3s ease";
    };

    const unhoverCard = (event) => {
      event.currentTarget.style.transform = "";
    };

    const verPerfil = (id) => {
      console.log(`Ver perfil del miembro con ID: ${id}`);
      // Aquí iría la lógica para mostrar el perfil completo
    };

    const contactar = (id) => {
      console.log(`Contactar al miembro con ID: ${id}`);
      // Aquí iría la lógica para contactar al miembro
    };

    return {
      miembros,
      hoverCard,
      unhoverCard,
      verPerfil,
      contactar,
    };
  },
};
</script>

<style scoped>
.hover-effect {
  cursor: pointer;
}

.gabinete-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

footer {
  margin-top: auto;
}
</style>

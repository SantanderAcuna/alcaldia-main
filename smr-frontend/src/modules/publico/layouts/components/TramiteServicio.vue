<template>
  <div class="continer-fluid my-xl-5 my-md-4 my-sm-3 my-2">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12 col-sm-12">
        <h1 class="text-center">Trámites y Servicios</h1>
        <p class="text-center"></p>
      </div>
    </div>
    <div class="row justify-content-center my-4">
      <div class="col-sm-6 col-md-9 col-xl-9">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <!-- 1. Catastro -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button
                class="btn btn-primary accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne"
                aria-expanded="false"
                aria-controls="flush-collapseOne"
              >
                <div class="w-100">Unidad Administrativa Especial de Catastro Multipropósito</div>
              </button>
            </h2>
            <div
              id="flush-collapseOne"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container-fluid">
                  <div class="row justify-content-center text-center g-3">
                    <!-- Catastro -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                      <a
                        href="https://uaecm.santamarta.gov.co/consultas"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <i class="fa-solid fa-map-location-dot fa-3x mb-2"></i>
                        <span class="fw-bold text-center">Catastro</span>
                      </a>
                    </div>

                    <!-- Geoportal -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                      <a
                        href="https://uaecm.santamarta.gov.co/consultas/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <i class="fa-solid fa-map-pin fa-3x mb-2"></i>
                        <span class="fw-bold text-center">Geoportal</span>
                      </a>
                    </div>

                    <!-- Observatorio Inmobiliario -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                      <a
                        href="https://observatorioinmobiliario.santamarta.gov.co/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <i class="fa-solid fa-earth-americas fa-spin-pulse fa-3x mb-2"></i>
                        <span class="fw-bold text-center">Observatorio<br />Inmobiliario</span>
                      </a>
                    </div>

                    <!-- Pagos Catastrales -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">
                      <a
                        href="https://micrositios.avalpaycenter.com/recaudo-productos-catastrales-ma"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <i class="fa-solid fa-credit-card fa-3x mb-2"></i>
                        <span class="fw-bold text-center">Pagos<br />Catastrales</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 2. Impuestos -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button
                class="accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo"
                aria-expanded="false"
                aria-controls="flush-collapseTwo"
              >
                <div class="w-100">Portal de Impuestos</div>
              </button>
            </h2>
            <div
              id="flush-collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container-fluid">
                  <div class="row justify-content-center text-center gap-3">
                    <div class="col-auto">
                      <a
                        href="https://santamarta.taxationsmart.co/ords/f?p=150000:1::::1:F_CDGO_CLNTE"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-building-columns fa-3x mb-2"></i>
                        <span class="fw-bold">Pago de impuestos</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Tránsito -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button
                class="accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseThree"
                aria-expanded="false"
                aria-controls="flush-collapseThree"
              >
                <div class="w-100">Tránsito</div>
              </button>
            </h2>
            <div
              id="flush-collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container-fluid">
                  <div class="row g-4 justify-content-center">
                    <!-- Aviso de comparendo -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotiComparendo.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-circle-exclamation fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Aviso de comparendo</span>
                      </a>
                    </div>

                    <!-- Fotomultas -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://avisos.fotomultasmr.com/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-camera fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Fotomultas</span>
                      </a>
                    </div>

                    <!-- Comparendo de tránsito -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotiComparendosTransito.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-file-lines fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Comparendo de tránsito</span>
                      </a>
                    </div>

                    <!-- Impuesto coactivo -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotImpuestosCoactivo.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-credit-card fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Impuesto coactivo</span>
                      </a>
                    </div>

                    <!-- Suspensión de licencia -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotiSuspencionLicencia.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-id-card fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Suspensión de licencia</span>
                      </a>
                    </div>

                    <!-- Acuerdo pago coactivo -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotiAcuerdoPagoCoactivo.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-thumbs-up fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Acuerdo pago coactivo</span>
                      </a>
                    </div>

                    <!-- Desvinculación administrativa -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/notiDesvinculacion.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-thumbs-down fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Desvinculación administrativa</span
                        >
                      </a>
                    </div>

                    <!-- Vinculación administrativa -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/notiVinculacion.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-handshake fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Vinculación administrativa</span
                        >
                      </a>
                    </div>

                    <!-- Comparendo transporte público -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://siettsantamarta.com/NotiTransportePublico.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-bus fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Comparendo transporte público</span
                        >
                      </a>
                    </div>

                    <!-- Mandamientos pago fotomultas -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://avisos.fotomultasmr.com/mandamientos.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-gavel fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Mandamientos pago fotomultas</span
                        >
                      </a>
                    </div>

                    <!-- Avisos de sustitución -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://avisos.fotomultasmr.com/sustituciones.php"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-user-plus fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Avisos de sustitución</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 4. Población -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFour">
              <button
                class="accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFour"
                aria-expanded="false"
                aria-controls="flush-collapseFour"
              >
                <div class="w-100">Población</div>
              </button>
            </h2>
            <div
              id="flush-collapseFour"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingFour"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container-fluid">
                  <div class="row justify-content-center text-center gap-3">
                    <!-- Consulta de Estado Programa Colombia Mayor -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="http://adultomayor.santamarta.gov.co/adultomayor/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-person-cane fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Consulta de Estado Programa Colombia Mayor</span
                        >
                      </a>
                    </div>

                    <!-- Inscripción al Gabinete Infantil -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="http://adultomayor.santamarta.gov.co/adultomayor/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-children fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center"
                          >Inscripción al Gabinete Infantil</span
                        >
                      </a>
                    </div>

                    <!-- Actualización Escolar -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://www.santamarta.gov.co/familias%20en%20accion/"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark"
                        target="_blank"
                      >
                        <i class="fa-solid fa-laptop fa-3x mb-2"></i>
                        <span class="fw-bold icon-label text-center">Actualización Escolar</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 5. Salud -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFive">
              <button
                class="accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFive"
                aria-expanded="false"
                aria-controls="flush-collapseFive"
              >
                <div class="w-100">Salud</div>
              </button>
            </h2>
            <div
              id="flush-collapseFive"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingFive"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container py-4">
                  <div class="row g-4 justify-content-center text-center">
                    <!-- Prestadores de Servicios de Salud - Inscripción -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                      <!-- Enlace 1 -->
                      <a
                        href="https://prestadores.minsalud.gov.co/habilitacion/ingreso.aspx?ets_codigo=47001"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-primary"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        <i class="fa-solid fa-file-lines fa-3x mb-3"></i>
                        <span class="fw-semibold icon-label"
                          >Prestadores de Servicios<br />de Salud</span
                        >
                        <span class="small text-dark">Inscripción</span>
                      </a>

                      <!-- Enlace 2 -->
                      <a
                        href="https://www.santamarta.gov.co/requisitos-para-inscripcion-de-prestadores-de-servicios-de-salud"
                        class="small text-decoration-underline d-block mt-1 text-center"
                        target="_blank"
                        rel="noopener noreferrer"
                      >
                        Ver requisitos
                      </a>
                    </div>

                    <!-- Atención al Ciudadano -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                      <a
                        href="https://www.santamarta.gov.co/atencion-e-informacion-al-ciudadano"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-primary"
                        target="_blank"
                      >
                        <i class="fa-solid fa-square-check fa-3x mb-3"></i>
                        <span class="fw-semibold icon-label">Atención al Ciudadano</span>
                        <span class="small text-dark">y Participación Social</span>
                      </a>
                    </div>

                    <!-- Prestadores de Servicios - Novedades -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                      <a
                        href="https://prestadores.minsalud.gov.co/habilitacion/ingreso_prestadores.aspx?ets_codigo=47001"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-primary"
                        target="_blank"
                      >
                        <i class="fa-solid fa-pen-to-square fa-3x mb-3"></i>
                        <span class="fw-semibold icon-label"
                          >Prestadores de Servicios<br />de Salud</span
                        >
                        <span class="small text-dark">Novedades</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 6. Desarrollo Económico -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingSix">
              <button
                class="accordion-button collapsed d-flex justify-content-center align-items-center text-center"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseSix"
                aria-expanded="false"
                aria-controls="flush-collapseSix"
              >
                <div class="w-100">Desarrollo Económico</div>
              </button>
            </h2>
            <div
              id="flush-collapseSix"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingSix"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="container-fluid">
                  <div class="row justify-content-center text-center gap-3">
                    <!-- Emprendimiento -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://www.santamarta.gov.co/registro-de-emprendedores"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark text-center"
                        target="_blank"
                      >
                        <i class="fa-solid fa-rocket fa-3x mb-3"></i>
                        <span class="fw-bold icon-label">Emprendimiento</span>
                      </a>
                    </div>

                    <!-- Formalización -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://www.santamarta.gov.co/registro-de-beneficiarios"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark text-center"
                        target="_blank"
                      >
                        <i class="fa-solid fa-file-contract fa-3x mb-3"></i>
                        <span class="fw-bold icon-label">Formalización</span>
                      </a>
                    </div>

                    <!-- Empleabilidad -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                      <a
                        href="https://www.santamarta.gov.co/registro-de-solicitantes-empleabilidad"
                        class="icon-link d-flex flex-column align-items-center text-decoration-none text-dark text-center"
                        target="_blank"
                      >
                        <i class="fa-solid fa-user-tie fa-3x mb-3"></i>
                        <span class="fw-bold icon-label">Empleabilidad</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts"></script>

<style scoped>
:root {
  --color-alcaldia: #00ade7; /* Azul claro institucional */
  --color-secundario: #00568d; /* Azul oscuro institucional */
  --color-fondo: #ffffff; /* Fondo blanco */
  --color-texto: #333333; /* Texto principal */
}

/* ----------------------------- */
/* BOTÓN DEL ACORDEÓN           */
/* ----------------------------- */

.accordion-button {
  font-weight: bold;
  font-size: 1.1rem;
  color: var(--color-secundario);
  background-color: #f8f9fa;
  transition:
    background-color 0.3s ease,
    color 0.3s ease;
  border-radius: 0.5rem;
}

/* Hover (al pasar el mouse por cualquier botón) */
.accordion-button:hover {
  background-color: var(--color-alcaldia);
  color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Botón cuando está abierto */
.accordion-button:not(.collapsed) {
  background-color: var(--color-secundario);
  color: #fff;
  border-bottom: 1px solid #ccc;
}

/* Espaciado entre acordeones */
.accordion-item + .accordion-item {
  margin-top: 1rem;
}

/* ----------------------------- */
/* CUERPO DEL ACORDEÓN          */
/* ----------------------------- */

.accordion-body {
  background-color: var(--color-fondo);
  color: var(--color-texto);
  font-size: 1rem;
  line-height: 1.6;
  padding: 1.25rem 1.5rem;
  border-left: 5px solid var(--color-secundario);
  border-radius: 0 0 0.5rem 0.5rem;
  transition:
    background-color 0.3s ease,
    color 0.3s ease;
}

/* ----------------------------- */
/* ENCABEZADOS DENTRO DEL BODY  */
/* ----------------------------- */

.accordion-body h4 {
  color: var(--color-secundario);
  font-size: 1.4rem;
  font-weight: bold;
  margin-bottom: 0.75rem;
  transition: color 0.3s ease;
}

.accordion-body h4:hover {
  color: var(--color-fondo);
  cursor: pointer;
}

/* ----------------------------- */
/* ENLACES CON ÍCONOS           */
/* ----------------------------- */

.accordion-body a {
  text-decoration: none;
  color: var(--color-secundario);
  transition: color 0.3s ease;
}

.accordion-body a:hover {
  color: var(--color-alcaldia);
}

.accordion-body i {
  display: block;
  font-size: 2.5rem; /* fa-3x equivalente */
  margin-bottom: 0.5rem;
}

:root {
  --color-alcaldia: #00ade7;
  --color-secundario: #00568d;
}

/* Enlace contenedor */
.icon-link {
  color: var(--color-secundario);
  text-decoration: none;
  transition: all 0.3s ease;
}

.icon-link i {
  font-size: 2.5rem; /* Tamaño base */
  transition:
    transform 0.4s ease,
    color 0.3s ease;
  color: var(--color-secundario);
}

.icon-link .icon-label {
  font-size: 1rem;
  transition: color 0.3s ease;
  color: var(--color-secundario);
}

/* Animación y efecto hover */
.icon-link:hover i {
  transform: scale(1.2) rotate(-8deg);
  color: var(--color-alcaldia);
}

.icon-link:hover .icon-label {
  color: var(--color-alcaldia);
}
</style>

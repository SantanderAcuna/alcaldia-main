<template>
  <!-- Footer -->
  <footer
    class="mt-xl-5 py-4 mt-8 text-white"
    role="contentinfo"
    aria-label="Pie de página del sitio web de la Alcaldía Distrital de Santa Marta"
  >
    <div class="container">
      <div class="row g-4">
        <!-- Columna 1: Información Institucional -->
        <div class="col-md-4" role="region" aria-labelledby="institucional-heading">
          <h5 id="institucional-heading" class="mb-3">Datos Oficiales</h5>
          <div class="mb-3">
            <p class="mb-1" role="note" aria-label="Número de Identificación Tributaria">
              NIT 891780009
            </p>
            <address class="mb-1" aria-label="Dirección física de la Alcaldía">
              Calle 14 No. 2 - 49<br />
              Palacio Municipal<br />
              Santa Marta, Colombia
            </address>
          </div>

          <div class="mb-3">
            <h6 class="mb-2">Contacto Principal</h6>
            <ul class="list-unstyled">
              <li role="listitem">
                <span role="tooltip" aria-label="Teléfono principal de contacto">
                  Teléfono:
                  <a href="tel:+5754209600" class="text-white" aria-describedby="tel-tooltip"
                    >(5) 420 9600</a
                  >
                </span>
                <div id="tel-tooltip" role="tooltip" hidden>
                  Llama a nuestro número principal de atención
                </div>
              </li>
              <li role="listitem" aria-label="Número de extensión para contacto directo">
                Extensión: 1212
              </li>
              <li role="listitem" aria-label="Línea gratuita de atención">
                Línea Gratuita: 420 9600
              </li>
              <li role="listitem" aria-label="Línea exclusiva para reporte de corrupción">
                Línea Anticorrupción: 420 9600
              </li>
            </ul>
          </div>
        </div>

        <!-- Columna 2: Horarios y Atención -->
        <div class="col-md-4" role="region" aria-labelledby="horarios-heading">
          <h5 id="horarios-heading" class="mb-3">Horarios de Servicio</h5>
          <div class="mb-3">
            <h6 class="mb-2">Atención General</h6>
            <p aria-label="Horario de atención al público">
              Lunes a Viernes<br />
              8:00 a.m. - 12:00 p.m.<br />
              2:00 p.m. - 6:00 p.m.
            </p>

            <div class="p-2 text-white" role="note" aria-label="Nota sobre horario de radicación">
              <small>Horario de radicación:<br />8:00 a.m. - 5:00 p.m.</small>
            </div>
          </div>

          <h6 class="mb-2">Canales Especializados</h6>
          <ul class="list-unstyled" role="list">
            <li role="listitem">
              <strong>Atención al Ciudadano:</strong><br />
              <a
                href="mailto:atencionalciudadano@santamarta.gov.co"
                class="text-white"
                role="tooltip"
                aria-label="Correo para atención general de ciudadanos"
                data-tooltip="Envía tus consultas generales a este correo"
              >
                atencionalciudadano@santamarta.gov.co
              </a>
            </li>
            <li class="mt-2" role="listitem">
              <strong>Notificaciones Judiciales:</strong><br />
              <a
                href="mailto:notificacionesalcaldiadistrital@santamarta.gov.co"
                class="text-white"
                role="tooltip"
                aria-label="Correo exclusivo para notificaciones legales"
                data-tooltip="Usa este correo solo para asuntos jurídicos"
              >
                notificacionesalcaldiadistrital@santamarta.gov.co
              </a>
              <div role="alert" aria-live="polite" class="text-warning">
                <small>Exclusivo para temas jurídicos</small>
              </div>
            </li>
          </ul>
        </div>

        <!-- Columna 3: Enlaces y Legal -->
        <div class="col-md-4">
          <div class="row">
            <!-- Subcolumna 1: Enlaces -->
            <div class="col-6" role="navigation" aria-label="Sección de servicios en línea">
              <h5 class="mb-3">Servicios</h5>
              <ul class="list-unstyled" role="list">
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/transparencia"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Accede a información de transparencia"
                    data-tooltip="Información sobre gestión pública y rendición de cuentas"
                  >
                    <i class="fas fa-shield-alt me-2" aria-hidden="true"></i>Transparencia
                  </router-link>
                </li>
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/documentos"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Consulta documentos oficiales"
                    data-tooltip="Accede a documentos públicos y formatos oficiales"
                  >
                    <i class="fas fa-archive me-2" aria-hidden="true"></i>Documentos
                  </router-link>
                </li>
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/humano"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Portal de recursos humanos"
                    data-tooltip="Información para funcionarios y contratistas"
                  >
                    <i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>Humano
                  </router-link>
                </li>
              </ul>
            </div>

            <!-- Subcolumna 2: Legal -->
            <div class="col-6" role="navigation" aria-label="Sección de información legal">
              <h5 class="mb-3">Legal</h5>
              <ul class="list-unstyled" role="list">
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/proteccion-datos"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Política de protección de datos"
                    data-tooltip="Conoce cómo protegemos tu información personal"
                  >
                    <i class="fas fa-user-shield me-2" aria-hidden="true"></i>Protección de datos
                  </router-link>
                </li>
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/terminos"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Términos y condiciones de uso"
                    data-tooltip="Condiciones para el uso de nuestro sitio web"
                  >
                    <i class="fas fa-balance-scale me-2" aria-hidden="true"></i>Términos y
                    condiciones
                  </router-link>
                </li>
                <li class="mb-2" role="listitem">
                  <router-link
                    to="/mapa-sitio"
                    class="text-white text-decoration-none"
                    role="tooltip"
                    aria-label="Mapa del sitio web"
                    data-tooltip="Navega por todas las secciones de nuestro portal"
                  >
                    <i class="fas fa-map me-2" aria-hidden="true"></i>Mapa del sitio
                  </router-link>
                </li>
              </ul>
            </div>
          </div>

          <!-- Redes Sociales con Tooltips -->
          <h5 class="mt-4">Conecta con nosotros</h5>
          <div class="gap-3 d-flex" role="group" aria-label="Enlaces a redes sociales">
            <router-link
              to="https://facebook.com"
              class="text-white"
              role="tooltip"
              aria-label="Visita nuestro Facebook"
              data-tooltip="Síguenos en Facebook para las últimas noticias"
              target="_blank"
            >
              <i class="fab fa-facebook fa-2x" aria-hidden="true"></i>
            </router-link>
            <router-link
              to="https://twitter.com"
              class="text-white"
              role="tooltip"
              aria-label="Visita nuestro Twitter"
              data-tooltip="Conéctate con nosotros en Twitter"
              target="_blank"
            >
              <i class="fab fa-twitter fa-2x" aria-hidden="true"></i>
            </router-link>
            <router-link
              to="https://instagram.com"
              class="text-white"
              role="tooltip"
              aria-label="Visita nuestro Instagram"
              data-tooltip="Mira nuestras fotos en Instagram"
              target="_blank"
            >
              <i class="fab fa-instagram fa-2x" aria-hidden="true"></i>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Sección Inferior: Logos y Copyright -->
      <div class="pt-3 mt-4 text-center border-top">
        <div class="mb-3" role="group" aria-label="Logotipos oficiales">
          <img
            :src="logo500Or"
            alt="Logo 500 años de Santa Marta"
            class="img-fluid"
            style="max-height: 80px"
            loading="lazy"
            role="tooltip"
            aria-label="Conmemoración 500 años"
            data-tooltip="Celebrando 500 años de historia de Santa Marta"
          />
          <img
            :src="logoGovCo"
            alt="Logo Gobierno de Colombia"
            class="img-fluid"
            style="height: 50px"
            loading="lazy"
            role="tooltip"
            aria-label="Gobierno de Colombia"
            data-tooltip="Entidad perteneciente al Gobierno de Colombia"
          />
        </div>

        <p class="mb-0" role="contentinfo" aria-label="Información de derechos de autor">
          <i class="fas fa-copyright me-2" aria-hidden="true"></i>2025 Alcaldía Distrital de Santa
          Marta<br />
          <small class="text-white-50">Todos los derechos reservados</small><br />
          <small class="text-warning" role="note" aria-label="Reconocimiento patrimonial"
            >Ciudad Patrimonio de Colombia</small
          >
        </p>
      </div>

      <!-- Reloj con estado ARIA -->
      <div class="mt-3 text-center">
        <div
          id="reloj"
          class="reloj-digital"
          role="timer"
          aria-live="polite"
          aria-label="Hora legal de Colombia"
          aria-atomic="true"
        >
          <span>HORA LEGAL REPÚBLICA DE COLOMBIA</span>
          <div
            id="hora-actual"
            class="h4"
            role="status"
            aria-label="Hora actual"
            aria-describedby="reloj-desc"
          >
            {{ horaActual }}
          </div>
          <div id="reloj-desc" hidden>Actualizado cada segundo</div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script lang="ts" setup>
import { ref, onMounted, onUnmounted } from 'vue';

// ─── Logos del footer ───
const logo500Or = new URL('@/assets/img/logos/logo500Or.png', import.meta.url).href;
const logoGovCo = new URL('@/assets/img/logos/gov.svg', import.meta.url).href;

// ─── Reloj digital ───
const horaActual = ref('');

const actualizarReloj = () => {
  const ahora = new Date();
  const opciones: Intl.DateTimeFormatOptions = {
    timeZone: 'America/Bogota',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: true,
  };
  horaActual.value = ahora.toLocaleTimeString('es-CO', opciones);
};

onMounted(() => {
  actualizarReloj();
  const intervalId = setInterval(actualizarReloj, 1000);

  // ─── Inicializar tooltips ───
  const tooltipElements = document.querySelectorAll('[role="tooltip"][data-tooltip]');
  tooltipElements.forEach((el) => {
    el.setAttribute('aria-describedby', `tooltip-${Math.random().toString(36).substr(2, 9)}`);
    el.setAttribute('tabindex', '0');
  });

  onUnmounted(() => {
    clearInterval(intervalId);
  });
});
</script>
              
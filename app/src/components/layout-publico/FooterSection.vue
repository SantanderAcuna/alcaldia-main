<template>
  <footer class="py-4 mt-8 text-white">
    <div class="container">
      <div class="row g-4">
        <!-- Columna 1: Información Institucional -->
        <div class="col-md-4">
          <h5 class="mb-3">Datos Oficiales</h5>
          <div class="mb-3">
            <p class="mb-1">NIT 891780009</p>
            <address class="mb-1">
              Calle 14 No. 2 - 49<br />
              Palacio Municipal<br />
              Santa Marta, Colombia
            </address>
          </div>

          <div class="mb-3">
            <h6 class="mb-2">Contacto Principal</h6>
            <ul class="list-unstyled">
              <li>
                Teléfono:
                <a href="tel:+5754209600" class="text-white">(5) 420 9600</a>
              </li>
              <li>Extensión: 1212</li>
              <li>Línea Gratuita: 420 9600</li>
              <li>Línea Anticorrupción: 420 9600</li>
            </ul>
          </div>
        </div>

        <!-- Columna 2: Horarios y Atención -->
        <div class="col-md-4">
          <h5 class="mb-3">Horarios de Servicio</h5>
          <div class="mb-3">
            <h6 class="mb-2">Atención General</h6>
            <p>
              Lunes a Viernes<br />
              8:00 a.m. - 12:00 p.m.<br />
              2:00 p.m. - 6:00 p.m.
            </p>

            <div class="p-2 text-white" role="note">
              <small>Horario de radicación:<br />
                8:00 a.m. - 5:00 p.m.</small>
            </div>
          </div>

          <h6 class="mb-2">Canales Especializados</h6>
          <ul class="list-unstyled">
            <li>
              <strong>Atención al Ciudadano:</strong><br />
              <a href="mailto:atencionalciudadano@santamarta.gov.co" class="text-white">
                atencionalciudadano@santamarta.gov.co
              </a>
            </li>
            <li class="mt-2">
              <strong>Notificaciones Judiciales:</strong><br />
              <a href="mailto:notificacionesalcaldiadistrital@santamarta.gov.co" class="text-white">
                notificacionesalcaldiadistrital@santamarta.gov.co
              </a>
              <div class="text-warning">
                <small>Exclusivo para temas jurídicos</small>
              </div>
            </li>
          </ul>
        </div>

        <!-- Columna 3: Enlaces y Legal -->
        <div class="col-md-4">
          <div class="row">
            <!-- Subcolumna 1: Enlaces -->
            <div class="col-6">
              <h5 class="mb-3">Servicios</h5>
              <ul class="list-unstyled">
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-shield-alt me-2"></i>Transparencia
                  </a>
                </li>
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-archive me-2"></i>Documentos
                  </a>
                </li>
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-sign-in-alt me-2"></i>Humano
                  </a>
                </li>
              </ul>
            </div>

            <!-- Subcolumna 2: Legal -->
            <div class="col-6">
              <h5 class="mb-3">Legal</h5>
              <ul class="list-unstyled">
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-user-shield me-2"></i>Protección de datos
                  </a>
                </li>
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-balance-scale me-2"></i>Términos y condiciones
                  </a>
                </li>
                <li class="mb-2">
                  <a href="#" class="text-white text-decoration-none">
                    <i class="fas fa-map me-2"></i>Mapa del sitio
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <!-- Redes Sociales -->
          <h5 class="mt-4">Conecta con nosotros</h5>
          <div class="gap-3 d-flex">
            <a href="#" class="text-white" aria-label="Facebook">
              <i class="fab fa-facebook fa-2x"></i>
            </a>
            <a href="#" class="text-white" aria-label="Twitter">
              <i class="fab fa-twitter fa-2x"></i>
            </a>
            <a href="#" class="text-white" aria-label="Instagram">
              <i class="fab fa-instagram fa-2x"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Sección Inferior: Logos y Copyright -->
      <div class="pt-3 mt-4 text-center border-top">
        <div class="mb-3">
          <img :src="logo500Or" alt="500 Años" class="img-fluid" style="max-height: 80px" loading="lazy" />
          <img :src="logoGovCo" alt="Gobierno de Colombia" class="img-fluid" style="height: 50px" loading="lazy" />
          <img :src="logoColombia" alt="Marca Colombia" class="img-fluid me-4" style="height: 50px" loading="lazy" />
        </div>

        <p class="mb-0">
          <i class="fas fa-copyright me-2"></i>2025 Alcaldía Distrital de Santa Marta<br />
          <small class="text-white-50">Todos los derechos reservados</small><br />
          <small class="text-warning">Ciudad Patrimonio de Colombia</small>
        </p>
      </div>

      <!-- Reloj -->
      <div class="mt-3 text-center">
        <div id="reloj" class="reloj-digital" role="timer" aria-live="polite">
          <span>HORA LEGAL REPÚBLICA DE COLOMBIA</span>
          <div id="hora-actual" class="h4">{{ horaActual }}</div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'FooterSection',
  data() {
    return {
      logo500Or: new URL('@/assets/img/logo500Or.png', import.meta.url).href, // Ruta a la imagen
      logoGovCo: new URL('@/assets/img/logo.svg', import.meta.url).href, // Ruta a la imagen
      logoColombia: new URL('@/assets/img/logo_co.svg', import.meta.url).href, // Ruta a la imagen
      horaActual: '', // Hora actual
    };
  },
  methods: {
    actualizarReloj() {
      const ahora = new Date();
      const opciones = { timeZone: 'America/Bogota' };
      this.horaActual = ahora.toLocaleTimeString('es-CO', opciones);
    },
  },
  mounted() {
    // Iniciar el reloj
    this.actualizarReloj();
    setInterval(this.actualizarReloj, 1000);
  },
};
</script>


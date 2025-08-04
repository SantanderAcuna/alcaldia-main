<template>
  <!-- Barra de navegación -->
  <nav
    class="navbar navbar-expand-lg"
    role="navigation"
    aria-label="Menú principal"
    style="background-color: #00ade7"
  >
    <div class="container-fluid">
      <!-- Botón hamburguesa para móviles -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarMegaMenu"
        aria-controls="navbarMegaMenu"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú principal -->
      <div class="collapse navbar-collapse" id="navbarMegaMenu">
        <ul class="mx-auto mb-2 navbar-nav mb-lg-0">
          <!-- (0) INICIO -->
          <li class="nav-item">
            <RouterLink class="nav-link" to="/admin" aria-label="Inicio">
              <i class="fas fa-home"></i> Inicio
            </RouterLink>
          </li>

          <!-- (1) SANTA MARTA -->
          <li class="nav-item dropdown position-static" role="none">
            <!-- Activador del dropdown corregido -->
            <router-link
              class="nav-link dropdown-toggle"
              to="#"
              id="santaMartaDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              role="menuitem"
              aria-label="Santa Marta"
            >
              <i class="fas fa-city me-2" aria-hidden="true"></i>
              Santa Marta
            </router-link>

            <!-- Contenido del mega menú (se mantiene igual) -->
            <div
              class="dropdown-menu mega-menu"
              style="background-color: #00568d"
              aria-labelledby="santaMartaDropdown"
            >
              <div class="p-3 row" style="max-height: 400px; overflow-y: auto">
                <!-- Columna 1: Visita Santa Marta -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-map-marked-alt me-2"></i>Visita Santa Marta</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/como-llegar"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-map-signs me-2"></i>Cómo llegar
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/para-visitar"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-search-location me-2"></i>Para visitar
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/playas-reservas"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-umbrella-beach me-2"></i>Playas y Reservas
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/parques-plazas"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-tree me-2"></i>Parques y plazas
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/bibliotecas"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-book-reader me-2"></i>Bibliotecas
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/museos"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-landmark me-2"></i>Museos
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/monumentos"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-archway me-2"></i>Monumentos
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/datos-utiles"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-info-circle me-2"></i>Datos útiles
                      </router-link>
                    </li>
                  </ul>
                </div>

                <!-- Columna 2: Vive en Santa Marta -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-home me-2"></i>Vive en Santa Marta</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/geografia"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-globe-americas me-2"></i>Geografía
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/historia"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-history me-2"></i>Historia
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/simbolos"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-flag me-2"></i>Símbolos
                      </router-link>
                    </li>
                  </ul>
                </div>

                <!-- Columna 3: Visitar (Original) -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-map me-2"></i>Visitar (Original)</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/mapa-turistico"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-map me-2"></i>Mapa Turístico
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/playas"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-umbrella-beach me-2"></i>Playas
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/ecoturismo"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-leaf me-2"></i>Ecoturismo
                      </router-link>
                    </li>
                  </ul>
                </div>

                <!-- Columna 4: Vivir (Original) -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-users me-2"></i>Vivir (Original)</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/transporte"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-bus me-2"></i>Transporte
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/educacion"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-graduation-cap me-2"></i>Educación
                      </router-link>
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item"
                        to="/admin/salud"
                        @click="cerrarTodosLosDropdowns"
                      >
                        <i class="fas fa-heartbeat me-2"></i>Salud
                      </router-link>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <!-- (2) NUESTRA ALCALDÍA -->
          <li class="nav-item dropdown position-static" role="none">
            <router-link
              class="nav-link dropdown-toggle"
              to="#"
              id="nuestraAlcaldiaDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              role="menuitem"
              aria-label="Nuestra Alcaldía"
            >
              <i class="fas fa-university me-2" aria-hidden="true"></i>
              Nuestra Alcaldía
            </router-link>
            <div
              class="dropdown-menu mega-menu"
              style="background-color: #00568d"
              aria-labelledby="nuestraAlcaldiaDropdown"
            >
              <div class="p-3 row" style="max-height: 400px; overflow-y: auto">
                <!-- Columna 1: Estructura -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-sitemap me-2"></i>Estructura</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="admin//gabinete"
                        ><i class="fas fa-users-cog me-2"></i>Gabinete</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//dependencias"
                        ><i class="fas fa-building me-2"></i>Dependencias</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/alcaldes/actual/1"
                        ><i class="fas fa-user-tie me-2"></i>Carlos Pinedo (2024-2027)</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/directorio-distrital"
                        ><i class="fas fa-address-book me-2"></i>Directorio Distrital</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/alcaldes"
                        ><i class="fas fa-history me-2"></i>Alcaldes Anteriores</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 2: Nuestra Gestión -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-tasks me-2"></i>Nuestra Gestión</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/cronograma"
                        ><i class="fas fa-calendar-alt me-2"></i>Cronograma</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/circular-011"
                        ><i class="fas fa-file-medical-alt me-2"></i>Circular 011
                        Supersalud</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/obras-cambio"
                        ><i class="fas fa-hard-hat me-2"></i>Obras para el Cambio</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/centros-referenciacion"
                        ><i class="fas fa-hospital-user me-2"></i>Centros de
                        Referenciación</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/santa-marta-500"
                        ><i class="fas fa-flag-checkered me-2"></i>Plan Santa Marta 500
                        años</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/plan"
                        ><i class="fas fa-flag-checkered me-2"></i>Plan de desarrollo</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/gestion-2020"
                        ><i class="fas fa-tasks me-2"></i>Gestión 2020</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/juegos-bolivarianos"
                        ><i class="fas fa-medal me-2"></i>Los XVIII Juegos Bolivarianos de
                        2017</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 3: Programas y Proyectos -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-project-diagram me-2"></i>Programas y Proyectos</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/ferias-equidad"
                        ><i class="fas fa-balance-scale me-2"></i>Ferias de la Equidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/adulto-mayor"
                        ><i class="fas fa-user-friends me-2"></i>Adulto Mayor</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/mi-calle"
                        ><i class="fas fa-road me-2"></i>Mi Calle</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/pae"
                        ><i class="fas fa-utensils me-2"></i>Alimentación Escolar (PAE)</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/legalizacion-barrios"
                        ><i class="fas fa-home me-2"></i>Legalización de Barrios</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/bancarizacion-vivienda"
                        ><i class="fas fa-piggy-bank me-2"></i>Bancarización y Vivienda</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/pot"
                        ><i class="fas fa-map-marked-alt me-2"></i>Plan de Ordenamiento
                        Territorial</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/red-equidad"
                        ><i class="fas fa-handshake me-2"></i>Red equidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/bienestar-animal"
                        ><i class="fas fa-paw me-2"></i>Atención y Bienestar Animal</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/movilizacion-educacion"
                        ><i class="fas fa-chalkboard-teacher me-2"></i>Movilización Social por la
                        Educación</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 4: Plan de Desarrollo (extra) -->
                <div class="col-12 col-lg-3">
                  <h6 class="mt-3"><i class="fas fa-chart-line me-2"></i>Plan de Desarrollo</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/pdd-2012-2015"
                        ><i class="fas fa-calendar-check me-2"></i>PDD 2012-2015</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/pdd-2016-2019"
                        ><i class="fas fa-calendar-check me-2"></i>PDD 2016-2019</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/pdd-2020-2023"
                        ><i class="fas fa-calendar-check me-2"></i>PDD 2020-2023</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//pdd-2024-2027"
                        ><i class="fas fa-calendar-check me-2"></i>PDD 2024-2027</router-link
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <!-- (3) TRANSPARENCIA -->
          <li class="nav-item dropdown position-static" role="none">
            <router-link
              class="nav-link dropdown-toggle"
              to="#"
              id="transparenciaDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              role="menuitem"
              aria-label="Transparencia"
            >
              <i class="fas fa-file-contract me-2" aria-hidden="true"></i>
              Transparencia
            </router-link>
            <div
              class="dropdown-menu mega-menu"
              style="background-color: #00568d"
              aria-labelledby="transparenciaDropdown"
            >
              <div class="p-3 row" style="max-height: 400px; overflow-y: auto">
                <!-- Columna 1: Rendición de Cuentas -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-balance-scale me-2"></i>Rendición de Cuentas</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/rendicion-cuentas"
                        ><i class="fas fa-chart-bar me-2"></i>Rendición de cuentas</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/informe-control-interno"
                        ><i class="fas fa-file-invoice me-2"></i>Informe de Control
                        Interno</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/transparencia-informacion"
                        ><i class="fas fa-eye me-2"></i>Transparencia y Acceso a la Información
                        Pública</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/concurso-curadores-2016"
                        ><i class="fas fa-gavel me-2"></i>Concurso curadores 2016</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/sistema-gestion"
                        ><i class="fas fa-cogs me-2"></i>Sistema Integrado de Gestión</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//contratacion"
                        ><i class="fas fa-file-signature me-2"></i>Contratación</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/concurso-curadores-2018"
                        ><i class="fas fa-gavel me-2"></i>Concurso Curadores 2018</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 2: Participación Ciudadana -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-users me-2"></i>Participación Ciudadana</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/fodca-2022"
                        ><i class="fas fa-paint-brush me-2"></i>Fondo Distrital para la Cultura y
                        las Artes - FODCA 2022</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/fodca-2023"
                        ><i class="fas fa-palette me-2"></i>Fondo Distrital para la Cultura y las
                        Artes - FODCA 2023</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/convocatoria-obras-menores"
                        ><i class="fas fa-tools me-2"></i>Convocatoria Programa Con Obras Menores El
                        Cambio Es Imparable 2022</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/turismo-emprende"
                        ><i class="fas fa-route me-2"></i>Fondo de Fomento al Emprendimiento
                        Turístico "Turismo Emprende" 2022</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/presupuesto-participativo"
                        ><i class="fas fa-poll me-2"></i>Encuesta de presupuesto
                        participativo</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 3: 1ra parte Convocatorias 2022-2025 -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-bullhorn me-2"></i>Convocatorias 2022-2025</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-essmar-2022-2025"
                        ><i class="fas fa-user-tie me-2"></i>Convocatoria para Jefe De Oficina de la
                        ESSMAR periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-dadsa-2022-2025"
                        ><i class="fas fa-user-tie me-2"></i>Convocatoria para Jefe De Oficina del
                        DADSA periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-control-ese"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria para Jefe de Control
                        Interno ESE Alejandro Prospero Reverend periodo 2022 a 2025</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/jefe-essmar-2022-2025-2"
                        ><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina de la
                        ESSMAR periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/jefe-dadsa-2022-2025-2"
                        ><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina del DADSA
                        periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-oficina-alcaldia"
                        ><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina de
                        ALCALDÍA periodo 2022-2025</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 4: 2da parte Convocatorias 2022-2025 -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-bullhorn me-2"></i>Convocatorias 2022-2025</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-control-interno"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe De Oficina de
                        Control Interno Planta Central 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/asesor-control-inred"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Asesor de Control
                        Interno de INRED periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-control-setp"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno
                        SETP periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link
                        class="dropdown-item text-wrap"
                        to="/admin/asesor-auditor-indetur"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Asesor Auditor de
                        Control Interno de Indetur periodo 2022-2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-control-ese-2"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno
                        ESE Alejandro Prospero Reverend periodo 2022 a 2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item text-wrap" to="/admin/jefe-control-edus"
                        ><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno
                        EDUS periodo 2022 a 2025</router-link
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <!-- (4) SALA DE PRENSA -->
          <li class="nav-item dropdown position-static" role="none">
            <router-link
              class="nav-link dropdown-toggle"
              to="#"
              id="prensaDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              role="menuitem"
              aria-label="Sala de Prensa"
            >
              <i class="fas fa-newspaper me-2" aria-hidden="true"></i>
              Sala de Prensa
            </router-link>
            <div
              class="dropdown-menu mega-menu"
              style="background-color: #00568d"
              aria-labelledby="prensaDropdown"
            >
              <div class="p-3 row" style="max-height: 400px; overflow-y: auto">
                <!-- Columna 1: Noticias -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-calendar-alt me-2"></i>Noticias</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="admin//noticias-2025"
                        ><i class="fas fa-calendar me-2"></i>Noticias 2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//noticias-2024"
                        ><i class="fas fa-calendar me-2"></i>Noticias 2024</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//noticias-2022"
                        ><i class="fas fa-calendar me-2"></i>Noticias 2022</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//noticias-2021"
                        ><i class="fas fa-calendar me-2"></i>Noticias 2021</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//noticias-2020"
                        ><i class="fas fa-calendar me-2"></i>Noticias 2020</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 2: Audiovisuales -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-camera me-2"></i>Audiovisuales</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="admin//fotos"
                        ><i class="fas fa-images me-2"></i>Fotos</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//audios"
                        ><i class="fas fa-headphones me-2"></i>Audios</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//videos"
                        ><i class="fas fa-video me-2"></i>Videos</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/brochure"
                        ><i class="fas fa-file-pdf me-2"></i>Brochure digital</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 3: Información (Documentos) -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-file-alt me-2"></i>Informacion</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/publicaciones"
                        ><i class="fas fa-book me-2"></i>Publicaciones</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/cultura"
                        ><i class="fas fa-theater-masks me-2"></i>Cultura</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/educacion"
                        ><i class="fas fa-graduation-cap me-2"></i>Educación</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/seguridad"
                        ><i class="fas fa-shield-alt me-2"></i>Seguridad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/deportes"
                        ><i class="fas fa-football-ball me-2"></i>Deportes</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/salud"
                        ><i class="fas fa-heartbeat me-2"></i>Salud</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/movilidad"
                        ><i class="fas fa-bus me-2"></i>Movilidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/ciudadania"
                        ><i class="fas fa-id-card me-2"></i>Ciudadanía</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 4: Gacetas -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-book-open me-2"></i>Gacetas</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/gaceta-2025"
                        ><i class="fas fa-scroll me-2"></i>Gaceta 2025</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/gacetas-anteriores"
                        ><i class="fas fa-archive me-2"></i>Gacetas anteriores</router-link
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </li>

          <!-- (5) ATENCIÓN AL CIUDADANO -->
          <li class="nav-item dropdown position-static" role="none">
            <router-link
              class="nav-link dropdown-toggle"
              to="#"
              id="atencionDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              role="menuitem"
              aria-label="Atención al Ciudadano"
            >
              <i class="fas fa-address-book me-2" aria-hidden="true"></i>
              Atención al Ciudadano
            </router-link>
            <div
              class="dropdown-menu mega-menu"
              style="background-color: #00568d"
              aria-labelledby="atencionDropdown"
            >
              <div class="p-3 row" style="max-height: 400px; overflow-y: auto">
                <!-- Columna 1 -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-users me-2"></i>Atención al Ciudadano</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="admin//pqrsd"
                        ><i class="fas fa-comment-alt me-2"></i>PQRSD</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//eventos"
                        ><i class="fas fa-calendar-day me-2"></i>Eventos</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//glosario"
                        ><i class="fas fa-book me-2"></i>Glosario</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="admin//accesibilidad"
                        ><i class="fas fa-universal-access me-2"></i>Accesibilidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/manual-protocolos"
                        ><i class="fas fa-file-invoice me-2"></i>Manual y Protocolos</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/directorio-distrital"
                        ><i class="fas fa-address-book me-2"></i>Directorio Distrital</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/preguntas-frecuentes"
                        ><i class="fas fa-question-circle me-2"></i>Preguntas
                        Frecuentes</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/informacion"
                        ><i class="fas fa-info-circle me-2"></i>Informacion</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/tramites-servicios"
                        ><i class="fas fa-file-alt me-2"></i>Trámites y servicios</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 2 -->
                <div class="col-12 col-lg-3">
                  <h6><i class="fas fa-file-alt me-2"></i>Trámites y servicios</h6>
                  <ul class="list-unstyled">
                    <li>
                      <router-link class="dropdown-item" to="/admin/urbanismo"
                        ><i class="fas fa-city me-2"></i>Urbanismo</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/familias-accion"
                        ><i class="fas fa-users me-2"></i>Familias en acción</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/movilidad"
                        ><i class="fas fa-bus me-2"></i>Movilidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/adulto-mayor"
                        ><i class="fas fa-user-clock me-2"></i>Adulto Mayor</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/sisben"
                        ><i class="fas fa-address-book me-2"></i>Sisben</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/discapacidad"
                        ><i class="fas fa-wheelchair me-2"></i>Discapacidad</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/infancia-adolescencia"
                        ><i class="fas fa-child me-2"></i>Infancia y Adolescencia</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/seguridad-convivencia"
                        ><i class="fas fa-shield-alt me-2"></i>Seguridad y Convivencia</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/salud"
                        ><i class="fas fa-heartbeat me-2"></i>Salud</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/cultura"
                        ><i class="fas fa-palette me-2"></i>Cultura</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/atencion-victimas"
                        ><i class="fas fa-users-cog me-2"></i>Atención a víctimas</router-link
                      >
                    </li>
                    <li>
                      <router-link class="dropdown-item" to="/admin/gestion-riesgo"
                        ><i class="fas fa-exclamation-triangle me-2"></i>Gestión del
                        Riesgo</router-link
                      >
                    </li>
                  </ul>
                </div>
                <!-- Columna 3 -->
                <div class="col-12 col-lg-3">
                  <ul class="mt-4 list-unstyled mt-lg-0"></ul>
                </div>
                <!-- Columna 4 -->
                <div class="col-12 col-lg-3">
                  <ul class="mt-4 list-unstyled mt-lg-0"></ul>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import * as bootstrap from 'bootstrap';

// ✅ Acceso al router
const router = useRouter();

// ✅ Función para cerrar dropdowns de Bootstrap
function cerrarTodosLosDropdowns() {
  const toggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');
  toggles.forEach((toggle) => {
    const instance = window.bootstrap?.Dropdown.getInstance(toggle);
    if (instance) instance.hide();
  });
}

// ✅ Ejecutar al cargar componente y en cada cambio de ruta
onMounted(() => {
  router.afterEach(() => {
    cerrarTodosLosDropdowns();
  });
});
</script>

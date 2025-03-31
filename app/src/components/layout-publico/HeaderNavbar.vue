<template>
    <div>
      <!-- Barra de Accesibilidad Derecha -->
      <div class="content-example-barra">
        <div class="barra-accesibilidad-govco">
          <!-- Botones existentes -->
          <button id="botoncontraste" @click="cambiarContexto" title="Cambiar contraste">
            <i class="fas fa-adjust"></i>
            <span class="sr-only">Alternar modo alto contraste</span>
            <span class="hover-text">Cambiar contraste</span>
          </button>
  
          <button id="botonaumentar" @click="aumentarTamanio" title="Aumentar tamaño">
            <i class="fas fa-plus"></i>
            <span class="sr-only">Incrementar tamaño de fuente</span>
            <span class="hover-text">Aumentar tamaño</span>
          </button>
  
          <button id="botondisminuir" @click="disminuirTamanio" title="Disminuir tamaño">
            <i class="fas fa-minus"></i>
            <span class="sr-only">Reducir tamaño de fuente</span>
            <span class="hover-text">Disminuir tamaño</span>
          </button>
  
          <!-- Nuevo botón con icono personalizado -->
          <button id="botonrelevo" @click="irCentroRelevo" title="Centro de relevo"
            aria-label="Acceder al centro de relevo de comunicaciones">
            <img :src="relevoIcon" alt="" aria-hidden="true" class="icono-relevo" />
            <span class="hover-text">Centro de relevo</span>
          </button>
        </div>
      </div>
  
      <!-- Header con Navegación Superior -->
      <header>
        <!-- Navegación Superior -->
        <nav class="py-2 navbar navbar-expand-lg border-bottom" style="background-color: #00568d">
          <div class="container">
            <a href="https://www.gov.co/" target="_blank" rel="noopener">
              <img :src="logoIcon" alt="GOV.CO" style="height: 40px" />
            </a>
            <div class="gap-4 d-flex align-items-center">
              <button class="btn btn-sm btn-outline-light">
                <i class="fas fa-globe me-1"></i>EN
              </button>
              <div class="gap-3 d-none d-md-flex">
                <a href="#" class="text-white small">
                  <i class="fas fa-universal-access me-1"></i>Accesibilidad
                </a>
                <a href="#" class="text-white small">
                  <i class="fas fa-sitemap me-1"></i>Mapa del sitio
                </a>
              </div>
            </div>
          </div>
        </nav>
  
        <!-- Logos Institucionales -->
        <div class="container py-4">
          <div class="flex-wrap d-flex align-items-center justify-content-between">
            <div class="flex-wrap gap-4 d-flex align-items-center">
              <img :src="logo500Icon" alt="500 Años" class="img-fluid" style="max-height: 80px" loading="lazy" />
              <img :src="catastralIcon" alt="Catastro" class="img-fluid" style="max-height: 90px" loading="lazy" />
            </div>
  
            <div class="gap-3 d-none d-lg-flex">
              <a href="#" class="text-dark"><i class="fab fa-facebook fa-lg"></i></a>
              <a href="#" class="text-dark"><i class="fab fa-twitter fa-lg"></i></a>
              <a href="#" class="text-dark"><i class="fab fa-instagram fa-lg"></i></a>
              <a href="#" class="text-dark"><i class="fab fa-youtube fa-lg"></i></a>
            </div>
          </div>
        </div>
  
        <!-- Barra de navegación -->
        <nav class="navbar navbar-expand-lg" role="navigation" aria-label="Menú principal" style="background-color: #00ade7">
          <div class="container-fluid">
            <!-- Botón hamburguesa para móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMegaMenu"
              aria-controls="navbarMegaMenu" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
  
            <!-- Menú principal -->
            <div class="collapse navbar-collapse" id="navbarMegaMenu">
              <ul class="mx-auto mb-2 navbar-nav mb-lg-0"> 
                <!-- (1) SANTA MARTA -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="santaMartaDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Santa Marta">
                    <i class="fas fa-city me-2" aria-hidden="true"></i>
                    Santa Marta
                  </a>
                  <div class="dropdown-menu mega-menu " style="background-color: #00568d" aria-labelledby="santaMartaDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1: Visita Santa Marta -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-map-marked-alt me-2"></i>Visita Santa Marta</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-map-signs me-2"></i>Cómo llegar</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-search-location me-2"></i>Para visitar</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-umbrella-beach me-2"></i>Playas y Reservas Naturales</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-tree me-2"></i>Parques y plazas</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-book-reader me-2"></i>Bibliotecas</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-landmark me-2"></i>Museos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-archway me-2"></i>Monumentos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle me-2"></i>Datos útiles para el viajero</a></li>
                        </ul>
                      </div>
                      <!-- Columna 2: Vive en Santa Marta -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-home me-2"></i>Vive en Santa Marta</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-globe-americas me-2"></i>Geografía</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Historia</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-flag me-2"></i>Símbolos</a></li>
                        </ul>
                      </div>
                      <!-- Columna 3: Visitar (Original) -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-map me-2"></i>Visitar (Original)</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-map me-2"></i>Mapa Turístico</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-umbrella-beach me-2"></i>Playas</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-leaf me-2"></i>Ecoturismo</a></li>
                        </ul>
                      </div>
                      <!-- Columna 4: Vivir (Original) -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-users me-2"></i>Vivir (Original)</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-bus me-2"></i>Transporte</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-graduation-cap me-2"></i>Educación</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-heartbeat me-2"></i>Salud</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
  
                <!-- (2) NUESTRA ALCALDÍA -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="nuestraAlcaldiaDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Nuestra Alcaldía">
                    <i class="fas fa-university me-2" aria-hidden="true"></i>
                    Nuestra Alcaldía
                  </a>
                  <div class="dropdown-menu mega-menu" style="background-color: #00568d" aria-labelledby="nuestraAlcaldiaDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1: Estructura -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-sitemap me-2"></i>Estructura</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-users-cog me-2"></i>Gabinete</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-building me-2"></i>Dependencias</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie me-2"></i>Carlos Pinedo (2024-2027)</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie me-2"></i>Virna Johnson (2020–2023)</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie me-2"></i>Rafael Martínez (2016–2019)</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie me-2"></i>Carlos Caicedo (2012–2015)</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-address-book me-2"></i>Directorio Distrital</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Alcaldes Anteriores</a></li>
                        </ul>
                      </div>
                      <!-- Columna 2: Nuestra Gestión -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-tasks me-2"></i>Nuestra Gestión</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt me-2"></i>Cronograma</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-medical-alt me-2"></i>Circular 011 Supersalud</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-hard-hat me-2"></i>Obras para el Cambio</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-hospital-user me-2"></i>Centros de Referenciación</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-flag-checkered me-2"></i>Plan Santa Marta 500 años</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-tasks me-2"></i>Gestión 2020</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-medal me-2"></i>Los XVIII Juegos Bolivarianos de 2017</a></li>
                        </ul>
                      </div>
                      <!-- Columna 3: Programas y Proyectos -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-project-diagram me-2"></i>Programas y Proyectos</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-balance-scale me-2"></i>Ferias de la Equidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-friends me-2"></i>Adulto Mayor</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-road me-2"></i>Mi Calle</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-utensils me-2"></i>Alimentación Escolar (PAE)</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-home me-2"></i>Legalización de Barrios</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-piggy-bank me-2"></i>Bancarización y Vivienda</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-map-marked-alt me-2"></i>Plan de Ordenamiento Territorial</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-handshake me-2"></i>Red equidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-paw me-2"></i>Atención y Bienestar Animal</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-chalkboard-teacher me-2"></i>Movilización Social por la Educación</a></li>
                        </ul>
                      </div>
                      <!-- Columna 4: Plan de Desarrollo (extra) -->
                      <div class="col-12 col-lg-3">
                        <h6 class="mt-3"><i class="fas fa-chart-line me-2"></i>Plan de Desarrollo</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-check me-2"></i>PDD 2012-2015</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-check me-2"></i>PDD 2016-2019</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-check me-2"></i>PDD 2020-2023</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-check me-2"></i>PDD 2024-2027</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
  
                <!-- (3) TRANSPARENCIA -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="transparenciaDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Transparencia">
                    <i class="fas fa-file-contract me-2" aria-hidden="true"></i>
                    Transparencia
                  </a>
                  <div class="dropdown-menu mega-menu" style="background-color: #00568d" aria-labelledby="transparenciaDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1: Rendición de Cuentas -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-balance-scale me-2"></i>Rendición de Cuentas</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar me-2"></i>Rendición de cuentas</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-2"></i>Informe de Control Interno</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-eye me-2"></i>Transparencia y Acceso a la  Información Pública</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-gavel me-2"></i>Concurso curadores 2016</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-cogs me-2"></i>Sistema Integrado de Gestión</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-signature me-2"></i>Contratación</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-gavel me-2"></i>Concurso Curadores 2018</a></li>
                        </ul>
                      </div>
                      <!-- Columna 2: Participación Ciudadana -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-users me-2"></i>Participación Ciudadana</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-paint-brush me-2"></i>Fondo Distrital para la Cultura y las Artes - FODCA 2022</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-palette me-2"></i>Fondo Distrital para la Cultura y las Artes - FODCA 2023</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-tools me-2"></i>Convocatoria Programa Con Obras Menores El Cambio Es Imparable 2022</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-route me-2"></i>Fondo de Fomento al Emprendimiento Turístico "Turismo Emprende" 2022</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-poll me-2"></i>Encuesta de presupuesto participativo</a></li>
                        </ul>
                      </div>
                      <!-- Columna 3: 1ra parte Convocatorias 2022-2025 -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-bullhorn me-2"></i>Convocatorias 2022-2025</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-tie me-2"></i>Convocatoria para Jefe De Oficina de la  ESSMAR periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-tie me-2"></i>Convocatoria para Jefe De Oficina del  DADSA periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria para Jefe de Control Interno  ESE Alejandro Prospero Reverend periodo 2022 a 2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina de la ESSMAR  periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina del DADSA  periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-tie me-2"></i>Convocatoria Jefe De Oficina de ALCALDÍA  periodo 2022-2025</a></li>
                        </ul>
                      </div>
                      <!-- Columna 4: 2da parte Convocatorias 2022-2025 -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-bullhorn me-2"></i>Convocatorias 2022-2025</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe De Oficina de Control Interno Planta Central 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Asesor de Control Interno de INRED periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno SETP periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Asesor Auditor de Control Interno de Indetur periodo 2022-2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno ESE Alejandro Prospero Reverend periodo 2022 a 2025</a></li>
                          <li><a class="dropdown-item text-wrap" href="#"><i class="fas fa-user-shield me-2"></i>Convocatoria Jefe Control Interno EDUS periodo 2022 a 2025</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
  
                <!-- (4) SALA DE PRENSA -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="prensaDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Sala de Prensa">
                    <i class="fas fa-newspaper me-2" aria-hidden="true"></i>
                    Sala de Prensa
                  </a>
                  <div class="dropdown-menu mega-menu" style="background-color: #00568d" aria-labelledby="prensaDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1: Noticias -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-calendar-alt me-2"></i>Noticias</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Noticias 2025</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Noticias 2024</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Noticias 2022</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Noticias 2021</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2"></i>Noticias 2020</a></li>
                        </ul>
                      </div>
                      <!-- Columna 2: Audiovisuales -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-camera me-2"></i>Audiovisuales</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-images me-2"></i>Fotos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-headphones me-2"></i>Audios</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-video me-2"></i>Videos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>Brochure digital</a></li>
                        </ul>
                      </div>
                      <!-- Columna 3: Información (Documentos) -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-file-alt me-2"></i>Informacion</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-book me-2"></i>Publicaciones</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-theater-masks me-2"></i>Cultura</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-graduation-cap me-2"></i>Educación</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-shield-alt me-2"></i>Seguridad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-football-ball me-2"></i>Deportes</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-heartbeat me-2"></i>Salud</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-bus me-2"></i>Movilidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i>Ciudadanía</a></li>
                        </ul>
                      </div>
                      <!-- Columna 4: Gacetas -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-book-open me-2"></i>Gacetas</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-scroll me-2"></i>Gaceta 2025</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-archive me-2"></i>Gacetas anteriores</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </li>
  
                <!-- (5) ATENCIÓN AL CIUDADANO -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="atencionDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Atención al Ciudadano">
                    <i class="fas fa-address-book me-2" aria-hidden="true"></i>
                    Atención al Ciudadano
                  </a>
                  <div class="dropdown-menu mega-menu" style="background-color: #00568d" aria-labelledby="atencionDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1 -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-users me-2"></i>Atención al Ciudadano</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-comment-alt me-2"></i>PQRSD</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-day me-2"></i>Eventos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-book me-2"></i>Glosario</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-universal-access me-2"></i>Accesibilidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-2"></i>Manual y Protocolos</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-address-book me-2"></i>Directorio Distrital</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle me-2"></i>Informacion</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt me-2"></i>Trámites y servicios</a></li>
                        </ul>
                      </div>
                      <!-- Columna 2 -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-file-alt me-2"></i>Trámites y servicios</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-city me-2"></i>Urbanismo</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>Familias en acción</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-bus me-2"></i>Movilidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-user-clock me-2"></i>Adulto Mayor</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-address-book me-2"></i>Sisben</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-wheelchair me-2"></i>Discapacidad</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-child me-2"></i>Infancia y Adolescencia</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-shield-alt me-2"></i>Seguridad y Convivencia</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-heartbeat me-2"></i>Salud</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-palette me-2"></i>Cultura</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-users-cog me-2"></i>Atención a víctimas</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-exclamation-triangle me-2"></i>Gestión del Riesgo</a></li>
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
  
                <!-- (6) Organismos -->
                <li class="nav-item dropdown position-static" role="none">
                  <a class="nav-link dropdown-toggle" href="#" id="organismosDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false" role="menuitem" aria-label="Organismos">
                    <i class="fas fa-sitemap me-2" aria-hidden="true"></i>
                    Organismos
                  </a>
                  <div class="dropdown-menu mega-menu" style="background-color: #00568d" aria-labelledby="organismosDropdown">
                    <div class="p-3 row" style="max-height: 400px; overflow-y: auto;">
                      <!-- Columna 1: Secretarías -->
                      <div class="col-12 col-lg-3">
                        <h6><i class="fas fa-users-cog me-2"></i>Secretarías</h6>
                        <ul class="list-unstyled">
                          <li><a class="dropdown-item" href="#"><i class="fas fa-money-bill-wave me-2"></i>Sec. Hacienda</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-graduation-cap me-2"></i>Sec. Educación</a></li>
                          <li><a class="dropdown-item" href="#"><i class="fas fa-venus me-2"></i>Sec. Mujer</a></li>
                        </ul>
                      </div>
                      <!-- Otras columnas vacías -->
                      <div class="col-12 col-lg-3"></div>
                      <div class="col-12 col-lg-3"></div>
                      <div class="col-12 col-lg-3"></div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
    </div>
  </template>
  
  <script>
  import relevoIcon from '@/assets/img/1.jpg';
  import logoIcon from '@/assets/img/1.jpg';
  import logo500Icon from '@/assets/img/1.jpg';
  import catastralIcon from '@/assets/img/1.jpg';
 
  
  export default {
    name: 'AccessibilityBar',
    data() {
      return {
        relevoIcon,
        logoIcon,
        logo500Icon,
        catastralIcon
      };
    },
    methods: {
      cambiarContexto() {
        console.log('Cambiando contraste...');
      },
      aumentarTamanio() {
        console.log('Aumentando tamaño de la fuente...');
      },
      disminuirTamanio() {
        console.log('Disminuyendo tamaño de la fuente...');
      },
      irCentroRelevo() {
        console.log('Yendo al centro de relevo...');
      }
    }
  };
  </script>
  

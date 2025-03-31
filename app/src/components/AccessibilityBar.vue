<template>
    <div class="accessibility-bar">
      <!-- Botones de accesibilidad -->
      <button id="botoncontraste" @click="cambiarContexto">
        <i class="fas fa-adjust"></i> Cambiar contraste
      </button>
      <button id="botonaumentar" @click="aumentarTamanio">
        <i class="fas fa-plus"></i> Aumentar tamaño
      </button>
      <button id="botondisminuir" @click="disminuirTamanio">
        <i class="fas fa-minus"></i> Disminuir tamaño
      </button>
      <button id="botonrelevo" @click="irCentroRelevo">
        <i class="fas fa-external-link-alt"></i> Centro de relevo
      </button>
  
      <!-- Reloj -->
      <div id="hora-actual">{{ horaActual }}</div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AccessibilityBar',
    data() {
      return {
        modoOscuro: localStorage.getItem('modoOscuro') === 'true',
        fontSize: parseInt(localStorage.getItem('fontSize')) || 16,
        horaActual: '',
      };
    },
    methods: {
      cambiarContexto(event) {
        event.preventDefault();
        this.modoOscuro = !this.modoOscuro;
        document.body.classList.toggle('modo-oscuro', this.modoOscuro);
        localStorage.setItem('modoOscuro', this.modoOscuro);
      },
      aumentarTamanio(event) {
        event.preventDefault();
        this.fontSize = Math.min(18, this.fontSize + 1);
        document.documentElement.style.fontSize = this.fontSize + 'px';
        localStorage.setItem('fontSize', this.fontSize);
      },
      disminuirTamanio(event) {
        event.preventDefault();
        this.fontSize = Math.max(12, this.fontSize - 1);
        document.documentElement.style.fontSize = this.fontSize + 'px';
        localStorage.setItem('fontSize', this.fontSize);
      },
      irCentroRelevo() {
        window.open('https://centroderelevo.gov.co', '_blank', 'noopener,noreferrer');
      },
      actualizarReloj() {
        const ahora = new Date();
        const opciones = { timeZone: 'America/Bogota' };
        this.horaActual = ahora.toLocaleTimeString('es-CO', opciones);
      },
    },
    mounted() {
      // Aplicar el tamaño de fuente guardado
      document.documentElement.style.fontSize = this.fontSize + 'px';
  
      // Aplicar el modo oscuro si está activo
      if (this.modoOscuro) {
        document.body.classList.add('modo-oscuro');
      }
  
      // Inicializar el reloj
      this.actualizarReloj();
      setInterval(this.actualizarReloj, 1000);
    },
  };
  </script>
  
  <style scoped>


/* Variables globales */
:root {
    --color-alcaldia: #00ade7;
    --color-secundario: #00568d;
    --color-fondo: #ffffff;
    --color-texto: #333333;
    --color-acento: #f3c94a;
}

/* Transiciones globales */
* {
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* Modo oscuro completo */
.modo-oscuro {
    --color-fondo: #000000; /* Fondo negro */
    --color-texto: #fabb00; /* Texto amarillo */
    background-color: var(--color-fondo) !important;
    color: var(--color-texto) !important;
}
.modo-oscuro img {
    filter: brightness(0.5);
}
.modo-oscuro .navbar-dark,
.modo-oscuro .dropdown-menu,
.modo-oscuro .card,
.modo-oscuro .footer,
.modo-oscuro #contacto {
    background-color: #000000 !important;
    border-color: #333333 !important;
    color: var(--color-texto) !important;
}

.modo-oscuro #carouselExampleControls,
.modo-oscuro #carouselExampleControls .nav-link,
.modo-oscuro #participacion-ciudadana,
.modo-oscuro #carouselExampleControls .dropdown-item,
.modo-oscuro #carouselExampleControls .carousel-control-prev-icon,
.modo-oscuro #carouselExampleControls .carousel-control-next-icon,
.modo-oscuro #carouselExampleControls .fa-3x,
.modo-oscuro #carouselExampleControls .navbar-nav span {
  background-color: #000000 !important;
}
.modo-oscuro .nav-link,
.modo-oscuro .dropdown-item,
.modo-oscuro .form-control,
.modo-oscuro .btn-outline-light,
.modo-oscuro .text-dark,
.modo-oscuro footer a {
    color: var(--color-texto) !important;
}
.modo-oscuro .form-control {
    background-color: #2d2d2d !important;
    border-color: #3d3d3d !important;
}
.modo-oscuro .dropdown-item:hover {
    background-color: #333333 !important;
}
/* Footer en modo oscuro (unificado) */
.modo-oscuro footer {
    background-color: #000000 !important;
    border-top: 1px solid #333333 !important;
    color: var(--color-texto) !important;
}
.modo-oscuro footer a {
    color: var(--color-texto) !important;
}
.modo-oscuro footer a:hover {
    color: var(--color-fondo) !important;
}
.modo-oscuro footer .border-top {
    border-color: #333333 !important;
}
.modo-oscuro footer h5,
.modo-oscuro footer small,
.modo-oscuro footer p {
    color: var(--color-texto) !important;
}

.modo-oscuro #carouselExampleControls,
.modo-oscuro #carouselExampleControls .nav-link,
.modo-oscuro #participacion-ciudadana,
.modo-oscuro #carouselExampleControls .dropdown-item,
.modo-oscuro #carouselExampleControls .carousel-control-prev-icon,
.modo-oscuro #carouselExampleControls .carousel-control-next-icon,
.modo-oscuro #carouselExampleControls .fa-3x,
.modo-oscuro #carouselExampleControls .navbar-nav span {
    color: var(--color-texto) !important;
}
/* Estilos generales */
.hero-section {
    background: linear-gradient(rgba(0, 173, 231, 0.9), #00568d),
        url("https://placehold.co/1920x600?text=Santa+Marta") center/cover;
    padding: 150px 0;
}
.mapa-contacto {
    height: 300px;
    border-radius: 10px;
}

/* Reloj digital */
.reloj-digital {
    font-size: 0.8rem;
    font-weight: bold;
    color: var(--color-fondo);
    background-color: rgba(255, 255, 255, 0.1);
    padding: 10px 20px;
    border-radius: 10px;
    display: inline-block;
    margin-top: 10px;
}
.reloj-digital span {
    display: block;
    font-size: 0.8rem;
    margin-bottom: 5px;
}
.reloj-digital #hora-actual {
    font-size: 1rem;
}
.modo-oscuro .reloj-digital {
    color: var(--color-texto);
    background-color: var(--color-secundario);
}

/* Barra de accesibilidad */

/* Estilos para el nuevo botón */
.barra-accesibilidad-govco .icon-relevo {
    background: var(--color-secundario);
    width: 48px;
    height: 40px;
    border: none;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono-relevo {
    width: 24px;
    height: 24px;
    filter: brightness(0) invert(1);
}

/* Efecto hover/focus consistente */
.barra-accesibilidad-govco .icon-relevo span {
    position: absolute;
    left: -172px;
    background: var(--color-secundario);
    color: var(--color-fondo);
    padding: 8px 12px;
    border-radius: 10px 0 0 10px;
    opacity: 0;
    transition: opacity 0.3s, left 0.3s;
    white-space: nowrap;
    pointer-events: none;
}

.barra-accesibilidad-govco .icon-relevo:hover span,
.barra-accesibilidad-govco .icon-relevo:focus span {
    opacity: 1;
    left: -135px;
}

/* Mantener alineación vertical */
.barra-accesibilidad-govco {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 12px 0;
}

.content-example-barra {
    position: fixed;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10000;
    display: flex;
    flex-direction: column;
    gap: 5px; /* Valor original; se unifica en la siguiente regla */
    padding: 15px 10px;
    border: 2px var(--color-fondo);
    margin-left: auto;
    margin-right: auto;
}
.barra-accesibilidad-govco {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: center;
    height: 133px;
    width: 48px;
    position: fixed;
    right: 0;
    top: 35%;
    background-color: #004884 !important;
    border-radius: 10px 0 0 10px;
    opacity: 1;
    padding: 12px 0;
}
.barra-accesibilidad-govco button {
    background: none;
    border: none;
    color: var(--color-fondo);
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
    width: 10px;
    height: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: inherit;
}
.barra-accesibilidad-govco button:hover {
    background: rgba(255, 255, 255, 0.2);
}
.barra-accesibilidad-govco button .hover-text {
    display: none;
    position: absolute;
    right: 50px;
    white-space: nowrap;
    background: var(--color-secundario);
    padding: 5px 10px;
    border-radius: 5px;
    color: var(--color-fondo);
    font-size: 14px;
}
.barra-accesibilidad-govco button:hover .hover-text {
    display: block;
}
.barra-accesibilidad-govco button i,
.barra-accesibilidad-govco button img {
    transition: transform 0.3s ease;
}
.barra-accesibilidad-govco button:hover i,
.barra-accesibilidad-govco button:hover img {
    transform: scale(1.1);
}

/* Barra de accesibilidad - Texto */
.barra-accesibilidad-letra {
    width: 100%;
    align-items: center;
    text-align: center;
}
.barra-accesibilidad-letra .titulo-barra-accesibilidad {
    color: #000;
    font-family: Montserrat-SemiBold;
    font-size: 20px;
    margin: 0;
}
.barra-accesibilidad-letra .descripcion-barra-accesibilidad {
    color: #4b4b4b;
    font-family: WorkSans-Regular;
    font-size: 16px;
    margin: 0;
}

/* Iconos de la barra de accesibilidad Gov.co */
/* Regla común para los tres iconos */
.barra-accesibilidad-govco .icon-contraste,
.barra-accesibilidad-govco .icon-reducir,
.barra-accesibilidad-govco .icon-aumentar {
    background: #004884;
    width: 48px;
    height: 40px;
    border: none;
    outline: none;
    text-decoration: none;
    text-align: center;
}
/* Estilo común para los pseudo-elementos ::after */
.barra-accesibilidad-govco .icon-contraste::after,
.barra-accesibilidad-govco .icon-reducir::after,
.barra-accesibilidad-govco .icon-aumentar::after {
    background: #fff;
    height: 24px;
    width: 24px;
    padding: 4px;
    border-radius: 5px;
    opacity: 1;
    position: relative;
    font-family: "govco-font";
}
/* Contenido y color inicial (antes de hover/focus) */
.barra-accesibilidad-govco .icon-contraste::after {
    content: "\e803";
    color: #004884;
}
.barra-accesibilidad-govco .icon-reducir::after {
    content: "\ec2a";
    color: #004884;
}
.barra-accesibilidad-govco .icon-aumentar::after {
    content: "\ec29";
    color: #004884;
}
/* Hover y focus: se iguala para los tres iconos */

.barra-accesibilidad-govco .icon-contraste:hover::after,
.barra-accesibilidad-govco .icon-reducir:hover::after,
.barra-accesibilidad-govco .icon-aumentar:hover::after,
.barra-accesibilidad-govco .icon-contraste:focus::after,
.barra-accesibilidad-govco .icon-reducir:focus::after,
.barra-accesibilidad-govco .icon-aumentar:focus::after {
    background: #fff;
    color: #3366cc;
}
/* Reglas para los textos emergentes de cada icono */
.barra-accesibilidad-govco #titlecontraste,
.barra-accesibilidad-govco #titledisminuir,
.barra-accesibilidad-govco #titleaumentar {
    text-align: left;
    position: absolute;
    background: #3366cc;
    color: #fff;
    line-height: normal !important;
    font-family: WorkSans-Medium !important;
    font-size: 14px;
    margin-top: -8px;
    opacity: 0;
    width: 172px;
    height: 40px;
    border-radius: 10px 0 0 10px;
    padding: 10px;
    padding-bottom: 12px;
}
.barra-accesibilidad-govco button:hover #titlecontraste,
.barra-accesibilidad-govco button:hover #titledisminuir,
.barra-accesibilidad-govco button:hover #titleaumentar {
    opacity: 1;
    visibility: visible;
    margin-left: -135px;
}
.barra-accesibilidad-govco .icon-contraste:focus #titlecontraste,
.barra-accesibilidad-govco .icon-reducir:focus #titledisminuir,
.barra-accesibilidad-govco .icon-aumentar:focus #titleaumentar {
    opacity: 1;
    visibility: visible;
    margin-left: -136px;
    outline: 2px solid #000;
    outline-offset: 2px;
}
/* Estados activos */
.active-barra-accesibilidad-govco {
    background-color: #3366cc !important;
}
.active-barra-accesibilidad-govco.icon-contraste::after,
.active-barra-accesibilidad-govco.icon-reducir::after,
.active-barra-accesibilidad-govco.icon-aumentar::after {
    background: #fff;
    font-family: "govco-font";
    height: 24px;
    width: 24px;
    color: #3366cc;
    padding: 4px;
    border-radius: 5px;
    opacity: 1;
    position: relative;
}
.active-barra-accesibilidad-govco.icon-contraste::after {
    content: "\e803";
}
.active-barra-accesibilidad-govco.icon-reducir::after {
    content: "\ec2a";
}
.active-barra-accesibilidad-govco.icon-aumentar::after {
    content: "\ec29";
}

/* Animaciones para las noticias */
@keyframes slideIn {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
.news-item {
    animation: slideIn 0.5s ease-out;
    margin-bottom: 20px;
}
.news-item:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}

/* Barra de navegación */

/* Estilos personalizados */
.navbar-nav {
    margin: 0 auto; /* Centra los elementos del navbar */
}

.mega-menu {
    min-width: 100%;
    left: 0;
    right: 0;
    padding: 1rem;
    opacity: 0;
    transform: translateY(-20px);
    visibility: hidden;
    transition: all 0.3s ease-in-out;
}

.nav-item:hover .mega-menu {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

.nav-link {
    font-weight: 500;
    color: #333;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #007bff;
}

.dropdown-item {
    position: relative;
    transition: background-color 0.3s ease, padding-left 0.3s ease;
}

.dropdown-item:hover {
    background-color: #f0f0f0;
    padding-left: 15px;
}

.dropdown-menu {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

@media (max-width: 576px) {
    .mega-menu {
        position: static;
    }

    .dropdown-menu {
        border: none;
        box-shadow: none;
    }

    .nav-item {
        text-align: center;
    }
}

/* Footer general */
footer {
    background-color: var(--color-secundario);
}



/* La sección que contiene el menú se posiciona como relativa */
#participacion-ciudadana {
    position: relative;
    /* Si querés que el mega-menu no se salga, podés activar overflow: hidden; */
    overflow: hidden;
}
/* Removemos el positioning relativo de los nav-items para que el contenedor de referencia sea el section */
.navbar-nav .nav-item.dropdown {
    position: static !important;
    height: 13rem;
}
#participacion-ciudadana {
    margin-top: 1rem;

}
/* Mega-menu: se posiciona absolutamente dentro de la sección, justo debajo del nav */
.dropdown-menu.mega-menu.show {
    position: absolute !important;
    top: 7rem; /* Ajustá este valor según la altura real de tu navbar */
    left: 50%;
    transform: translateX(-50%);

    z-index: 1050;
    display: block;
}

.dropdown-menu.mega-menu a .dropdown-item {
    background-color: var(--color-fondo);
}
/*/------------------------------------------------------------------*/

/* Estilos personalizados para color blanco */
/* Aplica estilos solo al contenedor del carrusel */
#carouselExampleControls {
    min-height: 1vh;
    padding: 20px;
}

#carouselExampleControls .nav-link,
#carouselExampleControls .dropdown-item,
#carouselExampleControls .carousel-control-prev-icon,
#carouselExampleControls .carousel-control-next-icon,
#carouselExampleControls .navbar-nav span {
    color: white !important;
}

#carouselExampleControls  {
    background-color: var(--color-secundario) !important;
}

#carouselExampleControls .fa-3x,
#carouselExampleControls .dropdown-item i {
    color: white !important;
    transition: all 0.3s;
}

#carouselExampleControls .dropdown-menu {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(1000px);
}

#carouselExampleControls .dropdown-item:hover {
    background-color: var(--color-secundario) !important;
}

#carouselExampleControls .carousel-control-prev,
#carouselExampleControls .carousel-control-next {

    animation: pulsate 1s ease-in-out infinite;
}

@keyframes pulsate {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}



#carouselExampleControls .mega-menu {
    left: 50% !important;
    transform: translateX(-50%) !important;
    width: max-content;
    min-width: 600px;
}




  </style>
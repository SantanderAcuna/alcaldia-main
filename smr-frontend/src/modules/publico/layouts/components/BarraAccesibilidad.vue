<template>
  <div class="Barra-accesibilidad">
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
        <button
          id="botonrelevo"
          @click="irCentroRelevo"
          title="Centro de relevo"
          aria-label="Acceder al centro de relevo de comunicaciones"
        >
          <img :src="relevoIcon" alt="" aria-hidden="true" class="icono-relevo" />
          <span class="hover-text">Centro de relevo</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue';
import relevoIcon from '@/assets/img/relevo.svg';

let fontSize = 16;

// 🌗 Cambiar contraste del sitio
function cambiarContexto(event) {
  event?.preventDefault();
  const body = document.body;
  body.classList.toggle('modo-oscuro');

  document
    .querySelectorAll('.navbar, .dropdown-menu, .card, .footer, #contacto')
    .forEach((el) => el.classList.toggle('modo-oscuro'));

  localStorage.setItem('modoOscuro', body.classList.contains('modo-oscuro'));
}

// 🔠 Aumentar tamaño de fuente
function aumentarTamanio(event) {
  event?.preventDefault();
  fontSize = Math.min(18, fontSize + 1);
  document.documentElement.style.fontSize = `${fontSize}px`;
  localStorage.setItem('fontSize', fontSize);
}

// 🔡 Disminuir tamaño de fuente
function disminuirTamanio(event) {
  event?.preventDefault();
  fontSize = Math.max(12, fontSize - 1);
  document.documentElement.style.fontSize = `${fontSize}px`;
  localStorage.setItem('fontSize', fontSize);
}

// 🦻 Acceso al centro de relevo
function irCentroRelevo() {
  window.open('https://www.centroderelevo.gov.co/', '_blank');
}

// 🚀 Inicialización al montar el componente
onMounted(() => {
  // Restaurar preferencias
  const savedFontSize = localStorage.getItem('fontSize');
  const modoOscuro = localStorage.getItem('modoOscuro') === 'true';

  if (savedFontSize) {
    fontSize = parseInt(savedFontSize);
    document.documentElement.style.fontSize = `${fontSize}px`;
  }

  if (modoOscuro) {
    document.body.classList.add('modo-oscuro');
    document
      .querySelectorAll('.navbar, .dropdown-menu, .card, .footer, #contacto')
      .forEach((el) => el.classList.add('modo-oscuro'));
  }
});
</script>

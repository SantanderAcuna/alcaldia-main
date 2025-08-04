<template>
  <div
    class="Barra-accesibilidad"
    role="toolbar"
    aria-label="Barra de herramientas de accesibilidad"
  >
    <div class="content-example-barra">
      <div class="barra-accesibilidad-govco">
        <!-- Botón de Contraste -->
        <button
          id="botoncontraste"
          @click="toggleContrast"
          title="Cambiar contraste"
          :aria-pressed="isDarkMode ? 'true' : 'false'"
          aria-label="Alternar modo alto contraste"
          :class="{ 'active-mode': isDarkMode }"
        >
          <i class="fas fa-adjust"></i>
          <span class="sr-only">Alternar modo alto contraste</span>
          <span class="hover-text">Cambiar contraste</span>
        </button>

        <!-- Botón Aumentar Fuente -->
        <button
          id="botonaumentar"
          @click="increaseFontSize"
          title="Aumentar tamaño"
          aria-label="Incrementar tamaño de fuente"
          :disabled="fontSize >= MAX_FONT_SIZE"
          :aria-disabled="fontSize >= MAX_FONT_SIZE"
        >
          <i class="fas fa-plus"></i>
          <span class="sr-only">Incrementar tamaño de fuente</span>
          <span class="hover-text">Aumentar tamaño</span>
        </button>

        <!-- Botón Disminuir Fuente -->
        <button
          id="botondisminuir"
          @click="decreaseFontSize"
          title="Disminuir tamaño"
          aria-label="Reducir tamaño de fuente"
          :disabled="fontSize <= MIN_FONT_SIZE"
          :aria-disabled="fontSize <= MIN_FONT_SIZE"
        >
          <i class="fas fa-minus"></i>
          <span class="sr-only">Reducir tamaño de fuente</span>
          <span class="hover-text">Disminuir tamaño</span>
        </button>

        <!-- Botón Centro de Relevo -->
        <button
          id="botonrelevo"
          @click="goToRelayCenter"
          title="Centro de relevo"
          aria-label="Acceder al centro de relevo de comunicaciones"
          class="relay-button"
        >
          <img :src="relevoIcon" alt="" aria-hidden="true" class="icono-relevo" loading="lazy" />
          <span class="hover-text">Centro de relevo</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import relevoIcon from '@/assets/img/relevo.svg';

// Tipos
type FontSize = number;
type DarkModeState = boolean;

// Constantes
const MIN_FONT_SIZE: FontSize = 12;
const MAX_FONT_SIZE: FontSize = 18;
const DEFAULT_FONT_SIZE: FontSize = 16;
const FONT_SIZE_STEP: FontSize = 1;

const DARK_MODE_ELEMENTS: string[] = ['.navbar', '.dropdown-menu', '.card', '.footer', '#contacto'];

// Estado reactivo con tipos explícitos
const fontSize = ref<FontSize>(DEFAULT_FONT_SIZE);
const isDarkMode = ref<DarkModeState>(false);

/**
 * Alterna el modo de alto contraste con manejo de eventos y persistencia
 * @param {MouseEvent} [event] - Evento opcional del click
 */
const toggleContrast = (event?: MouseEvent): void => {
  event?.preventDefault();

  // Actualizar estado
  isDarkMode.value = !isDarkMode.value;

  // Aplicar cambios al DOM
  applyDarkModeChanges(isDarkMode.value);

  // Persistir preferencia
  persistDarkModePreference(isDarkMode.value);
};

/**
 * Aplica los cambios visuales del modo oscuro
 * @param {boolean} enabled - Indica si el modo oscuro está activo
 */
const applyDarkModeChanges = (enabled: boolean): void => {
  document.body.classList.toggle('modo-oscuro', enabled);

  DARK_MODE_ELEMENTS.forEach((selector) => {
    document.querySelectorAll(selector).forEach((el) => {
      el.classList.toggle('modo-oscuro', enabled);
    });
  });
};

/**
 * Persiste la preferencia del modo oscuro
 * @param {boolean} enabled - Indica si el modo oscuro está activo
 */
const persistDarkModePreference = (enabled: boolean): void => {
  localStorage.setItem('modoOscuro', String(enabled));
};

/**
 * Aumenta el tamaño de fuente dentro de los límites permitidos
 * @param {MouseEvent} [event] - Evento opcional del click
 */
const increaseFontSize = (event?: MouseEvent): void => {
  event?.preventDefault();

  if (fontSize.value < MAX_FONT_SIZE) {
    fontSize.value += FONT_SIZE_STEP;
    updateFontSize();
  }
};

/**
 * Disminuye el tamaño de fuente dentro de los límites permitidos
 * @param {MouseEvent} [event] - Evento opcional del click
 */
const decreaseFontSize = (event?: MouseEvent): void => {
  event?.preventDefault();

  if (fontSize.value > MIN_FONT_SIZE) {
    fontSize.value -= FONT_SIZE_STEP;
    updateFontSize();
  }
};

/**
 * Actualiza el tamaño de fuente en el documento y lo persiste
 */
const updateFontSize = (): void => {
  document.documentElement.style.fontSize = `${fontSize.value}px`;
  localStorage.setItem('fontSize', String(fontSize.value));
};

/**
 * Abre el centro de relevo en nueva pestaña con seguridad
 */
const goToRelayCenter = (): void => {
  window.open('https://www.centroderelevo.gov.co/', '_blank', 'noopener,noreferrer');
};

/**
 * Restaura las preferencias del usuario desde localStorage
 */
const restorePreferences = (): void => {
  restoreFontSizePreference();
  restoreDarkModePreference();
};

/**
 * Restaura la preferencia de tamaño de fuente
 */
const restoreFontSizePreference = (): void => {
  const savedFontSize = localStorage.getItem('fontSize');

  if (savedFontSize) {
    const parsedSize = parseInt(savedFontSize, 10);

    if (!isNaN(parsedSize) && parsedSize >= MIN_FONT_SIZE && parsedSize <= MAX_FONT_SIZE) {
      fontSize.value = parsedSize;
      document.documentElement.style.fontSize = `${fontSize.value}px`;
    }
  }
};

/**
 * Restaura la preferencia de modo oscuro
 */
const restoreDarkModePreference = (): void => {
  const savedDarkMode = localStorage.getItem('modoOscuro');
  isDarkMode.value = savedDarkMode === 'true';

  if (isDarkMode.value) {
    applyDarkModeChanges(true);
  }
};

// Inicialización al montar el componente
onMounted(() => {
  restorePreferences();

  // Mejorar accesibilidad para teclado
  document
    .querySelectorAll<HTMLButtonElement>('.barra-accesibilidad-govco button')
    .forEach((btn) => {
      btn.addEventListener('keydown', (e: KeyboardEvent) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          btn.click();
        }
      });
    });
});
</script>


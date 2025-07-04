// src/directives/tooltip.ts
export function createTooltip(el: HTMLElement, text: string) {
  // Agregar atributo tooltip para los estilos CSS
  el.setAttribute('tooltip', text);

  // Crear elemento de tooltip para accesibilidad
  const tooltipElement = document.createElement('span');
  tooltipElement.className = 'sr-only';
  tooltipElement.textContent = text;
  el.appendChild(tooltipElement);

  // Manejar eventos para accesibilidad
  el.addEventListener('focus', showTooltip);
  el.addEventListener('blur', hideTooltip);
  el.addEventListener('mouseenter', showTooltip);
  el.addEventListener('mouseleave', hideTooltip);

  function showTooltip() {
    el.setAttribute('aria-describedby', 'tooltip-' + el.id);
    el.setAttribute('data-tooltip-visible', 'true');
  }

  function hideTooltip() {
    el.removeAttribute('aria-describedby');
    el.setAttribute('data-tooltip-visible', 'false');
  }
}

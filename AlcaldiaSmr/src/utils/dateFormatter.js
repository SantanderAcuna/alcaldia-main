/**
 * Formatea una fecha ISO a formato local
 * @param {string} dateString - Fecha en formato ISO (YYYY-MM-DD)
 * @returns {string} - Fecha formateada (DD/MM/YYYY)
 */
export function formatDate(dateString) {
  if (!dateString) return 'N/A'
  
  const options = { 
    year: 'numeric', 
    month: '2-digit', 
    day: '2-digit',
    timeZone: 'UTC' // Para evitar problemas de zona horaria
  }
  
  return new Date(dateString)
    .toLocaleDateString('es-ES', options)
    .replace(/\//g, '/')
}
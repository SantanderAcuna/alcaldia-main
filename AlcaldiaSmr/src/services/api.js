import axios from 'axios';

/**
 * 🚀 Configuración optimizada de Axios para API Laravel
 * Mantiene tu estructura original con mejoras de seguridad y rendimiento
 */
const api = axios.create({
  // ✅ Configuración unificada y mejorada
  baseURL: import.meta.env.VITE_API_BASE_URL
    ? import.meta.env.VITE_API_BASE_URL.endsWith('/api')
      ? import.meta.env.VITE_API_BASE_URL
      : `${import.meta.env.VITE_API_BASE_URL}/api`
    : 'http://localhost:8000/api', // Default local
  
  timeout: 10000, // Timeout de 10 segundos
  withCredentials: false,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json', // Default para JSON
    'X-Requested-With': 'XMLHttpRequest' // Identifica peticiones AJAX
  }
});



// 🔒 Interceptor de solicitud mejorado
api.interceptors.request.use(config => {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  
  // Solo agregar CSRF si el meta tag existe
  if (csrfMeta?.content) {
    config.headers['X-CSRF-TOKEN'] = csrfMeta.content;
  }

  // Agregar token de autenticación si existe
  const authToken = localStorage.getItem('auth_token');
  if (authToken) {
    config.headers.Authorization = `Bearer ${authToken}`;
  }

  return config;
}, error => Promise.reject(error));

// 🛡️ Interceptor de respuesta mejorado
api.interceptors.response.use(response => response, error => {
  const { status, data } = error.response || {};
  
  // Mapeo de errores comunes
  const errorMessages = {
    400: 'Solicitud incorrecta',
    401: 'Acceso no autorizado - Redirigiendo...',
    403: 'No tienes permisos para esta acción',
    404: 'Recurso no encontrado',
    419: 'Token de sesión expirado - Recargando...',
    422: 'Errores de validación',
    500: 'Error interno del servidor'
  };

  // Logging detallado en desarrollo
  if (import.meta.env.DEV) {
    console.groupCollapsed(`[API Error] ${status} - ${errorMessages[status] || 'Error desconocido'}`);
    console.log('Detalles:', {
      URL: error.config.url,
      Método: error.config.method?.toUpperCase(),
      Status: status,
      Mensaje: data?.message || error.message,
      Errores: data?.errors || []
    });
    console.groupEnd();
  }

  // Acciones específicas
  switch (status) {
    case 401:
      window.location.href = '/login';
      break;
      
    case 419:
      window.location.reload();
      break;
  }

  // Formato estandarizado de error
  return Promise.reject({
    status,
    message: data?.message || errorMessages[status] || 'Error desconocido',
    errors: data?.errors || [],
    originalError: error
  });
});

/**
 * 🌐 Generador de URLs de almacenamiento mejorado
 * @param {string} path - Ruta del archivo
 * @param {object} [options] - Opciones adicionales
 * @param {boolean} [options.cacheBust] - Forzar recarga de caché
 * @returns {string|null} URL completa
 */
export const getPublicUrl = (path, options = {}) => {
  if (!path) return null;
  
  try {
    const baseUrl = import.meta.env.VITE_API_FILE_URL 
      || api.defaults.baseURL.replace('/api', '/storage');
    
    return new URL(path, baseUrl.endsWith('/') ? baseUrl : `${baseUrl}/`).toString() 
      + (options.cacheBust ? `?v=${Date.now()}` : '');
  } catch (error) {
    console.error('Error generando URL:', error);
    return null;
  }
};

export default api;
import axios from 'axios';

// Configuración base de Axios
const api = axios.create({
  baseURL: 'http://127.0.0.1/api', // URL base de la API Laravel
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  }
});

// Función para obtener todas las PQRSD
export const getPqrsds = async () => {
  try {
    const response = await api.get('/pqrsds');
    return response.data;
  } catch (error) {
    console.error('Error obteniendo las PQRSD:', error);
    throw error;
  }
};

// Función para crear una PQRSD
export const createPqrsd = async (pqrsdData) => {
  try {
    const response = await api.post('/pqrsds', pqrsdData);
    return response.data;
  } catch (error) {
    console.error('Error creando PQRSD:', error);
    throw error;
  }
};

// Función para actualizar una PQRSD
export const updatePqrsd = async (id, pqrsdData) => {
  try {
    const response = await api.put(`/pqrsds/${id}`, pqrsdData);
    return response.data;
  } catch (error) {
    console.error('Error actualizando PQRSD:', error);
    throw error;
  }
};

// Función para eliminar una PQRSD
export const deletePqrsd = async (id) => {
  try {
    const response = await api.delete(`/pqrsds/${id}`);
    return response.data;
  } catch (error) {
    console.error('Error eliminando PQRSD:', error);
    throw error;
  }
};

export default api;
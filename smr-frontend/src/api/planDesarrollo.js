import api from '@/services/api';

export default {
  /**
   * Obtener listado de alcaldes con relaciones
   * @returns {Promise<{data: Alcalde[]}>}
   */
  async getAll() {
    return api.get('/publico/plan');
  },

  /**
   * Obtener alcalde por ID con relaciones
   * @param {number} id
   * @returns {Promise<{data: Alcalde}>}
   */
  async getById(id) {
    return api.get(`/publico/plan`);
  },

  /**
   * Crear alcalde con manejo de archivos
   * @param {FormData} formData
   * @returns {Promise}
   */
  async create(formData) {
    return api.post('/publico/plan', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
  },

  /**
   * Actualizar alcalde (PUT)
   * @param {number} id
   * @param {FormData} formData
   * @returns {Promise}
   */
  async update(id, formData) {
    return api.put(`/publico/plan/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'X-Requested-With': 'XMLHttpRequest',
      },
    });
  },

  /**
   * Eliminar alcalde
   * @param {number} id
   * @returns {Promise}
   */
  async delete(id) {
    return api.delete(`/publico/plan/${id}`);
  },
};

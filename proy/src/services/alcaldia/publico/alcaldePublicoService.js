import apiPublico from './apiPublico'

export default {
  listar() {
    return apiPublico.get('/alcaldes')
  },
  obtener(id) {
    return apiPublico.get(`/alcaldes/${id}`)
  },
  crear(data) {
    return apiPublico.post('/alcaldes', data)
  },
  actualizar(id, data) {
    return apiPublico.put(`/alcaldes/${id}`, data)
  },
  eliminar(id) {
    return apiPublico.delete(`/alcaldes/${id}`)
  }
}

import axios from 'axios'

const apiPublico = axios.create({
  baseURL: '/api/publico', // ajustar según prefijo real de tu API
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json'
  }
})

export default apiPublico

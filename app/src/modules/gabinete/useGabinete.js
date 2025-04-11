import { ref } from 'vue'
import { obtenerGabinete } from '@/services/gabineteService'

export default function useGabinete() {
  const gabinete = ref([])

  const cargarGabinete = async () => {
    gabinete.value = await obtenerGabinete()
  }

  return { gabinete, cargarGabinete }
}

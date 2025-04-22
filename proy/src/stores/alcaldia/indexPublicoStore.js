import { defineStore } from 'pinia'
import AlcaldeService from '@/services/Publico/AlcaldePublicoService'

export const useAlcaldePublicoStore = defineStore('alcaldePublico', {
  state: () => ({
    alcaldes: [],
    actual: null,
    loading: false,
    error: null
  }),
  actions: {
    async fetchAlcaldes() {
      this.loading = true
      try {
        const { data } = await AlcaldeService.listar()
        this.alcaldes = data
      } catch (error) {
        this.error = error
      } finally {
        this.loading = false
      }
    },
    async fetchAlcalde(id) {
      this.loading = true
      try {
        const { data } = await AlcaldeService.obtener(id)
        this.actual = data
      } catch (error) {
        this.error = error
      } finally {
        this.loading = false
      }
    }
  }
})

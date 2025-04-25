// src/store/alcaldeStore.js
import { defineStore } from 'pinia';
import alcaldeService from '@/services/alcalde/alcaldeService';



export const useAlcaldeStore = defineStore('alcalde', {
  state: () => ({
    alcaldes: [],
    alcalde: null,
    loading: false,
    error: null
  }),

  actions: {
    async fetchAll() {
      this.loading = true;
      this.error = null;
      try {
        const res = await alcaldeService.getAll();
        this.alcaldes = res.data.data;
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al cargar alcaldes';
      } finally {
        this.loading = false;
      }
    },

    async fetchById(id) {
      this.loading = true;
      this.error = null;
      try {
        const res = await alcaldeService.getById(id);
        this.alcalde = res.data.data;
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al obtener el alcalde';
      } finally {
        this.loading = false;
      }
    },

    async createAlcalde(data) {
      this.loading = true;
      this.error = null;
      try {
        await alcaldeService.create(data);
        await this.fetchAll();
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al crear el alcalde';
      } finally {
        this.loading = false;
      }
    },

    async updateAlcalde(id, data) {
      this.loading = true;
      this.error = null;
      try {
        await alcaldeService.update(id, data);
        await this.fetchAll();
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al actualizar el alcalde';
      } finally {
        this.loading = false;
      }
    },

    async deleteAlcalde(id) {
      this.loading = true;
      this.error = null;
      try {
        await alcaldeService.delete(id);
        await this.fetchAll();
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al eliminar el alcalde';
      } finally {
        this.loading = false;
      }
    },

    async forceDeleteAlcalde(id) {
      this.loading = true;
      this.error = null;
      try {
        await alcaldeService.forceDelete(id);
        await this.fetchAll();
      } catch (err) {
        this.error = err.response?.data?.message || 'Error al eliminar definitivamente el alcalde';
      } finally {
        this.loading = false;
      }
    }
  }
});
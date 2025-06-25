import { defineStore } from 'pinia';
import {getAlcaldeActions} from '../modules/alcaldia/helpers/alcalde/actions/index'

export const useAlcaldeStore = defineStore('alcaldes', {
  state: () => ({
    alcaldes: [],
    currentAlcalde: null,
    loading: false,
    error: null,
  }),

  actions: {
    async fetchAll() {
      this.loading = true;
      try {
        getAlcaldeActions();
       
      } catch (error) {
        this.error = this.handleError(error);
        throw error;
      } finally {
        this.loading = false;
      }
    },

    // async fetchById(id) {
    //   this.loading = true;
    //   try {
    //     const { data } = await alcaldeApi.getById(id);
    //     this.currentAlcalde = data.data;
    //     this.error = null;
    //     return data.data;
    //   } catch (error) {
    //     this.error = this.handleError(error);
    //     throw error;
    //   } finally {
    //     this.loading = false;
    //   }
    // },

    // async create(formData) {
    //   this.loading = true;
    //   try {
    //     const { data } = await alcaldeApi.create(formData);
    //     this.alcaldes.unshift(data.data);
    //     this.error = null;
    //     return data.data;
    //   } catch (error) {
    //     this.error = this.handleError(error);
    //     throw error;
    //   } finally {
    //     this.loading = false;
    //   }
    // },

    // async update({ id, formData }) {
    //   this.loading = true;
    //   try {
    //     const { data } = await alcaldeApi.update(id, formData);
    //     const index = this.alcaldes.findIndex((a) => a.id === id);
    //     if (index !== -1) {
    //       this.alcaldes.splice(index, 1, data.data);
    //     }
    //     this.error = null;
    //     return data.data;
    //   } catch (error) {
    //     this.error = this.handleError(error);
    //     throw error;
    //   } finally {
    //     this.loading = false;
    //   }
    // },

    // async delete(id) {
    //   this.loading = true;
    //   try {
    //     await alcaldeApi.delete(id);
    //     this.alcaldes = this.alcaldes.filter((a) => a.id !== id);
    //     this.error = null;
    //   } catch (error) {
    //     this.error = this.handleError(error);
    //     throw error;
    //   } finally {
    //     this.loading = false;
    //   }
    // },

    handleError(error) {
      const defaultMessage = 'Error en la operación';
      const serverMessage = error.response?.data?.message;
      const validationErrors = error.response?.data?.errors;

      return {
        message: serverMessage || defaultMessage,
        errors: validationErrors || {},
        code: error.response?.status || 500,
      };
    },
  },

  getters: {
    activeAlcaldes: (state) => state.alcaldes.filter((a) => a.actual),
    getAlcaldeById: (state) => (id) =>
      state.alcaldes.find((a) => a.id === id) || state.currentAlcalde,
  },
});

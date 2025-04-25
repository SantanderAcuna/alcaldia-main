// src/services/alcaldeService.js
import axios from "axios";

const API_URL = "http://127.0.0.1:8000/api/alcaldes";

export default {
  getAll() {
    return axios.get(API_URL);
  },

  getById(id) {
    return axios.get(`${API_URL}/${id}`);
  },

  create(data) {
    return axios.post(API_URL, data);
  },

  update(id, data) {
    return axios.put(`${API_URL}/${id}`, data);
  },

  delete(id) {
    return axios.delete(`${API_URL}/${id}`);
  },

  forceDelete(id) {
    return axios.delete(`${API_URL}/${id}/force`);
  },
};

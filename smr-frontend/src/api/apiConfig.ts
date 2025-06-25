import axios from 'axios';

const apiConfig = axios.create({
  baseURL: import.meta.env.VITE_API_CONFIG_URL,
});

export { apiConfig };

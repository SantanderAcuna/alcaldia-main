import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { VueQueryPlugin } from '@tanstack/vue-query';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import './config/yup';

import VueToast from 'vue-toast-notification';

import 'vue-toast-notification/dist/theme-bootstrap.css';

import './assets/scss/main.css';

import App from './App.vue';

import router from './router';

const app = createApp(App);
app.use(VueToast, {
  position: 'top-right',
  duration: 3000,
  dismissible: true,
  pauseOnHover: true,
  queue: false,
});

app.use(createPinia());
app.use(VueQueryPlugin);
app.use(router);

app.mount('#app');

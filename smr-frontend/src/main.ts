import './assets/scss/main.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { VueQueryPlugin } from '@tanstack/vue-query';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap' 
import '@fortawesome/fontawesome-free/css/all.min.css';

import App from './App.vue';
import router from './router';

const app = createApp(App);

app.use(createPinia());
app.use(VueQueryPlugin);
app.use(router);

app.mount('#app');

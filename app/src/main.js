import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Importa estilos globales
import './assets/css/style.css'; // Archivo CSS global
import 'bootstrap/dist/css/bootstrap.min.css'; // Bootstrap CSS
import '@fortawesome/fontawesome-free/css/all.min.css'; // FontAwesome CSS

// Importa scripts globales
import './assets/js/app.js'; // Archivo JS personalizado
import $ from 'jquery'; // jQuery (si es necesario)

// Importa Bootstrap JS
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Crea la aplicación Vue
const app = createApp(App);

// Usa Vue Router
app.use(router);

// Monta la aplicación en el elemento con id "app"
app.mount('#app');
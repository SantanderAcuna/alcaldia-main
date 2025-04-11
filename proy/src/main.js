import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";
import "./assets/scss/style.css";
import "./assets/js/app.js";
import "bootstrap/dist/css/bootstrap.min.css"; // Bootstrap CSS

const fontAwesome = document.createElement("link");
fontAwesome.href =
  "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css";
fontAwesome.rel = "stylesheet";
document.head.appendChild(fontAwesome);

// Importa scripts globales
import "./assets/js/app.js"; // Archivo JS personalizado
import $ from "jquery";

// Importa Bootstrap JS
import "bootstrap/dist/js/bootstrap.bundle.min.js";

// Primero: Crear la app
const app = createApp(App);

// Segundo: Usar plugins
app.use(router);
app.use(createPinia());

// Tercero: Montar la app
app.mount("#app");

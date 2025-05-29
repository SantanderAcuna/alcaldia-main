import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";

import "bootstrap/dist/css/bootstrap.min.css";

import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;
import "@/assets/scss/main.css";

import "@fortawesome/fontawesome-free/css/all.min.css";

const app = createApp(App);

app.use(createPinia())
app.use(router); 

app.mount("#app");

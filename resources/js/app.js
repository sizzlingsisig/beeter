import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import { createPinia } from "pinia";

// Global styles (Tailwind + custom)
import "./assets/main.css";

// Bootstrap CSS and Icons
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";

// Bootstrap JavaScript bundle (with Popper)
import "bootstrap/dist/js/bootstrap.bundle.min.js";

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount("#app");

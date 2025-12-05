// Base Imports
import "./bootstrap.js";
import "../css/app.css";
import "summernote/dist/summernote-lite.css";
import "summernote/dist/summernote-lite.min.js";
import "vue-select/dist/vue-select.css";
import "vue-image-zoomer/dist/style.css";
import "./assets/css/main.css";

// Setting Provider
import { settingProvider } from "@/plugins/settingProvider.js";
const setting = settingProvider();

// Pinia, Vue, Inertia
import { createPinia } from "pinia";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// Components & Plugins
import vSelect from "vue-select";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createVbPlugin } from "vue3-plugin-bootstrap5";
import {
  Alert,
  Button,
  Carousel,
  Collapse,
  Dropdown,
  Modal,
  Offcanvas,
  Popover,
  ScrollSpy,
  Tab,
  Toast,
  Tooltip,
} from "bootstrap";

// Bootstrap5 Plugin
const vbPlugin = createVbPlugin({
  Alert,
  Button,
  Carousel,
  Collapse,
  Dropdown,
  Modal,
  Offcanvas,
  Popover,
  ScrollSpy,
  Tab,
  Toast,
  Tooltip,
});

// Pinia Instance
const pinia = createPinia();
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// Global Toaster
import { createToaster } from "@meforma/vue-toaster";
window.$toast = createToaster({ position: "bottom" });

// jQuery (Optional)
import $ from "jquery";
window.$ = window.jQuery = $;

// Inertia App
createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(vbPlugin)
      .use(pinia)
      .component("v-select", vSelect)
      .provide("setting", setting?.setting || {})
      .mount(el);
  },
  progress: { color: "#E50102" },
});

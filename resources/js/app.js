import "./bootstrap.js";
import "../css/app.css";
import "summernote/dist/summernote-lite.css";
import "summernote/dist/summernote-lite.min.js";
import "vue-select/dist/vue-select.css";
import "vue-image-zoomer/dist/style.css";
import "./assets/css/main.css";

import { settingProvider } from "@/plugins/settingProvider.js";
const setting = settingProvider();

import { createPinia } from "pinia";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { createHead } from "@vueuse/head"; // 1 import
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
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
let vbPlugin = createVbPlugin({
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

const pinia = createPinia();
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const head = createHead(); // 2

import { createToaster } from "@meforma/vue-toaster";
window.$toast = createToaster({
  position: "bottom",
});
import $ from "jquery";
window.$ = window.jQuery = $;

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
      .provide("setting", setting?.setting)
      .use(head) // 3 need important, without this useHead does nothing
      .mount(el);
  },
  progress: {
    color: "#E50102",
  },
});

import "@formkit/themes/genesis";
import { defaultConfig, plugin } from "@formkit/vue";
import { createApp } from "vue";
import App from "./App.vue";

createApp(App).use(plugin, defaultConfig).mount("#app");

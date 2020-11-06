import Vue from "vue";
import axios from "axios";
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import Index from "./index.vue";
import "normalize.css";

Vue.use(ElementUI);
Vue.config.productionTip = false;
axios.defaults.baseURL = "./";
Vue.prototype.$axios = axios;

new Vue({
  render: (h) => h(Index),
}).$mount("#app");

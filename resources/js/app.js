/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import locale from "element-ui/lib/locale/lang/es";

window.Vue.use(ElementUI, { locale });

Vue.component("App", require("./components/App.vue").default);
Vue.component("Admin", require("./components/Admin.vue").default);
Vue.component("Auth", require("./components/Auth.vue").default);

import router from "./routes";
import VueMeta from "vue-meta";
import VueSocialSharing from "vue-social-sharing";
import vueNumeralFilterInstaller from "vue-numeral-filter";
import VueCurrencyInput from "vue-currency-input";
import VueToastr2 from "vue-toastr-2";
import "vue-toastr-2/dist/vue-toastr-2.min.css";
import VueClipboard from "vue-clipboard2";
import VueNumeric from 'vue-numeric'

window.Vue.use(VueNumeric)
window.toastr = require("toastr");
window.Vue.use(VueMeta);
window.Vue.use(VueSocialSharing);
window.Vue.use(vueNumeralFilterInstaller);
window.Vue.use(VueCurrencyInput);
window.Vue.use(VueToastr2);
window.Vue.use(VueClipboard);

router.beforeEach((to, from, next) => {
    if (to.path == "/admin") {
        next({ name: "admin.home" });
    }
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!sessionStorage.getItem("currCustomer")) {
            next({ name: "inicio" });
        } else {
            next();
        }
    } else {
        next();
    }

    // IF ADMIN
    if (to.matched.some(record => record.meta.requiresAuthAdmin)) {
        if (!sessionStorage.getItem("userAdmin")) {
            console.log("usuario no existe");
            next({ name: "admin.login" });
        } else {
            next();
        }
    } else {
        next();
    }
});

const app = new Vue({
    el: "#app",
    router
});

import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        // Customer Page
        {
            path: "/:filter?",
            name: "inicio",
            props: true,
            component: require("./components/modules/customer/category/index")
                .default
        },
        // Categories Path
        {
            path: "/categoria/:id",
            name: "categoria",
            props: true,
            component: require("./components/modules/customer/category/index")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        // Product Path
        {
            path: "/producto/:id",
            name: "producto",
            props: true,
            component: require("./components/modules/customer/category/product")
                .default
        },
        // Order Page
        {
            path: "/mipedido/:serial",
            name: "mipedido",
            props: true,
            component: require("./components/modules/customer/index").default
        },
        // Cart Page
        {
            path: "/cart",
            name: "cart",
            component: require("./components/modules/customer/cart/index")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/cart/checkout",
            name: "cart.checkout",
            component: require("./components/modules/customer/cart/checkout")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        // Cod Response
        {
            path: "/cod/response/:cod_ref",
            name: "cod.response",
            props: true,
            component: require("./components/modules/payment/cod/response")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        // Epayco Response
        {
            path: "/epayco/response/:ref_payco?",
            name: "epayco.response",
            props: true,
            component: require("./components/modules/payment/epayco/response")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        // paguelofacil Response
        {
            path: "/paguelofacil/response/:ref_payco?",
            name: "paguelofacil.response",
            props: true,
            component: require("./components/modules/payment/paguelofacil/response")
                .default,
            meta: {
                requiresAuth: true
            }
        },
        // Login Page
        {
            path: "/admin/login",
            name: "admin.login",
            component: require("./components/modules/authenticate/login")
                .default
        },
        {
            path: "/admin/remember",
            name: "admin.remember",
            component: require("./components/modules/authenticate/remember")
                .default
        },
        // Admin Page
        { path: "/admin", name: "admin", redirect: { path: "/admin/home" } },
        {
            path: "/admin/home",
            name: "admin.home",
            component: require("./components/modules/admin/index").default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Categorias
        {
            path: "/admin/categorias",
            name: "admin.categorias",
            component: require("./components/modules/admin/categorias/index")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/categorias/create",
            name: "admin.categorias.create",
            component: require("./components/modules/admin/categorias/create")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/categorias/archive",
            name: "admin.categorias.archive",
            component: require("./components/modules/admin/categorias/archive")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/categorias/:id",
            name: "admin.categorias.edit",
            props: true,
            component: require("./components/modules/admin/categorias/edit")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Productos
        {
            path: "/admin/productos/edit/:id",
            name: "admin.productos.edit",
            props: true,
            component: require("./components/modules/admin/productos/edit")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/productos/create",
            name: "admin.productos.create",
            component: require("./components/modules/admin/productos/create")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/productos/archive",
            name: "admin.productos.archive",
            component: require("./components/modules/admin/productos/archive")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/productos/:producto?/:categoria?/:estado?",
            name: "admin.productos",
            props: true,
            component: require("./components/modules/admin/productos/index")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Pedidos
        {
            path: "/admin/pedidos",
            name: "admin.pedidos",
            component: require("./components/modules/admin/pedidos/index")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Pedidos
        {
            path: "/admin/transacciones",
            name: "admin.transacciones",
            component: require("./components/modules/admin/pedidos/pagos")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Settings
        {
            path: "/admin/configuracion",
            name: "admin.configuracion",
            component: require("./components/modules/admin/configuracion/index")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        // Admin Usuarios
        {
            path: "/admin/usuarios",
            name: "admin.usuarios",
            component: require("./components/modules/admin/usuario/index")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
        {
            path: "/admin/usuarios/:id",
            name: "admin.usuarios.edit",
            props: true,
            component: require("./components/modules/admin/usuario/edit")
                .default,
            meta: {
                requiresAuthAdmin: true
            }
        },
    ],
    mode: "history",
    linkExactActiveClass: "item-active"
});

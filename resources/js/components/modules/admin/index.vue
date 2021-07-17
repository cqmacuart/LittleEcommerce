<template>
  <section class="container col-12 mt-3 pb-5">
    <div class="col-12 d-flex flex-wrap">
      <div class="col-12 col-sm-6 col-md-4 mt-2">
        <div class="card h-100">
          <router-link :to="{ name: 'admin.categorias' }">
            <div class="card-header text-center py-5">
              <span class="fas fa-sitemap fa-5x" style="color: orange"></span>
            </div>
          </router-link>
          <div class="card-body p-3">
            <h2 class="card-title admin-title m-0">Categorías</h2>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Categorias Creadas:</span>
              <span class="text-primary" v-text="categoryInfo.total"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Categorias Activas:</span>
              <span class="text-success" v-text="categoryInfo.activas"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Categorias Inactivas:</span>
              <span class="text-danger" v-text="categoryInfo.inactivas"></span>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 mt-2">
        <div class="card h-100">
          <router-link :to="{ name: 'admin.productos' }">
            <div class="card-header text-center py-5">
              <span class="fas fa-apple-alt fa-5x" style="color: olive"></span>
            </div>
          </router-link>
          <div class="card-body p-3">
            <h2 class="card-title admin-title m-0">Productos</h2>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Productos Creados:</span>
              <span class="text-primary" v-text="productInfo.total"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Productos Activos:</span>
              <span class="text-success" v-text="productInfo.activas"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Productos Inactivos:</span>
              <span class="text-danger" v-text="productInfo.inactivas"></span>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-4 mt-2">
        <div class="card h-100">
          <router-link :to="{ name: 'admin.pedidos' }">
            <div class="card-header text-center py-5">
              <span class="fas fa-truck fa-5x"></span>
            </div>
          </router-link>
          <div class="card-body p-3">
            <h2 class="card-title admin-title m-0">Pedidos</h2>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Pedidos Realizados:</span>
              <span class="text-primary" v-text="orderInfo.total"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Pedidos Pendientes:</span>
              <span class="text-danger" v-text="orderInfo.inactivas"></span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span class="font-weight-bolder">Pedidos Entregados:</span>
              <span class="text-success" v-text="orderInfo.activas"></span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      categoryInfo: [],
      productInfo: [],
      orderInfo: [],
    };
  },
  mounted() {
    this.getCategoryInfo();
    this.getProductInfo();
    this.getOrderInfo();
  },
  methods: {
    getCategoryInfo() {
      axios.get("/categories/info").then((response) => {
        this.categoryInfo = response.data;
      });
    },
    getProductInfo() {
      axios.get("/products/info").then((response) => {
        this.productInfo = response.data;
      });
    },
    getOrderInfo() {
      axios.get("/orders/info").then((response) => {
        this.orderInfo = response.data;
      });
    },
    //   Cargar Categorías Guardadas
  },
};
</script>

<style>
.el-radio {
  width: 100%;
}
</style>

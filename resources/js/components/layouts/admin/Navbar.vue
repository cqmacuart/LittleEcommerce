<template>
  <div>
    <nav class="navbar bg-white p-0 border-bottom">
      <div class="col-12 p-0 text-center justify-content-center">
        <div class="h3 m-0">
          <h1 for class="m-0 admin-title">{{ titleTag }}</h1>
        </div>
        <div class="btn-group my-1">
          <router-link
            @click.native="setPageTitle"
            class="btn btn-sm btn-outline-secondary"
            :to="`/admin/home`"
          >
            <i class="fas fa-home"></i>
            <small>Home</small>
          </router-link>
          <router-link
            @click.native="setPageTitle"
            class="btn btn-sm"
            :class="bfunction.class"
            v-for="bfunction in bFunctions"
            :key="bfunction.id"
            :to="`/admin/${bfunction.enlace}`"
          >
            <small>{{ bfunction.label }}</small>
          </router-link>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      titleTag: "Home",
      bFunctions: [
        {
          enlace: "categorias",
          label: "Categorías",
          class: "btn-outline-secondary",
        },
        {
          enlace: "productos",
          label: "Productos",
          class: "btn-outline-secondary",
        },
        { enlace: "pedidos", label: "Pedidos", class: "btn-outline-secondary" },
        {
          enlace: "transacciones",
          label: "Pagos",
          class: "btn-outline-secondary",
        },
        {
          enlace: "configuracion",
          label: "Ajustes",
          class: "btn-outline-secondary",
        },
        {
          enlace: "usuarios",
          label: "Usuarios",
          class: "btn-outline-secondary",
        },
      ],
    };
  },
  computed: {},
  methods: {
    setPageTitle: function (event) {
      this.titleTag = event.target.textContent;
    },
  },
};
</script>

<style>
</style>

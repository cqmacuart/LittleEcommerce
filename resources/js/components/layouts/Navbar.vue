<template>
  <div :style="navStyle" v-if="fillColors.ok">
    <nav class="navbar bg-white p-0 border-bottom custom-nav-style">
      <div class="col-12 p-0">
        <ul class="navigation p-0 m-0">
          <li
            class="nav-item custom-item-style"
            v-for="cat in catList"
            :key="cat.id"
          >
            <router-link
              class="nav-link py-1"
              :to="{ name: 'categoria', params: { id: cat.value } }"
              >{{ cat.label }}</router-link
            >
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div v-else>
    <h5 class="text-center"><i class="el-icon-loading"></i></h5>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      catList: [],
      fillColors: {
        ok: false,
        //   Cabecera
        nvBgColor: "",
        nvTxColor: "",
        nvBrColor: "",
      },
      isColors: null,
    };
  },
  computed: {
    navStyle() {
      return {
        "--bg-nav-color": this.fillColors.nvBgColor
          ? this.fillColors.nvBgColor
          : "#FFFFFF",
        "--text-item-color": this.fillColors.nvTxColor
          ? this.fillColors.nvTxColor
          : "#000000",
        "--border-item-color": this.fillColors.nvBrColor
          ? `2px solid ${this.fillColors.nvBrColor}`
          : "2px solid #333333",
      };
    },
  },
  mounted() {
    this.getAllCategories();
    this.getColorCount();
  },
  methods: {
    getColorCount: function () {
      axios.get("/colors/count").then((response) => {
        this.isColors = response.data;
        if (this.isColors > 0) {
          this.getColorSettings();
        }
        setTimeout(() => {
          this.fillColors.ok = true;
        }, 1000);
      });
    },
    getColorSettings: function () {
      axios.get("/colors").then((response) => {
        response.data.forEach((element) => {
          this.fillColors.nvBgColor = element.nvBgColor;
          this.fillColors.nvTxColor = element.nvTxColor;
          this.fillColors.nvBrColor = element.nvBrColor;
        });
      });
    },
    //   Cargar Categorías Guardadas
    getAllCategories: function () {
      axios
        .get("/categories/page")
        .then((response) => {
          response.data.forEach((element) => {
            this.catList.push({
              value: element.id,
              label: element.nombre,
            });
          });
          this.catList;
          //   this.catList.shift();
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
  },
};
</script>

<style>
.custom-nav-style {
  background-color: var(--bg-nav-color) !important;
}
.custom-item-style > a {
  color: var(--text-item-color) !important;
  font-weight: 900;
  font-size: 0.8rem;
  font-family: "Arial Black", Helvetica, sans-serif;
}
.item-active,
.custom-item-style > a:hover {
  border-bottom: var(--border-item-color) !important;
}
</style>

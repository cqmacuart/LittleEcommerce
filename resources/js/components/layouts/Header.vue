<template>
  <div :style="headerStyle" v-if="fillColors.ok">
    <div
      class="d-none bg-light col-12 d-sm-flex justify-content-around px-0 custom-header-style"
    >
      <label for class="m-1">
        <span class="fab fa-whatsapp"></span>
        <a href="#" class="badge badge-success">{{ mobile }}</a>
      </label>
      <label for="" class="m-1"
        ><a :href="`${ruta}/admin`" class="text-dark custom-movile-style"
          ><span class="fas fa-mobile-alt"></span></a
      ></label>
      <label for class="m-1">
        <span class="fas fa-map-marker-alt"></span>
        {{ city }},{{ country }}
      </label>
    </div>
    <nav
      v-if="fillColors.hideLogo"
      class="navbar bg-white p-0 d-flex flex-column flex-sm-row custom-logon-style"
    >
      <div class="d-inline p-2">
        <a :href="'/'">
          <img
            :src="`/img/settings/${image}`"
            width="90px"
            :alt="storename"
            class="img-fluid"
            v-if="image"
          />
        </a>
      </div>
      <form class="form-inline p-3 p-sm-1" :action="`${ruta}/${inputSearch}`">
        <div class="container h-100">
          <div class="d-flex justify-content-center h-100">
            <div class="searchbar">
              <input
                class="search_input"
                :class="{ search_input_active: toogleSearch }"
                type="text"
                name
                placeholder="Buscar Producto..."
                v-model="inputSearch"
              />
              <a
                href="#"
                class="search_icon"
                :class="{ search_icon_active: toogleSearch }"
                @click.prevent="toogleSearchBar"
              >
                <i class="fas fa-search"></i>
              </a>
            </div>
          </div>
        </div>
      </form>
    </nav>
    <nav
      v-else
      class="navbar bg-white p-0 d-flex flex-column justify-content-center flex-sm-row custom-logon-style"
    >
      <form class="form-inline p-3 p-sm-1" :action="`${ruta}/${inputSearch}`">
        <div class="container h-100">
          <div class="d-flex justify-content-center h-100">
            <div class="searchbar">
              <input
                class="search_input search_input_active"
                type="text"
                name
                placeholder="Buscar Producto..."
                v-model="inputSearch"
              />
              <!-- <a href="#" class="search_icon search_icon_active">
                <i class="fas fa-search"></i>
              </a> -->
            </div>
          </div>
        </div>
      </form>
    </nav>
  </div>
  <div v-else>
    <h5 class="text-center"><i class="el-icon-loading"></i></h5>
  </div>
</template>

<script>
export default {
  props: ["ruta", "city", "country", "image", "storename", "mobile"],
  data() {
    return {
      toogleSearch: false,
      searchReady: false,
      inputSearch: "",
      //   colors vars
      fillColors: {
        ok: false,
        //   Cabecera
        hideLogo: null,
        hBgColor: "",
        hTxColor: "",
        hScColor: "",
        hTrColor: "",
      },
      isColors: null,
    };
  },
  computed: {
    headerStyle() {
      return {
        "--bg-head-color": this.fillColors.hBgColor
          ? this.fillColors.hBgColor
          : "#F8F9FA",
        "--text-head-color": this.fillColors.hTxColor
          ? this.fillColors.hTxColor
          : "#000000",
        "--mobile-head-color": this.fillColors.hScColor
          ? this.fillColors.hScColor
          : "#000000",
        "--bg-logon-color": this.fillColors.hTrColor
          ? this.fillColors.hTrColor
          : "#FFFFFF",
      };
    },
  },
  mounted() {
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
          this.fillColors.hBgColor = element.hBgColor;
          this.fillColors.hTxColor = element.hTxColor;
          this.fillColors.hScColor = element.hScColor;
          this.fillColors.hTrColor = element.hTrColor;
          this.fillColors.hideLogo = element.hideLogo == "1" ? true : false;
        });
      });
    },
    toogleSearchBar: function () {
      this.toogleSearch = !this.toogleSearch;
    },
  },
};
</script>

<style>
.custom-header-style {
  background-color: var(--bg-head-color) !important;
  color: var(--text-head-color) !important;
}
.custom-movile-style {
  color: var(--mobile-head-color) !important;
}
.custom-logon-style {
  background-color: var(--bg-logon-color) !important;
}
</style>

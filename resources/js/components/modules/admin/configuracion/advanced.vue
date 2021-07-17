<template>
  <div>
    <h2 class="m-0 admin-title">Configuraciones avanzadas</h2>
    <hr class="mt-0" />
    <!-- Form -->
    <section
      class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
    >
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA -->
        <section class="mb-4">
          <hgroup>
            <h4>Cabecera</h4>
          </hgroup>
          <section class="mb-4">
            <div class="col-12 row">
              <div class="d-flex flex-wrap flex-column flex-sm-row">
                <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
                  <label for="">Logo:</label>
                  <p class="m-0 p-0">
                    <small class="text-muted"
                      >Active esta opci&oacute;n para que su logo se muestren en
                      la p&aacute;gina.</small
                    >
                  </p>
                  <el-switch
                    v-model="fillColors.hideLogo"
                    active-color="#13ce66"
                    inactive-color="#ff0000"
                    active-text="Mostrar"
                    inactive-text="Ocultar"
                    :class="'mt-2'"
                    @change="setColors"
                  >
                  </el-switch>
                </div>
              </div>
            </div>
          </section>
        </section>
        <section class="mb-4">
          <hgroup>
            <h4>Tienda</h4>
          </hgroup>
          <section class="mb-4">
            <div class="col-12 row">
              <div
                class="d-flex flex-wrap flex-column flex-sm-row col-12 col-sm-6 col-md-4"
              >
                <div class="col-12 text-left pt-2 pt-sm-1">
                  <label for="">Modo Cat&aacute;logo:</label>
                  <p class="m-0 p-0">
                    <small class="text-muted"
                      >Si esta opci&oacute;n se encuentra activa no se
                      podr&aacute;n añadir productos al carrito</small
                    >
                  </p>
                  <el-switch
                    v-model="shopSettings.catalogueMode"
                    active-color="#13ce66"
                    inactive-color="#ff0000"
                    active-text="Activo"
                    inactive-text="Inactivo"
                    :class="'mt-2'"
                    @change="setAdvanced"
                  >
                  </el-switch>
                </div>
              </div>
            </div>
          </section>
        </section>
        <hr />
        <!-- <div class="col-12 text-right">
          <button
            class="btn btn-sm"
            :class="isColors > 0 ? ' btn-primary' : ' btn-success'"
            @click.prevent="setColors"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            <span class="fas fa-check"></span>
            <span v-text="isColors > 0 ? 'Establecer' : 'Guardar'"></span>
          </button>
        </div> -->
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
export default {
  name: "advancePane",
  data() {
    return {
      fullscreenLoading: false,
      fillColors: {
        //   logo
        colorId: "",
        hideLogo: false,
      },
      shopSettings: {
        catalogueMode: false,
      },
      isColors: null,
    };
  },
  mounted() {
    this.getAdvanced();
    this.getColorCount();
  },
  methods: {
    getColorCount: function () {
      axios.get("/colors/count").then((response) => {
        this.isColors = response.data;
        if (this.isColors > 0) {
          this.getColorSettings();
        }
      });
    },
    getColorSettings: function () {
      axios.get("/colors").then((response) => {
        response.data.forEach((element) => {
          this.fillColors.colorId = element.id;
          this.fillColors.hideLogo = element.hideLogo == "1" ? true : false;
        });
      });
    },
    setColors: function () {
      this.fullscreenLoading = true;
      const params = {
        hideLogo: this.fillColors.hideLogo ? 1 : 0,
      };
      if (this.isColors > 0) {
        axios
          .put(`/colors/${this.fillColors.colorId}`, params)
          .then((response) => {
            if (response.data) {
              this.$toastr.info("El producto se ha actualizado exitosamente");
              this.fullscreenLoading = false;
            }
          });
      } else {
        axios.post("/colors", params).then((response) => {
          if (response.data) {
            this.$toastr.success("Colores guardados");
            this.getColorCount();
            this.fullscreenLoading = false;
          }
        });
      }
    },
    //Advanced Settings
    setAdvanced() {
      this.fullscreenLoading = true;
      const params = {
        advanced_param_1: this.shopSettings.catalogueMode,
      };
      axios
        .post(`/admin/settings/advancedsettings`, params)
        .then((response) => {
          if (response.data) {
            this.$toastr.info("Hecho!!");
            this.fullscreenLoading = false;
          }
        });
    },
    getAdvanced() {
      axios.get(`/admin/settings/getadvancedsettings`).then((response) => {
        if (response.status == 200) {
          this.shopSettings.catalogueMode =
            response.data[0].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
    },
  },
};
</script>

<style>
</style>

<template>
  <div>
    <h2 class="m-0 admin-title">Ajustes de colores</h2>
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
          <div class="col-12 row">
            <div class="col-12 col-sm-3 p-0">
              <div class="card h-100">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo:</label>
                    <el-color-picker
                      v-model="fillColors.hBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card h-100">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto:</label>
                    <el-color-picker
                      v-model="fillColors.hTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card h-100">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color Secundario:</label>
                    <el-color-picker
                      v-model="fillColors.hScColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card h-100">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color Terciario:</label>
                    <el-color-picker
                      v-model="fillColors.hTrColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- BARRA DE NAVEGACION -->
        <section class="mb-4">
          <hgroup>
            <h4>Barra de Navegación</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo: </label>
                    <el-color-picker
                      v-model="fillColors.nvBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto: </label>
                    <el-color-picker
                      v-model="fillColors.nvTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Borde: </label>
                    <el-color-picker
                      v-model="fillColors.nvBrColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- PIE DE PAGINA -->
        <section class="mb-4">
          <hgroup>
            <h4>Pié de Página</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo: </label>
                    <el-color-picker
                      v-model="fillColors.fBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto: </label>
                    <el-color-picker
                      v-model="fillColors.fTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- ICONO COMPRAS -->
        <section class="mb-4">
          <hgroup>
            <h4>Ícono de Compras</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-3 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo: </label>
                    <el-color-picker
                      v-model="fillColors.sbBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Ícono: </label>
                    <el-color-picker
                      v-model="fillColors.sbIcColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color Secundario: </label>
                    <el-color-picker
                      v-model="fillColors.sbScColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-3 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto: </label>
                    <el-color-picker
                      v-model="fillColors.sbTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- ICONO HOME -->
        <section class="mb-4">
          <hgroup>
            <h4>Ícono Home</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo: </label>
                    <el-color-picker
                      v-model="fillColors.hmBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto: </label>
                    <el-color-picker
                      v-model="fillColors.hmTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- CATEGORIAS -->
        <section class="mb-4">
          <hgroup>
            <h4>Categorías</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de fondo: </label>
                    <el-color-picker
                      v-model="fillColors.ctBgColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Texto: </label>
                    <el-color-picker
                      v-model="fillColors.ctTxColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- PRODUCTOS -->
        <section class="mb-4">
          <hgroup>
            <h4>Productos</h4>
          </hgroup>
          <div class="col-12 row">
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Precio: </label>
                    <el-color-picker
                      v-model="fillColors.pPrColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-4 p-0">
              <div class="card">
                <div class="card-body p-1">
                  <div
                    class="d-flex justify-content-between align-items-center"
                  >
                    <label for="">Color de Añadido: </label>
                    <el-color-picker
                      v-model="fillColors.pIcColor"
                      show-alpha
                    ></el-color-picker>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <hr />
        <div class="col-12 text-right">
          <button
            class="btn btn-sm"
            :class="isColors > 0 ? ' btn-primary' : ' btn-success'"
            @click.prevent="setColors"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            <span class="fas fa-check"></span>
            <span v-text="isColors > 0 ? 'Establecer' : 'Guardar'"></span>
          </button>
        </div>
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
export default {
  name: "colorsPane",
  data() {
    return {
      fullscreenLoading: false,
      fillColors: {
        //   logo
        colorId: "",
        //   Cabecera
        hBgColor: "",
        hTxColor: "",
        hScColor: "",
        hTrColor: "",
        //   Navegación
        nvBgColor: "",
        nvTxColor: "",
        nvBrColor: "",
        //   Footer
        fBgColor: "",
        fTxColor: "",
        // ICONO DE COMPRAS
        sbBgColor: "",
        sbIcColor: "",
        sbScColor: "",
        sbTxColor: "",
        // ICONO DE HOME
        hmBgColor: "",
        hmTxColor: "",
        //   Categorias
        ctBgColor: "",
        ctTxColor: "",
        //   Productos
        pPrColor: "",
        pIcColor: "",
      },
      isColors: null,
    };
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
      });
    },
    getColorSettings: function () {
      axios.get("/colors").then((response) => {
        response.data.forEach((element) => {
          this.fillColors.colorId = element.id;
          this.fillColors.hBgColor = element.hBgColor;
          this.fillColors.hTxColor = element.hTxColor;
          this.fillColors.hScColor = element.hScColor;
          this.fillColors.hTrColor = element.hTrColor;
          this.fillColors.nvBgColor = element.nvBgColor;
          this.fillColors.nvTxColor = element.nvTxColor;
          this.fillColors.nvBrColor = element.nvBrColor;
          this.fillColors.fBgColor = element.fBgColor;
          this.fillColors.fTxColor = element.fTxColor;
          this.fillColors.sbBgColor = element.sbBgColor;
          this.fillColors.sbIcColor = element.sbIcColor;
          this.fillColors.sbScColor = element.sbScColor;
          this.fillColors.sbTxColor = element.sbTxColor;
          this.fillColors.hmBgColor = element.hmBgColor;
          this.fillColors.hmTxColor = element.hmTxColor;
          this.fillColors.ctBgColor = element.ctBgColor;
          this.fillColors.ctTxColor = element.ctTxColor;
          this.fillColors.pPrColor = element.pPrColor;
          this.fillColors.pIcColor = element.pIcColor;
        });
      });
    },
    setColors: function () {
      this.fullscreenLoading = true;
      const params = {
        hBgColor: this.fillColors.hBgColor,
        hTxColor: this.fillColors.hTxColor,
        hScColor: this.fillColors.hScColor,
        hTrColor: this.fillColors.hTrColor,
        nvBgColor: this.fillColors.nvBgColor,
        nvTxColor: this.fillColors.nvTxColor,
        nvBrColor: this.fillColors.nvBrColor,
        fBgColor: this.fillColors.fBgColor,
        fTxColor: this.fillColors.fTxColor,
        sbBgColor: this.fillColors.sbBgColor,
        sbIcColor: this.fillColors.sbIcColor,
        sbScColor: this.fillColors.sbScColor,
        sbTxColor: this.fillColors.sbTxColor,
        hmBgColor: this.fillColors.hmBgColor,
        hmTxColor: this.fillColors.hmTxColor,
        ctBgColor: this.fillColors.ctBgColor,
        ctTxColor: this.fillColors.ctTxColor,
        pPrColor: this.fillColors.pPrColor,
        pIcColor: this.fillColors.pIcColor,
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
  },
};
</script>

<style>
</style>

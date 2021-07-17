<template>
  <div>
    <h2 class="m-0 admin-title">Pasarelas y M&eacute;todos de Pago</h2>
    <hr class="mt-0" />
    <!-- Form -->
    <section
      class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
    >
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA -->
        <section class="mb-4">
          <div>
            <img
              class="payment-image"
              :src="`${ruta}/img/payment/cod/cod.png`"
              alt="COD"
            />
            <p class="m-0">
              <small class="text-muted">Países: Todos</small>
            </p>
            <hr />
          </div>
          <div class="d-flex flex-wrap flex-column flex-sm-row">
            <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
              <el-switch
                v-loading.fullscreen.lock="fullscreenLoading"
                v-model="cod_params.cod_param_1"
                active-color="#13ce66"
                inactive-color="#ff0000"
                active-text="Habilitar"
                inactive-text="Deshabilitar"
                :class="'mt-2'"
                @change="setCod"
              >
              </el-switch>
            </div>
            <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
              <el-switch
                v-loading.fullscreen.lock="fullscreenLoading"
                v-model="cod_params.cod_param_2"
                active-color="#13ce66"
                inactive-color="#ff0000"
                active-text="Sólo Efectivo"
                inactive-text=""
                :class="'mt-2'"
                @change="setCod"
              >
              </el-switch>
            </div>
          </div>
        </section>
        <hr class="border-dark" />
      </div>
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA -->
        <section class="mb-4">
          <div>
            <img
              class="payment-image"
              :src="`${ruta}/img/payment/paguelofacil/paguelofacil.png`"
              alt="PagueloFacil"
            />
            <p class="m-0">
              <small class="text-muted">Países: Panamá</small>
            </p>
            <hr />
          </div>
          <div class="col-12" v-if="paguelofacil_params.paguelofacil_param_3">
            <div class="input-group mb-3 col-12">
              <div class="input-group-prepend">
                <span class="input-group-text">CCWL</span>
              </div>
              <input
                type="text"
                class="form-control"
                aria-describedby="basic-addon3"
                v-model="paguelofacil_params.paguelofacil_param_1"
              />
            </div>
            <div class="input-group mb-3 col-12">
              <div class="input-group-prepend">
                <span class="input-group-text">URL DE RETORTNO</span>
              </div>
              <input
                type="text"
                class="form-control"
                aria-describedby="basic-addon3"
                v-model="paguelofacil_params.paguelofacil_param_2"
              />
            </div>
            <p class="text-danger">
              <small
                >** Para configurar la <b>URL DE RETORNO</b> por favor convierte
                este
                <button
                  class="btn btn-sm btn-info py-0"
                  v-clipboard:copy="paguelofacil_params.paguelofacil_param_4"
                  v-clipboard:success="onCopy"
                >
                  enlace
                </button>
                a formato hexadecimal
                <b
                  ><a
                    href="https://www.online-toolz.com/langs/es/tool-es-text-hex-convertor.html"
                    target="_blank"
                    rel="noreferrer noopener"
                    >aqu&iacute;</a
                  ></b
                >
                y copie el resultado en el recuadro.</small
              >
            </p>
          </div>
          <div class="d-flex flex-wrap flex-column flex-sm-row">
            <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
              <el-switch
                v-model="paguelofacil_params.paguelofacil_param_3"
                active-color="#13ce66"
                inactive-color="#ff0000"
                active-text="Habilitar"
                inactive-text="Deshabilitar"
                :class="'mt-2'"
              >
              </el-switch>
            </div>
          </div>
          <div class="col-12 text-right">
            <button
              class="btn btn-sm"
              :class="isColors > 0 ? ' btn-primary' : ' btn-success'"
              @click.prevent="setPaguelofacil"
              v-loading.fullscreen.lock="fullscreenLoading"
            >
              <span class="fas fa-check"></span>
              <span v-text="'Guardar'"></span>
            </button>
          </div>
        </section>
        <hr class="border-dark" />
      </div>
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA -->
        <section class="mb-4">
          <div>
            <img
              class="payment-image"
              :src="`${ruta}/img/payment/epayco/epayco_logo.png`"
              alt="epayco"
            />
            <p class="m-0">
              <small class="text-muted">Países: Colombia</small>
            </p>
            <hr />
          </div>
          <div class="col-12" v-if="epayco_params.epayco_param_5">
            <div class="col-12 row">
              <div class="input-group mb-3 col-12 col-sm-6">
                <div class="input-group-prepend">
                  <span class="input-group-text">ID_CLIENTE</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  aria-describedby="basic-addon3"
                  v-model="epayco_params.epayco_param_1"
                />
              </div>
              <div class="input-group mb-3 col-12 col-sm-6">
                <div class="input-group-prepend">
                  <span class="input-group-text">P_KEY</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  aria-describedby="basic-addon3"
                  v-model="epayco_params.epayco_param_2"
                />
              </div>
            </div>
            <div class="col-12 row">
              <div class="input-group mb-3 col-12 col-sm-6">
                <div class="input-group-prepend">
                  <span class="input-group-text">PUBLIC_KEY</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  aria-describedby="basic-addon3"
                  v-model="epayco_params.epayco_param_3"
                />
              </div>
              <div class="input-group mb-3 col-12 col-sm-6">
                <div class="input-group-prepend">
                  <span class="input-group-text">PRIVATE_KEY</span>
                </div>
                <input
                  type="text"
                  class="form-control"
                  aria-describedby="basic-addon3"
                  v-model="epayco_params.epayco_param_4"
                />
              </div>
            </div>
            <div class="col-12 col-sm-6 text-right pt-1 ml-auto">
              <el-switch
                v-model="epayco_params.epayco_param_6"
                active-color="#13ce66"
                inactive-color="#ff0000"
                active-text="Produccion"
                inactive-text="Pruebas"
                :class="'mt-2'"
              >
              </el-switch>
            </div>
          </div>
          <div class="d-flex flex-wrap flex-column flex-sm-row">
            <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
              <el-switch
                v-model="epayco_params.epayco_param_5"
                active-color="#13ce66"
                inactive-color="#ff0000"
                active-text="Habilitar"
                inactive-text="Deshabilitar"
                :class="'mt-2'"
              >
              </el-switch>
            </div>
          </div>
        </section>
        <hr />
        <div class="col-12 text-right">
          <button
            class="btn btn-sm"
            :class="isColors > 0 ? ' btn-primary' : ' btn-success'"
            @click.prevent="setEpayco"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            <span class="fas fa-check"></span>
            <span v-text="'Guardar'"></span>
          </button>
        </div>
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  name: "payments",
  data() {
    return {
      fullscreenLoading: false,
      isColors: null,
      //   payment Methods
      //COD
      cod_params: {
        cod_param_1: false,
        cod_param_2: false,
      },
      //EPAYCO
      epayco_params: {
        epayco_param_1: "",
        epayco_param_2: "",
        epayco_param_3: "",
        epayco_param_4: "",
        epayco_param_5: false,
        epayco_param_6: false,
      },
      //PAGUELOFACIL
      paguelofacil_params: {
        paguelofacil_param_1: "",
        paguelofacil_param_2: "",
        paguelofacil_param_3: false,
        paguelofacil_param_4: `${this.ruta}/paguelofacil/response/`,
      },
    };
  },
  mounted() {
    this.getEpayco();
    this.getCod();
    this.getPaguelofacil();
  },
  methods: {
    onCopy: function () {
      this.$toastr.info("Copiado en el portapapeles");
    },
    getColorCount: function () {
      axios.get("/colors/count").then((response) => {
        this.isColors = response.data;
      });
    },
    // EPAYCO
    setEpayco() {
      this.fullscreenLoading = true;
      const params = {
        epayco_param_1: this.epayco_params.epayco_param_1,
        epayco_param_2: this.epayco_params.epayco_param_2,
        epayco_param_3: this.epayco_params.epayco_param_3,
        epayco_param_4: this.epayco_params.epayco_param_4,
        epayco_param_5: this.epayco_params.epayco_param_5,
        epayco_param_6: this.epayco_params.epayco_param_6,
      };
      axios.post(`/admin/epayco`, params).then((response) => {
        if (response.data) {
          this.$toastr.info("Hecho!!");
          this.fullscreenLoading = false;
        }
      });
    },
    getEpayco() {
      axios.get(`/admin/epayco`).then((response) => {
        if (response.status == 200) {
          this.epayco_params.epayco_param_1 = response.data[1].value;
          this.epayco_params.epayco_param_2 = response.data[2].value;
          this.epayco_params.epayco_param_3 = response.data[3].value;
          this.epayco_params.epayco_param_4 = response.data[4].value;
          this.epayco_params.epayco_param_5 =
            response.data[0].value == 1 ? true : false;
          this.epayco_params.epayco_param_6 =
            response.data[5].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
    },
    //COD
    setCod() {
      this.fullscreenLoading = true;
      const params = {
        cod_param_1: this.cod_params.cod_param_1,
        cod_param_2: this.cod_params.cod_param_2,
      };
      axios.post(`/admin/cod`, params).then((response) => {
        if (response.data) {
          this.$toastr.info("Hecho!!");
          this.fullscreenLoading = false;
        }
      });
    },
    getCod() {
      axios.get(`/admin/cod`).then((response) => {
        if (response.status == 200) {
          this.cod_params.cod_param_1 =
            response.data[0].value == 1 ? true : false;
          this.cod_params.cod_param_2 =
            response.data[1].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
    },
    setPaguelofacil() {
      this.fullscreenLoading = true;
      const params = {
        paguelofacil_param_1: this.paguelofacil_params.paguelofacil_param_1,
        paguelofacil_param_2: this.paguelofacil_params.paguelofacil_param_2,
        paguelofacil_param_3: this.paguelofacil_params.paguelofacil_param_3,
      };
      axios.post(`/admin/paguelofacil`, params).then((response) => {
        if (response.data) {
          this.$toastr.info("Hecho!!");
          this.fullscreenLoading = false;
        }
      });
    },
    getPaguelofacil() {
      axios.get(`/admin/paguelofacil`).then((response) => {
        if (response.status == 200) {
          this.paguelofacil_params.paguelofacil_param_1 =
            response.data[1].value;
          this.paguelofacil_params.paguelofacil_param_2 =
            response.data[2].value;
          this.paguelofacil_params.paguelofacil_param_3 =
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

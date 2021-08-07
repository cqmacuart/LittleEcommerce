<template>
  <div>
    <section class="mb-4">
      <div>
        <img class="payment-image" :src="`${ruta}/img/payment/epayco/epayco_logo.png`" alt="epayco" />
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
          ></el-switch>
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
          ></el-switch>
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
</template>

<script>
export default {
  name: "EpaycoComponent",
  props: ["ruta"],
  data() {
    return {
      fullscreenLoading: false,
      isColors: null,
      //EPAYCO
      epayco_params: {
        epayco_param_1: "",
        epayco_param_2: "",
        epayco_param_3: "",
        epayco_param_4: "",
        epayco_param_5: false,
        epayco_param_6: false,
      },
    };
  },
  mounted() {
    this.getEpayco();
  },
  methods: {
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
  },
};
</script>

<style>

</style>

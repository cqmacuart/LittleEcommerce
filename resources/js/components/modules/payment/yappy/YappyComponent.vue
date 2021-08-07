<template>
  <div>
    <section class="mb-4">
      <div>
        <img class="payment-image" :src="`${ruta}/img/payment/yappy/yappy_logo.png`" alt="yappy" />
        <p class="m-0">
          <small class="text-muted">Países: Panamá</small>
        </p>
        <hr />
      </div>
      <div class="col-12" v-if="yappy_params.param_5">
        <div class="col-12 row">
          <div class="input-group mb-3 col-12 col-sm-6">
            <div class="input-group-prepend">
              <span class="input-group-text">ID_DEL_COMERCIO</span>
            </div>
            <input
              type="text"
              class="form-control"
              aria-describedby="basic-addon3"
              v-model="yappy_params.param_1"
            />
          </div>
          <div class="input-group mb-3 col-12 col-sm-6">
            <div class="input-group-prepend">
              <span class="input-group-text">CLAVE_SECRETA</span>
            </div>
            <input
              type="text"
              class="form-control"
              aria-describedby="basic-addon3"
              v-model="yappy_params.param_2"
            />
          </div>
        </div>
        <div class="col-12 row">
          <div class="input-group mb-3 col-12 col-sm-6">
            <div class="input-group-prepend">
              <span class="input-group-text">DOMINIO</span>
            </div>
            <input
              type="text"
              class="form-control"
              aria-describedby="basic-addon3"
              v-model="yappy_params.param_3"
            />
          </div>
        </div>
        <div class="col-12 col-sm-6 text-right pt-1 ml-auto">
          <el-switch
            v-model="yappy_params.param_4"
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
            v-model="yappy_params.param_5"
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
        @click.prevent="setyappy"
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
  name: "yappyComponent",
  props: ["ruta"],
  data() {
    return {
      fullscreenLoading: false,
      isColors: null,
      //yappy
      yappy_params: {
        param_1: "", //IDCOMERCIO
        param_2: "", //CLAVE
        param_3: "", //DOMINIO
        param_4: false, //PRODUCCION/PRUEBAS
        param_5: false, //Enabled/Disabled
      },
    };
  },
  mounted() {
    this.getyappy();
  },
  methods: {
    // yappy
    setyappy() {
      this.fullscreenLoading = true;
      this.yappy_params.param_3 =
        !this.yappy_params.param_3 || !this.yappy_params.param_3.length
          ? this.ruta
          : this.yappy_params.param_3;
      const params = {
        param_1: this.yappy_params.param_1,
        param_2: this.yappy_params.param_2,
        param_3: this.yappy_params.param_3,
        param_4: this.yappy_params.param_4,
        param_5: this.yappy_params.param_5,
      };
      axios.post(`/admin/yappy`, params).then((response) => {
        if (response.data) {
          this.$toastr.info("Hecho!!");
          this.fullscreenLoading = false;
        }
      });
    },

    getyappy() {
      axios.get(`/admin/yappy`).then((response) => {
        if (response.status == 200) {
          this.yappy_params.param_1 = response.data[0].value;
          this.yappy_params.param_2 = response.data[1].value;
          this.yappy_params.param_3 = response.data[2].value;
          this.yappy_params.param_4 =
            response.data[3].value == 1 ? true : false;
          this.yappy_params.param_5 =
            response.data[4].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
    },
  },
};
</script>

<style>

</style>

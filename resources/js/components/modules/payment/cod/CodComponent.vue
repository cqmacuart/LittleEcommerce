<template>
  <!-- CABECERA COBRO DESTINO-->
  <section class="mb-4">
    <div>
      <img class="payment-image" :src="`${ruta}/img/payment/cod/cod.png`" alt="COD" />
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
        ></el-switch>
      </div>
      <div class="col-12 col-sm-6 text-left pt-2 pt-sm-1">
        <el-switch
          v-loading.fullscreen.lock="fullscreenLoading"
          v-model="cod_params.cod_param_2"
          active-color="#13ce66"
          inactive-color="#ff0000"
          active-text="Sólo Efectivo"
          inactive-text
          :class="'mt-2'"
          @change="setCod"
        ></el-switch>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "CodComponent",
  props: ["ruta"],
  data() {
    return {
      fullscreenLoading: false,
      //COD
      cod_params: {
        cod_param_1: false,
        cod_param_2: false,
      },
    };
  },
  mounted() {
    this.getCod();
  },
  methods: {
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
  },
};
</script>

<style>

</style>

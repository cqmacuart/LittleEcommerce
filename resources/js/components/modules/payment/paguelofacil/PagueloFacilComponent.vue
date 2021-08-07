<template>
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
        <small>
          ** Para configurar la
          <b>URL DE RETORNO</b> por favor convierte
          este
          <button
            class="btn btn-sm btn-info py-0"
            v-clipboard:copy="paguelofacil_params.paguelofacil_param_4"
            v-clipboard:success="onCopy"
          >enlace</button>
          a formato hexadecimal
          <b>
            <a
              href="https://www.online-toolz.com/langs/es/tool-es-text-hex-convertor.html"
              target="_blank"
              rel="noreferrer noopener"
            >aqu&iacute;</a>
          </b>
          y copie el resultado en el recuadro.
        </small>
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
        ></el-switch>
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
</template>

<script>
export default {
  name: "PagueloFacilComponent",
  props: ["ruta"],
  mounted() {
    this.getPaguelofacil();
  },
  data() {
    return {
      fullscreenLoading: false,
      isColors: null,
      //PAGUELOFACIL
      paguelofacil_params: {
        paguelofacil_param_1: "",
        paguelofacil_param_2: "",
        paguelofacil_param_3: false,
        paguelofacil_param_4: `${this.ruta}/paguelofacil/response/`,
      },
    };
  },
  methods: {
    // PAGUELO FACIL
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

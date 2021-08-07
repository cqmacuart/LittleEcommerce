<template>
  <div>
    <h2 class="m-0 admin-title">Pasarelas y M&eacute;todos de Pago</h2>
    {{ruta}}
    <hr class="mt-0" />
    <!-- Form -->
    <section class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2">
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA COBRO DESTINO-->
        <CodComponentVue :ruta="ruta"></CodComponentVue>
        <hr class="border-dark" />
      </div>
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA PAGUELO FACIL-->
        <PagueloFacilComponentVue :ruta="ruta"></PagueloFacilComponentVue>
        <hr class="border-dark" />
      </div>
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA Yappy-->
        <YappyComponentVue :ruta="ruta"></YappyComponentVue>
        <hr class="border-dark" />
      </div>
      <div class="col-12 px-0 px-sm-2">
        <!-- CABECERA EPAYCO-->
        <EpaycoComponentVue :ruta="ruta"></EpaycoComponentVue>
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
import CodComponentVue from "../../payment/cod/CodComponent.vue";
import EpaycoComponentVue from "../../payment/epayco/EpaycoComponent.vue";
import PagueloFacilComponentVue from "../../payment/paguelofacil/PagueloFacilComponent.vue";
import YappyComponentVue from "../../payment/yappy/YappyComponent.vue";

export default {
  props: ["ruta"],
  name: "payments",
  components: {
    CodComponentVue,
    EpaycoComponentVue,
    PagueloFacilComponentVue,
    YappyComponentVue,
  },
  data() {
    return {
      fullscreenLoading: false,
      isColors: null,
    };
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
  },
};
</script>

<style>
</style>

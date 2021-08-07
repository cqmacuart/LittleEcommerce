<template>
  <div>
    <h1 class="text-center py-5">Pagado con Éxito</h1>
    <hr />
    <p
      class="text-success text-center col-12 col-sm-10 col-md-9 mx-auto"
    >Gracias por utilizar nuestros servicios.</p>
    <p
      class="text-muted text-center col-12 col-sm-10 col-md-9 mx-auto"
    >Su pago ha sido realizado con éxito, será dirigido a su pedido en breve.</p>
    <hr />
    <div v-loading.fullscreen.lock="fullscreenLoading">
      <div class="col-12 pt-0 pb-1 text-center px-0">
        <small class="text-muted py-2 text-uppercase">Referencia de pago: {{$route.query.orden}}</small>
      </div>
      <div class="table-responsive col-10 col-sm-8 col-md-6 m-auto">
        <table class="table" v-if="orderHeader.length > 0">
          <caption>
            Será redireccionado en
            <span v-text="time"></span>
            segundos.
          </caption>
          <tr>
            <th class="text-nowrap text-left" style="width: 1%">Referencia</th>
            <td class="text-right">{{ orderHeader[0].pedido }}</td>
          </tr>
          <tr>
            <th class="text-nowrap text-left" style="width: 1%">Fecha</th>
            <td class="text-right">
              {{ new Date().getDate() }} - {{ new Date().getMonth() + 1 }} -
              {{ new Date().getFullYear() }}
            </td>
          </tr>
          <tr>
            <th class="text-nowrap text-left" style="width: 1%">Respuesta</th>
            <td class="text-right">01</td>
          </tr>
          <tr>
            <th class="text-nowrap text-left" style="width: 1%">Motivo</th>
            <td class="text-right">Pagado con Yappy</td>
          </tr>
          <tr>
            <th class="text-nowrap text-left" style="width: 1%">Total</th>
            <td class="text-right">
              {{ orderHeader[0].amount | numeral("0,0.00") }}
              {{ fillSetting.currency }}
            </td>
          </tr>
        </table>
        <div class="text-center">
          <a :href="$attrs.ruta" class="btn btn-success">CONTINUAR.</a>
        </div>
      </div>
      <section class="container-md p-0 p-sm-3 col-12 d-flex flex-wrap"></section>
    </div>
  </div>
</template>

<script>
export default {
  name: "YappyResponsePage",
  data() {
    return {
      //datos de usuario
      nombre: "",
      ciudad: "",
      direccion: "",
      celular: "",
      email: "",
      comentario: "",
      notificacion: true,
      fullscreenLoading: true,
      fillColors: {
        ok: false,
        //   footer
        sbBgColor: "",
        sbIcColor: "",
        sbScColor: "",
        sbTxColor: "",
        hmBgColor: "",
        hmTxColor: "",
        ctBgColor: "",
        ctTxColor: "",
        pPrColor: "",
        pIcColor: "",
      },
      fillSetting: {
        storename: "",
        mobile: "",
        city: "",
        country: "",
        image: "",
        currency: "",
      },
      orderHeader: [],
      orderCustomer: [],
      time: 15,
    };
  },
  computed: {
    customStyle() {
      //   sb = SHOPPING BAG
      // hm = HOME
      return {
        "--bg-sb-color": this.fillColors.sbBgColor
          ? this.fillColors.sbBgColor
          : "#333333",
        "--icon-sb-color": this.fillColors.sbIcColor
          ? this.fillColors.sbIcColor
          : "#FFFFFF",
        "--second-sb-color": this.fillColors.sbScColor
          ? this.fillColors.sbScColor
          : "#3490DC",
        "--text-sb-color": this.fillColors.sbTxColor
          ? this.fillColors.sbTxColor
          : "#FFFFFF",
        "--bg-hm-color": this.fillColors.hmBgColor
          ? this.fillColors.hmBgColor
          : "#000000",
        "--text-hm-color": this.fillColors.hmTxColor
          ? this.fillColors.hmTxColor
          : "#FFFFFF",
        "--bg-ct-color": this.fillColors.ctBgColor
          ? this.fillColors.ctBgColor
          : "#FFFFFF",
        "--text-ct-color": this.fillColors.ctTxColor
          ? this.fillColors.ctTxColor
          : "#333333",
        "--text-p-color": this.fillColors.pPrColor
          ? this.fillColors.pPrColor
          : "gray",
        "--icon-p-color": this.fillColors.pIcColor
          ? this.fillColors.pIcColor
          : "red",
      };
    },
  },
  mounted() {
    this.getColorCount();
    this.getPayInfo();
    this.getAllSettings();
  },
  methods: {
    getAllSettings: function () {
      this.settings = [];
      axios
        .get("/admin/settings")
        .then((response) => {
          this.fillSetting.storename = response.data.storename;
          this.fillSetting.mobile = response.data.mobile;
          this.fillSetting.image = response.data.image;
          this.fillSetting.currency = response.data.currency;
          this.fillSetting.country = response.data.country;
          this.fillSetting.city = response.data.city;
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getPayInfo() {
      axios
        .get(`/miorden/yappy/${this.$route.query.orden}`)
        .then((response) => {
          if (response.status == 200) {
            this.orderHeader = response.data.order;
            this.orderCustomer = response.data.customer;
            setTimeout(() => {
              window.open(
                `https://wa.me/${this.fillSetting.mobile}?text= Hola, Me gustaría realizar el siguiente pedido: ${this.orderHeader[0].link}`,
                `_blank`
              );
            }, 3000);
            setInterval(() => {
              this.time--;
            }, 1000);
            setTimeout(() => {
              this.$router.push({
                name: "mipedido",
                params: { serial: response.data.order[0].serialize },
              });
            }, 15000);
          } else {
            this.error = "El token de la orden es incorrecto o no existe";
          }
        });
    },
    //   ESTILOS
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
      return true;
    },
    getColorSettings: function () {
      axios.get("/colors").then((response) => {
        response.data.forEach((element) => {
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

      this.fullscreenLoading = false;
    },
  },
};
</script>

<style>

</style>

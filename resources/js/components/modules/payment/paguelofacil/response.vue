<template>
  <div v-loading.fullscreen.lock="fullscreenLoading">
    <div class="col-12 pt-0 pb-1 text-center px-0">
      <h5
        v-if="fillColors.ok"
        class="font-weight-bolder customer-title custom-category-style py-2"
        v-text="'Respuesta de Transacción'"
      ></h5>
      <h5 v-else><i class="el-icon-loading"></i></h5>
      <small
        class="text-muted py-2"
        v-text="`Referencia de pago: ${ref_payco}`"
      ></small>
    </div>
    <div class="table-responsive col-10 col-sm-8 col-md-6 m-auto">
      <table class="table">
        <caption>
          Será redireccionado en
          <span v-text="time"></span>
          segundos.
        </caption>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Referencia</th>
          <td class="text-right">{{ referencia }}</td>
        </tr>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Fecha</th>
          <td class="text-right">{{ fecha }}</td>
        </tr>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Respuesta</th>
          <td class="text-right">{{ respuesta }}</td>
        </tr>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Motivo</th>
          <td class="text-right">{{ motivo }}</td>
        </tr>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Recibo</th>
          <td class="text-right">{{ recibo }}</td>
        </tr>
        <tr>
          <th class="text-nowrap text-left" style="width: 1%">Total</th>
          <td class="text-right">
            {{ total | numeral("0,0.00") }} {{ moneda }}
          </td>
        </tr>
      </table>
      <div class="text-center">
        <a :href="ruta" class="btn btn-success"> CONTINUAR. </a>
      </div>
    </div>
    <section class="container-md p-0 p-sm-3 col-12 d-flex flex-wrap"></section>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
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
      ref_payco: "",
      //   DATOS DE RESPUESTA
      referencia: "", //x_transaction_id
      fecha: "",
      respuesta: "",
      motivo: "",
      banco: "",
      recibo: "",
      total: "",
      moneda: "",

      //   ARREGLO BASE DE DATOS
      type_payment: null,
      cod_transaction_state: null,
      errorcode: null,
      cust_id_cliente: null,
      id_factura: null,
      franchise: null,
      cardnumber: null,
      customer_ip: null,
      fillSetting: {
        storename: "",
        mobile: "",
        city: "",
        country: "",
        image: "",
        currency: "",
      },
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
  },
  methods: {
    getPayInfo() {
      this.nombre = this.$route.query.PARM_1;
      this.ciudad = this.$route.query.PARM_2;
      this.direccion = this.$route.query.PARM_3;
      this.celular = this.$route.query.PARM_4;
      this.email = this.$route.query.PARM_5;
      this.comentario = this.$route.query.PARM_6;
      this.notificacion = this.$route.query.PARM_7 == "true" ? true : false;

      this.referencia = this.$route.query.Oper;
      this.fecha = this.$route.query.Fecha;
      this.respuesta = this.$route.query.Estado;
      this.motivo = this.$route.query.Razon;
      this.recibo = this.$route.query.Oper;
      this.total = this.$route.query.TotalPagado;
      this.moneda = "USD";
      //Datos adicionales de transaccion
      this.type_payment = this.$route.query.Tipo;
      this.cod_transaction_state = this.$route.query.Estado;
      this.cust_id_cliente = this.$route.query.Usuario;
      this.id_factura = this.$route.query.Oper;
      this.franchise = this.$route.query.Tipo;

      this.setOrder();
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
    setOrder: function () {
      this.fullscreenLoading = true;
      const params = {
        nombre: this.nombre,
        ciudad: this.ciudad,
        direccion: this.direccion,
        celular: this.celular,
        email: this.email,
        comentario: this.comentario,
        notificacion: this.notificacion,
        //   datos de transacción
        referencia: this.referencia,
        fecha: this.fecha,
        respuesta: this.respuesta,
        motivo: this.motivo,
        banco: this.banco,
        recibo: this.recibo,
        total: this.total,
        moneda: this.moneda,
        //Datos adicionales de transaccion
        type_payment: this.type_payment,
        cod_transaction_state: this.cod_transaction_state,
        errorcode: this.errorcode,
        cust_id_cliente: this.cust_id_cliente,
        id_factura: this.id_factura,
        franchise: this.franchise,
        cardnumber: this.cardnumber,
        customer_ip: this.customer_ip,
        medio: "Paguelo Facil",
      };
      axios.post("/orders", params).then((response) => {
        if (response.status == 200) {
          //salvar el token
          setTimeout(() => {
            window.open(
              `https://wa.me/${this.fillSetting.mobile}?text= Hola, Me gustaría realizar el siguiente pedido: ${this.orderHeader[0].link}`,
              `_blank`
            );
          }, 3000);
          let token = response.data.serialize;
          const mailparams = {
            pedido: response.data.pedido,
            enlace: response.data.link,
          };
          //establecer parametros de envío de MAIL
          axios.post("/sendingmail/nuevo", mailparams).then((response) => {
            if (sessionStorage.getItem("currCustomer")) {
              sessionStorage.removeItem("currCustomer");
            }
            setInterval(() => {
              this.time--;
            }, 1000);
            setTimeout(() => {
              this.$router.push({
                name: "mipedido",
                params: { serial: token },
              });
            }, 15000);
            this.fullscreenLoading = false;
          });
        }
      });
    },
  },
};
</script>

<style>
.custom-sb-styles {
  background: var(--bg-sb-color) !important;
  overflow: visible;
  max-width: 55px;
  max-height: 55px;
  border-radius: 50px;
}

.custom-sb-styles .fa-shopping-bag {
  color: var(--icon-sb-color) !important;
}

.custom-sb-styles .fa-layers-bottom-left {
  background-color: var(--second-sb-color) !important;
  border-color: var(--text-sb-color) !important;
  color: var(--text-sb-color) !important;
}

.custom-hm-styles {
  background-color: var(--bg-hm-color) !important;
  color: var(--text-hm-color) !important;
}

.custom-hm-styles .fa-home {
  color: var(--text-hm-color) !important;
}

.custom-category-style {
  background-color: var(--bg-ct-color) !important;
  color: var(--text-ct-color) !important;
}

.custom-price-style {
  color: var(--text-p-color) !important;
}

.custom-addicon-style {
  color: var(--icon-p-color) !important;
}
</style>

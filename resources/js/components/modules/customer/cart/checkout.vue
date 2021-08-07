<template>
  <div v-if="ok" :style="customStyle">
    <div class="col-12 pt-2 pb-1 text-center border-bottom">
      <h5 v-if="fillColors.ok" class="font-weight-bolder customer-title custom-checkout-style">
        Confirmar Pedido
        <span class="fas fa-check-circle fa-2x custom-checkout-style"></span>
      </h5>
      <h5 v-else>
        <i class="el-icon-loading"></i>
      </h5>
    </div>
    <div class="col-12 m-auto p-0 d-flex flex-col flex-sm-row row">
      <section class="container-md p-0 p-sm-3 col-12 col-sm-6">
        <div class="col-12 p-0 bg-white h-100">
          <table class="table table-bordered m-0">
            <caption>
              <small>
                Complete los campos obligatorios (
                <span class="text-danger">*</span>) para realizar su pedido.
              </small>
            </caption>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle" style="width: 1%">
                <span>*</span>
                Nombre
              </th>
              <td>
                <el-input
                  autocomplete="ON"
                  placeholder="Nombre de Cliente"
                  v-model="nombre"
                  maxlength="20"
                  show-word-limit
                ></el-input>
              </td>
            </tr>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle">
                <span>*</span>
                Ciudad
              </th>
              <td>
                <el-input
                  autocomplete="ON"
                  placeholder="Ciudad"
                  v-model="ciudad"
                  maxlength="20"
                  show-word-limit
                ></el-input>
              </td>
            </tr>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle">
                <span>*</span>
                Dirección
              </th>
              <td>
                <el-input
                  autocomplete="ON"
                  placeholder="Dirección"
                  v-model="direccion"
                  maxlength="120"
                  show-word-limit
                ></el-input>
              </td>
            </tr>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle">
                <span>*</span>
                Celular
              </th>
              <td>
                <el-input
                  autocomplete="ON"
                  placeholder="Teléfono Celular"
                  v-model="celular"
                  @blur="trimCelphone"
                ></el-input>
              </td>
            </tr>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle">
                <span>*</span>
                Email
              </th>
              <td>
                <el-input
                  autocomplete="ON"
                  placeholder="Email"
                  v-model="email"
                  @blur="trimEmail"
                  type="email"
                ></el-input>
              </td>
            </tr>
            <tr>
              <th class="bg-secondary font-weight-bolder text-white align-middle">Comentarios</th>
              <td>
                <el-input
                  placeholder="Comentarios adicionales (opcional)"
                  v-model="comentario"
                  maxlength="120"
                  show-word-limit
                ></el-input>
              </td>
            </tr>
            <tr>
              <th
                class="bg-secondary font-weight-bolder text-white align-middle"
              >Recibir Notificación</th>
              <td class="align-middle">
                <el-switch v-model="notificacion" active-text="Si" inactive-text="No"></el-switch>
              </td>
            </tr>
          </table>
        </div>
      </section>
      <section class="container-md p-0 p-sm-3 col-12 col-sm-6 pb-3 clearfix mt-2 mt-sm-0">
        <div class="col-12 p-0 bg-white h-100">
          <table class="table table-bordered m-0">
            <caption class="pl-3 text-muted">
              <small>**El valor del domicilio no se encuentra incluído</small>
            </caption>
            <tr>
              <th class="totalize text-black" style="width: 1%">Artículos</th>
              <td class="text-right">
                <router-link :to="{ name: 'cart' }" class="totalize">{{ totalItems }} Artículo(s)</router-link>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black">Total</th>
              <td class="text-right">
                <label
                  class="totalize custom-price-style"
                  for
                >{{ currency }} {{ totalAmount | numeral("0,0.00") }}</label>
              </td>
            </tr>
          </table>
          <!-- <button
            class="btn btn-success btn-lg float-right mr-4 mb-4"
            @click.prevent="setOrder"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            Pedir
          </button>-->

          <!-- VALIDAR DATOS PRIMERO -->
          <div v-if="validate()">
            <!--VERIFICAR COD -->
            <div v-if="cod_params.cod_param_1" class="mb-3">
              <div class="accordion" id="accordionExample">
                <div class="card border-0">
                  <div class id="headingOne">
                    <div class="text-center">
                      <img
                        src="/img/payment/cod/codbutton.png"
                        style="cursor: pointer"
                        data-toggle="collapse"
                        data-target="#collapseOne"
                        aria-expanded="true"
                        aria-controls="collapseOne"
                      />
                    </div>
                  </div>
                  <div
                    id="collapseOne"
                    class="collapse"
                    aria-labelledby="headingOne"
                    data-parent="#accordionExample"
                  >
                    <div class="card-body py-1">
                      <p class="m-0 text-muted text-center">
                        <small>Pague al recibir/retirar su pedido</small>
                      </p>
                      <div
                        class="row d-flex flex-column flex-sm-row justify-content-center align-items-center mb-3"
                      >
                        <label
                          v-if="!cod_params.cod_param_2"
                          class="d-flex m-0 align-items-center px-2 pb-3 pb-sm-0"
                        >
                          <img src="/img/payment/cod/cash_disable.png" v-if="cod_params.cod_choose" />
                          <img src="/img/payment/cod/cash.png" v-else />
                          <el-switch
                            style="display: block; visibility: hidden"
                            v-model="cod_params.cod_choose"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                          ></el-switch>
                          <img
                            src="/img/payment/cod/dataphone_disable.png"
                            v-if="!cod_params.cod_choose"
                          />
                          <img src="/img/payment/cod/dataphone.png" v-else />
                        </label>
                        <label v-else class="d-flex m-0 align-items-center px-2 pb-3 pb-sm-0">
                          <img src="/img/payment/cod/cash.png" />
                        </label>
                        <button
                          class="btn btn-success px-2"
                          v-loading.fullscreen.lock="fullscreenLoading"
                          @click.prevent="setCod"
                        >
                          <b>Ordenar</b>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--COD END -->

            <!--VERIFICAR EPAYCO -->
            <div
              v-if="
                epayco_params.epayco_existed && epayco_params.epayco_param_5
              "
              class="mb-3"
            >
              <div class="text-center">
                <img
                  src="/img/payment/epayco/epayco.png"
                  @click="epaycoform()"
                  style="cursor: pointer"
                />
              </div>
            </div>
            <!-- EPAYCO END -->
            <!--VERIFICAR Paguelofacil -->
            <div class="mb-3" v-if="paguelofacil_params.paguelofacil_param_3">
              <div class="text-center">
                <a
                  :href="`https://secure.paguelofacil.com/LinkDeamon.cfm?CCLW=${paguelofacil_params.paguelofacil_param_1}&CMTN=${totalAmount}&CDSC=${paguelofacil_params.paguelofacil_param_4}&RETURN_URL=${paguelofacil_params.paguelofacil_param_2}&PARM_1=${paguelofacil_params.paguelofacil_param_5}&PARM_2=${paguelofacil_params.paguelofacil_param_6}&PARM_3=${paguelofacil_params.paguelofacil_param_7}&PARM_4=${paguelofacil_params.paguelofacil_param_8}&PARM_5=${paguelofacil_params.paguelofacil_param_9}&PARM_6=${paguelofacil_params.paguelofacil_param_10}&PARM_7=${paguelofacil_params.paguelofacil_param_11}`"
                >
                  <img src="/img/payment/paguelofacil/paguelofacil_on.png" />
                </a>
              </div>
            </div>
            <!-- Paguelofacil END -->
            <!--VERIFICAR YAPPY -->
            <div class="text-center mb-3" v-if="yappy_params.param_5">
              <img
                v-if="!yappy_params.loading"
                src="/img/payment/yappy/yappy-on.png"
                class="yappy-button"
                @click="yappyVerify()"
              />
              <div v-else>
                <i class="fas fa-spinner fa-spin"></i>
              </div>
            </div>
            <!-- YAPPY END -->
          </div>
          <div v-else class="text-center">
            <small class="text-danger">
              Complete los datos obligatorios para desplegar medios de
              pago
            </small>
            <div>
              <div class="text-center mb-3" v-if="cod_params.cod_param_1">
                <img src="/img/payment/cod/codbutton_disable.png" />
              </div>
              <div
                class="text-center mb-3"
                v-if="
                  epayco_params.epayco_existed && epayco_params.epayco_param_5
                "
              >
                <img src="/img/payment/epayco/epayco_gris.png" />
              </div>
              <div
                class="text-center mb-3"
                v-if="
                  paguelofacil_params.paguelofacil_existed &&
                  paguelofacil_params.paguelofacil_param_3
                "
              >
                <img src="/img/payment/paguelofacil/paguelofacil_off.png" />
              </div>
              <div class="text-center mb-3" v-if="yappy_params.param_5">
                <img src="/img/payment/yappy/yappy-off.png" />
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  props: ["currency", "ruta"],
  data() {
    return {
      totalItems: 0,
      totalAmount: 0,
      //datos de usuario
      nombre: "",
      ciudad: "",
      direccion: "",
      celular: "",
      email: "",
      comentario: "",
      notificacion: true,
      ok: false,
      fillSetting: {
        storename: "",
        mobile: "",
        city: "",
        country: "",
        image: "",
        currency: "",
      },
      fullscreenLoading: false,
      fillColors: {
        ok: false,
        ctBgColor: "",
        ctTxColor: "",
        pPrColor: "",
        pIcColor: "",
      },
      isColors: null,
      //   Pasarelas de pago
      cod_params: {
        cod_param_1: false,
        cod_param_2: null,
        cod_choose: false,
      },
      epayco_params: {
        epayco_param_1: "",
        epayco_param_2: "",
        epayco_param_3: "",
        epayco_param_4: "",
        epayco_param_5: false,
        epayco_existed: false,
        epayco_test: false,
      },
      paguelofacil_params: {
        paguelofacil_param_1: null, //CCWL
        paguelofacil_param_2: null, //URL RETURN
        paguelofacil_param_3: false, //ENABLED/DISABLED
        paguelofacil_param_4: `Pago en línea - PagueloFacil`, //Descripción
        // parametros extra
        paguelofacil_param_5: this.nombre,
        paguelofacil_param_6: this.ciudad,
        paguelofacil_param_7: this.direccion,
        paguelofacil_param_8: this.celular,
        paguelofacil_param_9: this.email,
        paguelofacil_param_10: this.comentario,
        paguelofacil_param_11: this.notificacion,
        paguelofacil_existed: false,
      },
      yappy_params: {
        loading: false,
        param_1: "", //IDCOMERCIO
        param_2: "", //CLAVE
        param_3: "", //DOMINIO
        param_4: false, //PRODUCCION/PRUEBAS
        param_5: false, //Enabled/Disabled
      },
    };
  },
  mounted() {
    this.getCartTotalItems();
    this.getCartTotalAmount();
    this.getAllSettings();
    this.getColorCount();
    this.getCod();
    this.getEpayco();
    this.getPaguelofacil();
    this.getyappy();
  },
  computed: {
    csrf() {
      return document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    },
    customStyle() {
      //   sb = SHOPPING BAG
      // hm = HOME
      return {
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
  methods: {
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
    },
    getColorSettings: function () {
      axios.get("/colors").then((response) => {
        response.data.forEach((element) => {
          this.fillColors.ctBgColor = element.ctBgColor;
          this.fillColors.ctTxColor = element.ctTxColor;
          this.fillColors.pPrColor = element.pPrColor;
          this.fillColors.pIcColor = element.pIcColor;
        });
      });
    },
    getCartTotalItems: function () {
      this.totalItems = 0;
      axios.get(`/cartCount`).then((response) => {
        if (response.data > 0) {
          this.ok = true;
          this.totalItems = response.data;
        } else {
          this.$router.push("/");
        }
      });
    },
    getCartTotalAmount: function () {
      this.totalAmount = 0;
      axios.get("/cart/amount").then((response) => {
        this.totalAmount = response.data;
      });
    },
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
    validate() {
      let pattern = new RegExp(/^[^a-zA-Z\W][0-9]*\d$/);
      let mailPattern = new RegExp(
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
      );
      this.errors = [];
      let check = true;
      if (this.nombre.length == 0) {
        this.errors.push({ error: "El nombre es un campo requerido." });
        check = false;
      }
      if (this.ciudad.length == 0) {
        this.errors.push({ error: "La ciudad es un campo requerido" });
        check = false;
      }
      if (this.direccion.length == 0) {
        this.errors.push({ error: "La dirección es un campo requerido" });
        check = false;
      }
      if (this.celular.length == 0) {
        this.errors.push({ error: "El celular es un campo requerido" });
        check = false;
      }
      if (!pattern.test(this.celular)) {
        this.errors.push({ error: "El número de celular no es válido" });
        check = false;
      }
      if (this.email.length == 0) {
        this.errors.push({ error: "El correo es un campo requerido" });
        check = false;
      }
      if (!mailPattern.test(this.email)) {
        this.errors.push({
          error: "El formato del correo electrónico no es válido",
        });
        check = false;
      }
      //settear valores para enlace
      if (check) {
        this.settingPagueloFacil();
      }
      return check;
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
          this.paguelofacil_params.paguelofacil_existed = true;
        }
      });
      this.fullscreenLoading = false;
    },
    settingPagueloFacil() {
      this.paguelofacil_params.paguelofacil_param_5 = this.nombre;
      this.paguelofacil_params.paguelofacil_param_6 = this.ciudad;
      this.paguelofacil_params.paguelofacil_param_7 = this.direccion;
      this.paguelofacil_params.paguelofacil_param_8 = this.celular;
      this.paguelofacil_params.paguelofacil_param_9 = this.email;
      this.paguelofacil_params.paguelofacil_param_10 = this.comentario;
      this.paguelofacil_params.paguelofacil_param_11 = this.notificacion;
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
    epaycoform() {
      var handler = ePayco.checkout.configure({
        key: `${this.epayco_params.epayco_param_3}`,
        test: this.epayco_params.epayco_test,
      });

      var data = {
        //Parametros compra (obligatorio)
        name: this.fillSetting.storename,
        description: `Pedido en ${this.fillSetting.storename}`,
        currency: `${this.fillSetting.currency}`,
        amount: this.totalAmount,
        tax_base: "0",
        tax: "0",
        country: "co",
        lang: "es",

        //Onpage="false" - Standard="true"
        external: "false",

        //Atributos opcionales
        extra1: `${this.nombre}`,
        extra2: `${this.ciudad}`,
        extra3: `${this.direccion}`,
        extra4: `${this.celular}`,
        extra5: `${this.email}`,
        extra6: `${this.comentario}`,
        extra7: `${this.notificacion}`,
        response: `${this.ruta}/epayco/apiresponse`,

        //Atributos cliente
        name_billing: `${this.nombre}`,
        email_billing: `${this.email}`,
        address_billing: `${this.direccion}`,
        mobilephone_billing: `${this.celular}`,
      };
      handler.open(data);
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
          this.epayco_params.epayco_test =
            response.data[5].value == 1 ? false : true;
          this.epayco_params.epayco_existed = true;
        }
      });
      this.fullscreenLoading = false;
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
    yappyVerify() {
      this.yappy_params.loading = true;
      const params = {
        param_1: this.yappy_params.param_1,
        param_2: this.yappy_params.param_2,
        param_3: this.yappy_params.param_3,
        param_4: this.yappy_params.param_4,
        param_5: this.yappy_params.param_5,
        sumary: {
          total_price: this.totalAmount,
          total_price_without_tax: this.totalAmount,
          total_tax: 0,
          total_discounts: 0,
          total_shipping: 0,
          phone: this.celular,
        },
      };
      axios.post(`/admin/yappy/Verify`, params).then((response) => {
        if (response.data.result === true) {
          this.setYappyOrder(response.data.url, response.data.ref);
        } else {
          this.$toastr.error(response.data.result);
        }
        this.yappy_params.loading = false;
      });
    },
    setYappyOrder(url, ref) {
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
        referencia: ref,
        fecha: new Date(),
        respuesta: "PENDIENTE POR PAGAR",
        motivo: "Realizado con YAPPY",
        banco: "Banco General",
        recibo: null,
        total: this.totalAmount,
        moneda: "USD",
        //Datos adicionales de transaccion
        type_payment: "YAPPY",
        cod_transaction_state: 1,
        errorcode: "00",
        cust_id_cliente: null,
        id_factura: null,
        franchise: null,
        cardnumber: null,
        customer_ip: null,
        medio: "yappy",
      };
      axios.post("/orders", params).then((response) => {
        if (response.status == 200) {
          window.location = url;
        } else {
          this.fullscreenLoading = false;
        }
      });
    },
    trimCelphone() {
      let pattern = new RegExp(/^[^a-zA-Z\W][0-9]*\d$/);
      if (!pattern.test(this.celular)) {
        this.$toastr.error(
          "Verifique que el número de celular no contenga signos ni espacios al final."
        );
      }
    },
    trimEmail() {
      let mailPattern = new RegExp(
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
      );
      if (!mailPattern.test(this.email)) {
        this.$toastr.error(
          "Verifique que el correo esté bien escrito y no contenga espacios al final."
        );
      }
    },

    setCod() {
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
        referencia: null,
        fecha: new Date(),
        respuesta: "Pago Contra Entrega",
        motivo: "Realizado con Pago Contra Entrega",
        banco: null,
        recibo: null,
        total: this.totalAmount,
        moneda: this.fillSetting.currency,
        //Datos adicionales de transaccion
        type_payment: this.cod_params.cod_choose ? "Datafono" : "Efectivo",
        cod_transaction_state: 1,
        errorcode: "00",
        cust_id_cliente: null,
        id_factura: null,
        franchise: null,
        cardnumber: null,
        customer_ip: null,
        medio: "cod",
      };
      axios.post("/orders", params).then((response) => {
        if (response.status == 200) {
          let token = response.data.serialize;
          const mailparams = {
            pedido: response.data.pedido,
            enlace: response.data.link,
          };
          //establecer parametros de envío de MAIL
          axios.post("/sendingmail/nuevo", mailparams).then((response) => {
            this.$router.push({
              name: "cod.response",
              params: { cod_ref: token },
            });
            this.fullscreenLoading = false;
          });
        } else {
          this.fullscreenLoading = false;
        }
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.yappy-button {
  &:hover {
    cursor: pointer;
  }
}
</style>

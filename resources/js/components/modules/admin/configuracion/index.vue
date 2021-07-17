<template>
  <section class="container col-12 mt-3">
    <div class="col-12 border rounded pt-2 bg-white pb-5">
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="Ajustes Básicos" name="first">
          <h2 class="m-0 admin-title">Información de la tienda</h2>
          <hr class="mt-0" />
          <!-- Form -->
          <section
            class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
          >
            <div class="col-12 col-md-4 text-center">
              <img
                :src="`/img/settings/${fillSetting.image}`"
                alt
                class="img-fluid"
                v-if="fillSetting.image"
              />
              <hr />
              <img
                :src="`/img/settings/${fillSetting.favicon}`"
                alt
                width="50px"
                class="img-fluid"
                v-if="fillSetting.favicon"
              />
            </div>
            <div class="col-12 col-md-8 px-0 px-sm-2">
              <!-- this.mobile -->
              <!-- this.image -->
              <!-- this.currency -->
              <table class="table table-sm">
                <tbody>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle border-top-0"
                      style="width: 1%"
                    >
                      Nombre:
                    </th>
                    <td class="border-top-0">
                      <input
                        type="text"
                        class="form-control form-control-sm border-0"
                        placeholder="Nombre de la Tienda"
                        v-model="fillSetting.storename"
                        @focus="$event.target.select()"
                      />
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      País:
                    </th>
                    <td class>
                      <el-select
                        v-if="countries.length"
                        v-model="fillSetting.country"
                        filterable
                        clearable
                        placeholder="País"
                      >
                        <el-option
                          v-for="(country, index) in countries"
                          :key="index"
                          :label="country.name"
                          :value="country.name"
                        >
                        </el-option>
                      </el-select>
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      Ciudad:
                    </th>
                    <td class>
                      <input
                        type="text"
                        class="form-control form-control-sm border-0"
                        placeholder="Ciudad de Ubicación"
                        v-model="fillSetting.city"
                        @focus="$event.target.select()"
                      />
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      Dirección:
                    </th>
                    <td class>
                      <input
                        type="text"
                        class="form-control form-control-sm border-0"
                        placeholder="Escriba su dirección"
                        v-model="fillSetting.location"
                        @focus="$event.target.select()"
                      />
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      Email:
                    </th>
                    <td class>
                      <input
                        type="email"
                        class="form-control form-control-sm border-0"
                        placeholder="administracion@example.com"
                        v-model="fillSetting.email"
                        @focus="$event.target.select()"
                      />
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      Teléfono:
                    </th>
                    <td class>
                      <div class="d-flex">
                        <el-select
                          v-model="codeSelected"
                          slot="prepend"
                          placeholder="iso"
                          size="medium"
                          filterable
                          @change="setPhoneNumber"
                        >
                          <el-option
                            v-for="(code, index) in phoneCode"
                            :key="index"
                            :label="code.label"
                            :value="`+${code.value}`"
                            @change="codeSelected = code.value"
                          >
                          </el-option>
                        </el-select>
                        <input
                          :disabled="!codeSelected ? true : false"
                          type="text"
                          class="form-control"
                          v-model="phone"
                          @keypress="onlyNumber($event)"
                          @focus="$event.target.select()"
                        />
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      Moneda:
                    </th>
                    <td class>
                      <el-select
                        v-if="currenciesAllowed.length"
                        v-model="fillSetting.currency"
                        filterable
                        placeholder="Select"
                      >
                        <el-option
                          v-for="(currency, index) in currenciesAllowed"
                          :key="index"
                          :label="
                            currency.country +
                            ' ' +
                            currency.code +
                            ' ' +
                            currency.symbol
                          "
                          :value="currency.code"
                        >
                        </el-option>
                      </el-select>
                      <div v-else class="alert alert-danger">
                        <p>
                          Por favor habilitar al menos un tipo de moneda en la
                          pestaña de monedas.
                        </p>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th
                      class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle"
                      style="width: 1%"
                    >
                      FB Business:
                    </th>
                    <td class="align-bottom text-nowrap overflow-hidden">
                      <button
                        class="btn btn-sm btn-outline-dark mr-1"
                        v-clipboard:copy="message"
                        v-clipboard:success="onCopy"
                      >
                        <span class="fas fa-copy"></span>
                      </button>
                      <label
                        for=""
                        class="form-label text-muted m-0"
                        style="max-width: 300px"
                        >{{
                          ruta
                        }}/files/fb_business/facebook_business_product_csv.csv</label
                      >
                    </td>
                  </tr>

                  <tr class="text-left">
                    <th
                      class="d-none d-sm-table-cell align-bottom align-sm-middle"
                    >
                      Imagen:
                    </th>
                    <td>
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input form-control-sm border-0 border-bottom"
                          name="customFile"
                          id="customFile"
                          accept="image/png, image/jpeg"
                          v-loading.fullscreen.lock="fullscreenLoading"
                          @change="getImageFile"
                        />
                        <label
                          class="custom-file-label text-left border-0 border-bottom"
                          for="customFile"
                          v-text="
                            fillSetting.image.length
                              ? fillSetting.image
                              : 'Logo del Sistema'
                          "
                        ></label>
                      </div>
                    </td>
                  </tr>
                  <tr class="text-left">
                    <th
                      class="d-none d-sm-table-cell align-bottom align-sm-middle"
                    >
                      Favicon:
                    </th>
                    <td>
                      <div class="custom-file">
                        <input
                          type="file"
                          class="custom-file-input form-control-sm border-0 border-bottom"
                          name="customFile"
                          id="customFile"
                          accept=".ico"
                          v-loading.fullscreen.lock="fullscreenLoading"
                          @change="getFaviconFile"
                        />
                        <label
                          class="custom-file-label text-left border-0 border-bottom"
                          for="customFile"
                          v-text="
                            fillSetting.favicon.length
                              ? fillSetting.favicon
                              : 'Favicon de página max 500px/500px'
                          "
                        ></label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-right py-3">
                      <button
                        class="btn btn-sm btn-primary"
                        @click.prevent="setSettings"
                      >
                        <span class="fas fa-check"></span>
                        Actualizar
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <!-- End Form -->
        </el-tab-pane>
        <el-tab-pane label="Ajustes Avanzados" name="second">
          <advanced-pane ruta:ruta> </advanced-pane>
        </el-tab-pane>
        <el-tab-pane label="Colores" name="third">
          <customize ruta:ruta> </customize>
        </el-tab-pane>
        <el-tab-pane label="Imagenes PWA" name="fourth">
          <images-pwa ruta:ruta></images-pwa>
        </el-tab-pane>
        <el-tab-pane label="Pagos" name="fifth">
          <payments :ruta="ruta"></payments>
        </el-tab-pane>
        <el-tab-pane label="Tipo de Moneda" name="sixth">
          <currencies :updateCurrencies="getActivatedCurrencies"></currencies>
        </el-tab-pane>
      </el-tabs>
    </div>
  </section>
</template>

<script>
import AdvancedPane from "./advanced";
import ImagesPwa from "./imagespwa";
import Payments from "./payments";
import Currencies from "./currency";
import Customize from "./customize";
export default {
  props: ["ruta"],
  components: {
    AdvancedPane,
    Customize,
    ImagesPwa,
    Payments,
    Currencies,
  },
  data() {
    return {
      fillSetting: {
        storeid: "",
        storename: "",
        mobile: "",
        email: "",
        city: "",
        country: "",
        location: "",
        image: "",
        favicon: "",
        currency: "",
      },
      form: new FormData(),
      settings: [],
      currencies: [],
      countries: [],
      phoneCode: [],
      phone: null,
      codeSelected: null,
      currenciesAllowed: [],
      fullscreenLoading: false,
      errors: [],
      activeName: "first",
      message: `${this.ruta}/files/fb_business/facebook_business_product_csv.csv`,
    };
  },
  mounted() {
    this.getAllSettings();
    //PASARELAS DE PAGO
    this.getCountries();
    this.getActivatedCurrencies();
  },
  methods: {
    onCopy: function () {
      this.$toastr.info("Copiado en el portapapeles");
    },
    getAllSettings: function () {
      this.fullscreenLoading = true;
      this.settings = [];
      axios
        .get("/admin/settings")
        .then((response) => {
          this.fillSetting.storeid = response.data.id;
          this.fillSetting.storename = response.data.storename;
          this.fillSetting.mobile = response.data.mobile;
          this.fillSetting.location = response.data.location;
          this.fillSetting.image = response.data.image;
          this.fillSetting.currency = response.data.currency;
          this.fillSetting.country = response.data.country;
          this.fillSetting.city = response.data.city;
          this.fillSetting.email = response.data.email;
          this.fillSetting.favicon = response.data.favicon;
          this.codeSelected = response.data.code;
          this.phone = this.fillSetting.mobile.slice(response.data.code.length);
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getCountries() {
      axios.get("/admin/countries").then((response) => {
        this.countries = response.data;
        this.countries.forEach((element) => {
          this.phoneCode.push({
            value: element.phone_code,
            label: "+" + element.phone_code + " " + element.iso,
          });
        });
      });
    },
    // CONSTRUCTORES <<<
    getActivatedCurrencies() {
      this.fillSetting.currency = "";
      this.currenciesAllowed = [];
      axios
        .get("/admin/activatedCurrencies")
        .then((response) => {
          if (response.status == 200) this.currenciesAllowed = response.data;
          this.fullscreenLoading = false;
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },

    setSettings: function () {
      if (this.validate()) {
        this.fullscreenLoading = true;
        const params = {
          storename: this.fillSetting.storename,
          mobile: this.fillSetting.mobile,
          location: this.fillSetting.location,
          image: this.fillSetting.image,
          favicon: this.fillSetting.favicon,
          currency: this.fillSetting.currency,
          country: this.fillSetting.country,
          city: this.fillSetting.city,
          email: this.fillSetting.email,
          code: this.codeSelected,
        };
        axios
          .put(`/admin/settings/${this.fillSetting.storeid}`, params)
          .then((response) => {
            if (response.data) {
              this.fullscreenLoading = false;
              this.$toastr.success("El sistema se ha actualizado");
              this.$router.reload;
            }
          });
      } else {
        this.errors.forEach((element) => {
          this.$toastr.error(element.error, "!Oops", {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: "toast-bottom-left",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "5000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
          });
        });
      }
    },
    getImageFile: function (e) {
      this.fillSetting.image = e.target.files[0];
      this.saveImageFile();
    },
    getFaviconFile: function (e) {
      this.fillSetting.favicon = e.target.files[0];
      this.saveFaviconFile();
    },
    saveImageFile() {
      this.fullscreenLoading = true;
      this.form.append("file", this.fillSetting.image);
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      let url = "/admin/settings/saveFile";
      axios.post(url, this.form, config).then((response) => {
        this.fillSetting.image = response.data;
        this.fullscreenLoading = false;
      });
    },
    saveFaviconFile() {
      this.fullscreenLoading = true;
      this.form.append("file", this.fillSetting.favicon);
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      let url = "/admin/settings/saveFile";
      axios.post(url, this.form, config).then((response) => {
        this.fillSetting.favicon = response.data;
        this.fullscreenLoading = false;
      });
    },
    onlyNumber: function (evt) {
      if (!/\d/.test(evt.key)) {
        return evt.preventDefault();
      }
    },
    setPhoneNumber() {
      this.fillSetting.mobile = this.codeSelected + this.phone;
    },
    validate() {
      this.setPhoneNumber();
      let pattern = new RegExp(/\+[0-9]*/);
      this.errors = [];
      let check = true;
      if (this.fillSetting.storename.length == 0) {
        this.errors.push({ error: "El nombre de la tienda es requerido." });
        check = false;
      }
      if (this.fillSetting.country.length == 0) {
        this.errors.push({ error: "El país es requerido." });
        check = false;
      }
      if (this.fillSetting.city.length == 0) {
        this.errors.push({ error: "La ciudad es requerida." });
        check = false;
      }
      if (this.fillSetting.location.length == 0) {
        this.errors.push({ error: "La dirección es requerida." });
        check = false;
      }
      if (this.fillSetting.mobile.length == 0) {
        this.errors.push({ error: "El teléfono móvil es requerido." });
        check = false;
      }
      if (this.phone.length < 5) {
        this.errors.push({ error: "El teléfono es demasiado corto." });
        check = false;
      }
      if (!pattern.test(this.fillSetting.mobile)) {
        this.errors.push({ error: "El número de teléfono no es válido." });
        check = false;
      }
      if (this.fillSetting.currency.length == 0) {
        this.errors.push({ error: "La moneda es requerida." });
        check = false;
      }
      if (this.fillSetting.image.length == 0) {
        this.errors.push({ error: "El logo de la tienda es necesario." });
        check = false;
      }
      return check;
    },
    handleClick(tab, event) {},
  },
};
</script>

<style>
.el-input-number {
  width: 100%;
}
.textarea {
  resize: none;
}
.select {
  height: 1.4rem;
}

.el-input .el-input--suffix {
  width: 100px;
}
</style>

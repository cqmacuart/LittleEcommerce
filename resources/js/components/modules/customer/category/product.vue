<template>
  <div :style="customStyle" v-loading.fullscreen.lock="fullscreenLoading">
    <section class="container-md p-0 p-sm-3 col-12 d-flex flex-wrap mt-5">
      <div
        class="col-12 mb-4 mb-sm-1 d-flex flex-wrap"
        v-for="(item, index) in product"
        :key="index"
      >
        <section class="col-12 col-sm-6 p-0 m-0 text-center">
          <img
            :src="`/img/products/${item.image}`"
            alt
            class="img-fluid"
            v-if="item.image"
          />
        </section>
        <section class="col-12 col-sm-6 p-0 m-0 text-center p-3 rounded border">
          <h2
            class="text-muted m-0 text-left font-weight-bolder custom-category-style"
            v-text="item.nombre"
          ></h2>
          <small>
            <p v-text="item.short_des" class="text-muted m-0 text-left"></p>
          </small>
          <hr />
          <p v-text="item.long_des" class="text-justify"></p>
          <div v-if="!shopSettings.catalogueMode">
            <hr />
            <p v-if="item.quote" class="text-danger text-center">
              **
              <b
                >NOTA: Por favor, antes de ordenar este art&iacute;culo/servicio
                asegúrese de consultar todo lo que necesite saber</b
              >
              **
            </p>
            <h5
              class="font-weight-bolder text-primary text-left custom-price-style"
            >
              {{ currency }} {{ item.price | numeral("0,0.00") }}
            </h5>
            <a class="link p-2 remove-to-cart" @click.prevent="substo(item.id)">
              <el-button
                icon="el-icon-minus"
                circle
                :class="'shadow-sm'"
              ></el-button>
            </a>
            <input
              type="number"
              class="quantity border-0 text-center text-muted"
              min="0"
              :value="item.qty"
              readonly
            />
            <a class="link p-2 add-to-cart" @click.prevent="addto(item.id)">
              <el-button
                icon="el-icon-plus"
                circle
                :class="'shadow-sm'"
              ></el-button>
              <!-- <span class="fas fa-plus text-muted"></span> -->
            </a>
          </div>
          <hr />

          <router-link
            v-if="!shopSettings.catalogueMode"
            :to="{ name: 'cart' }"
            class="btn btn-primary btn-lg col-8 shadow-lg go-to-cart rounded-pill"
          >
            <span class="fas fa-shopping-bag"></span>
            Ir al carrito
          </router-link>
          <a
            href=""
            @click.prevent="askforit"
            class="btn btn-success btn-lg col-8 shadow-lg go-to-cart rounded-pill mt-4"
          >
            <span class="fab fa-whatsapp"></span>
            Preguntar.
          </a>
        </section>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  props: ["ruta", "id", "currency"],
  data() {
    return {
      fillSetting: {
        storename: "",
        mobile: "",
        city: "",
        country: "",
        image: "",
        currency: "",
      },
      shoppingCart: [],
      currentCat: [],
      productList: [],
      categoryName: "",
      categoryImage: "",
      categoryId: 1,
      cartCount: 0,
      //
      product: [],
      productName: "",
      productShort: "",
      productImage: "",
      //
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
      fullscreenLoading: false,
      isColors: null,
      sharelink: null,
      shopSettings: {
        catalogueMode: false,
      },
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
    this.checkingCartCount();
    this.getCurrenProduct();
    this.getAllSettings();
    this.getAdvanced();
  },
  methods: {
    askforit() {
      window.open(
        `https://wa.me/${this.fillSetting.mobile}?text= Hola, Me gustaría saber más sobre este artículo/servicio: ${this.sharelink}`,
        `_blank`
      );
    },
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
    getAdvanced() {
      axios.get(`/admin/settings/getadvancedsettings`).then((response) => {
        if (response.status == 200) {
          this.shopSettings.catalogueMode =
            response.data[0].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
    },
    getCurrenProduct() {
      axios.get(`/products/${this.id}/edit`).then((response) => {
        fetch(`/cart/isincart/${response.data.id}`)
          .then((data) => data.json())
          .then((data) => {
            this.productName = response.data.nombre;
            this.productShort = response.data.short_des;
            this.productImage = response.data.image;
            this.product.push({
              id: response.data.id,
              nombre: response.data.nombre,
              short_des: response.data.short_des,
              long_des: response.data.long_des,
              image: response.data.image,
              price: response.data.price,
              qty: data.qty,
              quote: response.data.quotable == 1 ? true : false,
            });
          });
      });
    },
    //   Carts Functions >>>>>
    addto(productId) {
      let me = this;
      axios.get(`/addToCart/${productId}`).then((response) => {
        this.cartCount = response.data.count;
        this.chekingCartProducts(response.data.id, 1);
        const producto = this.product.find(
          (producto) => producto.id == response.data.id
        );
        if (producto) {
          this.product.map(function (x, y) {
            if (producto.value == x.value) {
              me.product[y].flag = true;
              me.product[y].qty = me.product[y].qty + 1;
            }
          });
        }
      });
    },
    substo(productId) {
      let me = this;
      axios.get(`/subsToCart/${productId}`).then((response) => {
        this.cartCount = response.data.count;
        this.chekingCartProducts(response.data.id, response.data.qty);
        const producto = this.product.find(
          (producto) => producto.id == response.data.id
        );
        if (producto) {
          this.product.map(function (x, y) {
            if (producto.value == x.value) {
              me.product[y].flag = response.data.qty == 0 ? false : true;
              me.product[y].qty = response.data.qty;
            }
          });
        }
      });
    },
    chekingCartProducts(id, qty) {
      if (this.shoppingCart.includes(id)) {
        if (qty == 0) {
          this.shoppingCart.splice(this.shoppingCart.indexOf(id), 1);
        }
      } else {
        if (qty > 0) {
          this.shoppingCart.push(parseInt(id));
        }
      }
    },
    checkingCartCount() {
      axios.get(`/cartCount`).then((response) => {
        this.cartCount = response.data;
      });
    },
    //  Carts Functions <<<<<
    getCurrentCategory: function () {
      this.categoryId = this.id ? this.id : 1;
      if (this.id) {
        axios
          .get(`/categories/${this.categoryId}`)
          .then((response) => {
            this.currentCat = response.data;
            this.categoryName = this.currentCat.nombre;
            this.categoryImage = this.currentCat.image;
          })
          .catch((error) => {
            if (error.response.status == 401) {
              this.$toastr.error("Error " + error.response.status);
            }
          });
      } else {
        axios
          .get("/categories")
          .then((response) => {
            this.currentCat = response.data;
            this.categoryName = response.data[0].nombre;
            this.categoryImage = response.data[0].image;
          })
          .catch((error) => {
            if (error.response.status == 401) {
              this.$toastr.error("Error " + error.response.status);
            }
          });
      }
      this.getProducts(this.categoryId);
    },
    getAllSettings: function () {
      this.sharelink = `${this.ruta}/producto/${this.id}`;
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
    },
  },
};
</script>

<style>
.custom-category-style {
  background-color: var(--bg-ct-color) !important;
  color: var(--text-ct-color) !important;
}

.custom-price-style {
  color: var(--text-p-color) !important;
  z-index: 19;
  position: relative;
  font-size: 14pt;
}
</style>

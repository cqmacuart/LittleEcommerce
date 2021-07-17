<template>
  <div v-if="ok" :style="customStyle">
    <!-- <section class="col-12 p-0 m-0 text-center">
      <img :src="`/img/categories/${categoryImage}`" alt class="img-fluid" v-if="categoryImage" />
    </section>-->
    <div class="col-12 pt-2 pb-1 text-center border-bottom">
      <h5 v-if="fillColors.ok" class="font-weight-bolder custom-checkout-style">
        Carrito de Compras
        <span class="fab fa-opencart fa-2x"></span>
      </h5>
      <h5 v-else><i class="el-icon-loading"></i></h5>
      <div class="d-block d-sm-none">
        <table class="table table-bordered m-0 table-sm">
          <tr>
            <th class="text-black py-0" style="width: 1%">
              <small>Artículos</small>
            </th>
            <td class="text-right py-0">
              <small
                ><label class="m-0" for
                  >{{ totalItems }} Artículo(s)</label
                ></small
              >
            </td>
          </tr>
          <tr>
            <th class="text-black py-0"><small>Total</small></th>
            <td class="text-right py-0">
              <small v-if="fillColors.ok">
                <label class="m-0" for
                  >{{ currency }} {{ totalAmount | numeral("0,0.00") }}</label
                >
              </small>
              <h5 v-else><i class="el-icon-loading"></i></h5>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="col-12 m-auto p-0 d-flex flex-col flex-sm-row row">
      <section class="container-md p-0 p-sm-3 col-12 col-sm-6">
        <div
          class="col-12 p-0"
          v-for="(product, index) in shoppingCart"
          :key="index"
        >
          <div
            class="card h-100 col-12 mt-1 mt-sm-0 pr-3 pl-0 pt-md-0 card-product"
          >
            <div class="row no-gutters h-100">
              <div
                class="col-4 d-flex align-items-center justify-content-center"
              >
                <router-link
                  :to="{ name: 'producto', params: { id: product.id } }"
                >
                  <img
                    :src="`/img/products/${product.attributes.image}`"
                    alt
                    class="img-fluid card-image"
                    v-if="product.attributes.image"
                    width="80px"
                  />
                </router-link>
              </div>
              <div class="col-8">
                <div class="card-header bg-transparent relative p-1">
                  <h5
                    v-text="product.name"
                    class="overflow-hidden text-nowrap m-0"
                  ></h5>
                  <a
                    class="remove-item"
                    @click.prevent="removeItem(product.id)"
                  >
                    <span class="badge badge-danger">
                      <i class="fas fa-times"></i>
                    </span>
                  </a>
                </div>
                <div class="card-body">
                  <small>
                    <p
                      class="card-text"
                      v-text="product.attributes.short_des"
                    ></p>
                  </small>
                  <p class="card-text p-0">
                    <small class="text-muted custom-price-style"
                      >{{ product.quantity }} x {{ currency }}
                      {{ product.price | numeral("0,0.00") }}</small
                    >
                  </p>
                </div>
                <div class="card-footer py-1 px-3">
                  <p
                    class="card-text text-primary text-right font-weight-bolder totalize"
                  >
                    {{ currency }}
                    {{ (product.quantity * product.price) | numeral("0,0.00") }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section
        class="container-md p-0 p-sm-3 col-12 col-sm-6 pb-3 clearfix mt-3 mt-sm-0"
      >
        <div class="col-12 p-0 bg-white h-100">
          <table class="table table-bordered m-0">
            <caption class="pl-3 text-muted">
              <small>**El valor del domicilio no se encuentra incluído</small>
            </caption>
            <tr>
              <th class="totalize text-black" style="width: 1%">Artículos</th>
              <td class="text-right">
                <label class="totalize" for>{{ totalItems }} Artículo(s)</label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black">Total</th>
              <td class="text-right">
                <label class="totalize custom-price-style" for
                  >{{ currency }} {{ totalAmount | numeral("0,0.00") }}</label
                >
              </td>
            </tr>
          </table>
          <button
            class="btn btn-success btn-lg float-right mr-4 mb-4"
            @click.prevent="goToCheckout"
          >
            <span class="fas fa-cash-register"></span>
            Confirmar
          </button>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  props: ["currency"],
  data() {
    return {
      shoppingCart: [],
      totalItems: 0,
      totalAmount: 0,
      ok: false,
      fillColors: {
        ok: false,
        ctBgColor: "",
        ctTxColor: "",
        pPrColor: "",
        pIcColor: "",
      },
      isColors: null,
    };
  },
  mounted() {
    this.getCartContent();
    this.getCartTotalItems();
    this.getCartTotalAmount();
    this.getColorCount();
  },
  computed: {
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
    getCartContent: function () {
      this.shoppingCart = [];
      axios.get("/cart/step").then((response) => {
        this.shoppingCart = response.data;
        if (!this.shoppingCart) {
          this.$router.push("/");
        }
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
    removeItem: function (id) {
      axios.get(`/cart/removeItem/${id}`).then((response) => {
        if (response.data) {
          this.$router.push("/");
        } else {
          this.getCartContent();
          this.getCartTotalItems();
          this.getCartTotalAmount();
        }
      });
    },
    goToCheckout: function () {
      this.$router.push("cart/checkout");
    },
  },
};
</script>

<style>
.custom-checkout-style {
  color: var(--text-ct-color) !important;
}
</style>

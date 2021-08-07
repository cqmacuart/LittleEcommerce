<template>
  <div :style="customStyle" id="categoryBox" v-loading.fullscreen.lock="fullscreenLoading">
    <section class="col-12 p-0 m-0 text-center">
      <img :src="`/img/categories/${categoryImage}`" alt class="img-fluid" v-if="categoryImage" />
      <div v-else class="p-3">
        <span class="fas fa-5x fa-spin fa-spinner"></span>
      </div>
    </section>
    <div class="col-12 pt-0 pb-1 text-center px-0">
      <h5
        v-if="fillColors.ok"
        class="font-weight-bolder customer-title custom-category-style py-2"
        v-text="categoryName"
      ></h5>
      <h5 v-else>
        <i class="el-icon-loading"></i>
      </h5>
    </div>
    <section class="container-md p-0 p-sm-3 col-12 d-flex flex-wrap">
      <div
        class="col-12 col-sm-6 mb-4 mb-sm-1"
        v-for="(product, index) in resultadosPaginados"
        :key="index"
      >
        <div class="card h-100 mb-3 col-12 product-card pt-3 pt-md-0 relative">
          <!-- share icons on each product -->
          <div class="card-icons d-sm-flex flex-column">
            <div class="col-12 p-2 p-lg-3">
              <a
                href
                @click.prevent="
                  dialogVisible = true;
                  setShareInfo(product.value);
                "
              >
                <span class="fas fa-share-alt text-black-50 fa-2x"></span>
              </a>
            </div>
            <div v-if="product.flag" class="col-12 p-2 p-lg-3 mt-4 mt-lg-2">
              <span v-if="fillColors.ok" class="fas fa-shopping-bag fa-2x custom-addicon-style"></span>
              <small v-else>
                <i class="el-icon-loading"></i>
              </small>
            </div>
          </div>
          <div class="row no-gutters h-100">
            <div class="col-md-4 d-flex align-items-center text-center overflow-hidden">
              <router-link :to="{ name: 'producto', params: { id: product.value } }">
                <img
                  :src="`/img/products/${product.image}`"
                  alt
                  class="card-image"
                  v-if="product.image"
                />
              </router-link>
            </div>
            <div class="col-md-8">
              <div class="card-header bg-transparent p-0 p-md-3">
                <router-link
                  :to="{ name: 'producto', params: { id: product.value } }"
                  style="text-decoration: none; color: unset"
                >
                  <h5 v-text="product.label" class="overflow-hidden text-nowrap"></h5>
                </router-link>
              </div>
              <div class="card-body p-0 p-md-3">
                <small>
                  <p class="card-text" v-text="product.short"></p>
                </small>
                <p
                  v-if="!shopSettings.catalogueMode && !product.quote"
                  class="card-text p-0 text-right"
                >
                  <small class="text-muted custom-price-style" v-if="fillColors.ok">
                    {{ currency }}
                    {{ product.price | numeral("0,0.00") }}
                  </small>
                  <small v-else>
                    <i class="el-icon-loading"></i>
                  </small>
                </p>
                <p v-else class="card-text p-0 text-center">
                  <a
                    href
                    @click.prevent="askforit(product.value)"
                    class="btn btn-success rounded-pill mt-4"
                    :class="
                      product.quote && !shopSettings.catalogueMode
                        ? ' btn-info'
                        : ''
                    "
                  >
                    <span class="fab fa-whatsapp"></span>
                    <span v-if="product.quote && !shopSettings.catalogueMode">Consultar</span>
                  </a>
                </p>
              </div>
              <div
                class="card-footer bg-transparent text-nowrap"
                v-if="!shopSettings.catalogueMode && !product.quote"
              >
                <a class="link p-2 remove-to-cart" @click.prevent="substo(product.value)">
                  <el-button icon="el-icon-minus" circle :class="'shadow-sm'"></el-button>
                </a>
                <input
                  type="number"
                  class="quantity border-0 text-center text-muted"
                  min="0"
                  :value="product.qty"
                  readonly
                />
                <a class="link p-2 add-to-cart" @click.prevent="addto(product.value)">
                  <el-button icon="el-icon-plus" circle :class="'shadow-sm'"></el-button>
                  <!-- <span class="fas fa-plus text-muted"></span> -->
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="mt-2">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item" v-if="pageNumber > 0">
            <a
              class="page-link"
              href="#"
              tabindex="-1"
              aria-disabled="true"
              @click.prevent="prevPage"
            >Previous</a>
          </li>
          <li
            class="page-item"
            v-for="(page, index) in paginas"
            :key="index"
            :class="page == pageNumber ? ' active' : ''"
          >
            <a class="page-link" href="#" @click.prevent="selectPage(page)">
              {{
              page + 1
              }}
            </a>
          </li>
          <li class="page-item" v-if="pageNumber < pageCount - 1">
            <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
          </li>
        </ul>
      </nav>
    </div>
    <!-- Bolsa esquina derecha -->
    <div class="text-left pr-3" v-if="fillColors.ok">
      <div class="d-inline-block home-button custom-hm-styles">
        <a :href="'/'" class="m-0 p-0">
          <span class="fas fa-home text-white fa-2x"></span>
        </a>
      </div>
    </div>
    <div class="text-right pr-3" v-if="fillColors.ok">
      <div class="d-inline-block fa-4x bag-icon-box">
        <router-link :to="{ name: 'cart' }">
          <span class="fa-layers fa-fw custom-sb-styles">
            <span class="fas fa-shopping-bag text-white p-2"></span>
            <span
              class="fa-layers-counter fa-layers-bottom-left bg-primary border"
              v-text="cartCount"
            ></span>
          </span>
        </router-link>
      </div>
    </div>

    <!-- sharing Dialog -->
    <el-dialog
      title="Compartir"
      :visible.sync="dialogVisible"
      width="300px"
      style="z-index: 9999"
      class="p-2"
      :before-close="handleClose"
    >
      <h5 v-text="shareName"></h5>
      <div class="d-flex justify-content-around py-3">
        <ShareNetwork
          class="btn text-white"
          v-for="network in networks"
          :network="network.network"
          :key="network.network"
          :style="{ backgroundColor: network.color }"
          :url="sharing.url"
          :title="sharing.title"
          :description="sharing.description"
          :quote="sharing.quote"
          :hashtags="sharing.hashtags"
          :twitterUser="sharing.twitterUser"
        >
          <i :class="network.icon"></i>
        </ShareNetwork>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="handleClose">Salir</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  props: ["ruta", "id", "currency", "filter"],
  data() {
    return {
      fillSetting: {
        mobile: "",
      },
      shoppingCart: [],
      currentCat: [],
      productList: [],
      categoryName: "",
      categoryImage: "",
      categoryId: 1,
      cartCount: 0,
      dialogVisible: false,
      //   SOCIAL NETWORKS LINKS
      shareName: "",
      sharing: {
        url: "https://news.vuejs.org/issues/180",
        title:
          "Say hi to Vite! A brand new, extremely fast development setup for Vue.",
        description:
          'This week, I’d like to introduce you to "Vite", which means "Fast". It’s a brand new development setup created by Evan You.',
        quote: "The hot reload is so fast it's near instant. - Evan You",
        hashtags: "vuejs,vite,javascript",
        twitterUser: "youyuxi",
      },
      networks: [
        {
          network: "facebook",
          name: "Facebook",
          icon: "fab fah fa-lg fa-facebook-f",
          color: "#1877f2",
        },
        {
          network: "whatsapp",
          name: "Whatsapp",
          icon: "fab fah fa-lg fa-whatsapp",
          color: "#25d366",
        },
        // {
        //   network: "twitter",
        //   name: "Twitter",
        //   icon: "fab fah fa-lg fa-twitter",
        //   color: "#1da1f2",
        // },
      ],
      // META VARIABLES
      metaTitle: "",
      metaImage: "",
      metaDescription: "",
      metaRuta: "",
      metaProduct: "",
      //   Paginación
      pageNumber: 0,
      perPage: 6,
      //   COLORES
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
      isColors: null,
      fullscreenLoading: true,
      shopSettings: {
        catalogueMode: false,
      },
      sharelink: null,
    };
  },
  watch: {
    id: {
      // the callback will be called immediately after the start of the observation
      immediate: true,
      handler(val, oldVal) {
        this.getCurrentCategory();
      },
    },
  },
  computed: {
    productFilter() {
      return this.productList;
    },
    //   metodos de paginacion
    pageCount() {
      let a = this.productList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.productList.slice(inicio, fin).sort(function (a, b) {
        return a.position - b.position;
      });
    },
    paginas() {
      let a = this.productList.length,
        b = this.perPage;
      let pageCount = Math.ceil(a / b);
      let count = 0,
        pageArray = [];
      while (count < pageCount) {
        pageArray.push(count);
        count++;
      }
      return pageArray;
    },
    // COLORES
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
    this.getAdvanced();
    this.checkingCartCount();
    this.getColorCount();
    this.getAllSettings();
  },
  methods: {
    askforit(id) {
      this.sharelink = `${this.ruta}/producto/${id}`;
      window.open(
        `https://wa.me/${this.fillSetting.mobile}?text= Hola, Me gustaría saber más sobre este artículo/servicio: ${this.sharelink}`,
        `_blank`
      );
    },
    getAllSettings: function () {
      this.sharelink = `${this.ruta}/producto/${this.id}`;
      this.settings = [];
      axios
        .get("/admin/settings")
        .then((response) => {
          this.fillSetting.mobile = response.data.mobile;
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
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
    },
    //   Shared Info
    setShareInfo(id) {
      const producto = this.productList.find(
        (producto) => producto.value == id
      );
      this.metaTitle = producto.label;
      this.metaImage = producto.image;
      this.metaDescription = producto.short;
      this.metaRuta = this.ruta + `/producto/${id}`;
      this.metaProduct = "id";
      this.shareName = producto.label;
      this.sharing = {
        url: this.ruta + "/producto/" + id + "/",
        title: producto.label,
        description: producto.short,
        quote: producto.label + ": " + this.currency + "\n " + producto.price,
        media: this.ruta + "/img/products/" + producto.image,
        // hashtags: "vuejs,vite,javascript",
        // twitterUser: "youyuxi",
      };
    },
    //   Carts Functions >>>>>
    addto(productId) {
      this.fullscreenLoading = true;
      let me = this;
      axios.get(`/addToCart/${productId}`).then((response) => {
        this.cartCount = response.data.count;
        this.chekingCartProducts(response.data.id, 1);
        const producto = this.productList.find(
          (producto) => producto.value == response.data.id
        );
        if (response.status == 200) {
          if (producto) {
            this.productList.map(function (x, y) {
              if (producto.value == x.value) {
                me.productList[y].flag = true;
                me.productList[y].qty = me.productList[y].qty + 1;
              }
            });
          }
        }
        this.fullscreenLoading = false;
      });
    },
    substo(productId) {
      this.fullscreenLoading = true;
      let me = this;
      axios.get(`/subsToCart/${productId}`).then((response) => {
        this.cartCount = response.data.count;
        this.chekingCartProducts(response.data.id, response.data.qty);
        const producto = this.productList.find(
          (producto) => producto.value == response.data.id
        );
        if (producto) {
          this.productList.map(function (x, y) {
            if (producto.value == x.value) {
              me.productList[y].flag = response.data.qty == 0 ? false : true;
              me.productList[y].qty = response.data.qty;
            }
          });
        }
        this.fullscreenLoading = false;
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
    getProducts: function (id) {
      this.productList = [];
      let url = this.filter
        ? `/products/filteredBySearch/${this.filter}`
        : `/products/filteredByCategory/${this.categoryId}`;
      axios
        .get(url)
        .then((response) => {
          response.data.forEach((element) => {
            fetch(`/cart/isincart/${element.id}`)
              .then((data) => data.json())
              .then((data) => {
                this.productList.push({
                  value: element.id,
                  label: element.nombre,
                  short: element.short_des,
                  image: element.image,
                  position: element.position,
                  price: element.price,
                  flag: data.is,
                  qty: data.qty,
                  quote: element.quotable == 1 ? true : false,
                });
              });
          });
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getCurrentCategory: function () {
      this.categoryId = this.id ? this.id : -1;
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
            }
          });
      } else {
        axios
          .get("/categories/page")
          .then((response) => {
            this.currentCat = response.data;
            this.categoryName = response.data[0].nombre;
            this.categoryImage = response.data[0].image;
          })
          .catch((error) => {
            if (error.response.status == 401) {
            }
          });
      }
      this.getProducts(this.categoryId);
      this.fullscreenLoading = false;
    },
    handleClose() {
      this.dialogVisible = false;
      this.metaTitle = "";
    },
    // Metodos de paginación
    nextPage() {
      this.pageNumber++;
    },
    prevPage() {
      this.pageNumber--;
    },
    selectPage(page) {
      this.pageNumber = page;
    },
    incializarPaginacion() {
      this.pageNumber = 0;
    },
    getAdvanced() {
      axios.get(`/admin/settings/getadvancedsettings`).then((response) => {
        if (response.status == 200) {
          console.log(response);
          this.shopSettings.catalogueMode =
            response.data[0].value == 1 ? true : false;
        }
      });
      this.fullscreenLoading = false;
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
  z-index: 19;
  position: relative;
  font-size: 14pt;
}
.custom-addicon-style {
  color: var(--icon-p-color) !important;
}
</style>

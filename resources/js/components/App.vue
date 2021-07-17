<template>
  <main
    class="container shadow p-0 bg-white"
    v-loading.fullscreen.lock="fullscreenLoading"
  >
    <!-- Header -->
    <Header
      :ruta="ruta"
      :city="fillSetting.city"
      :country="fillSetting.country"
      :image="fillSetting.image"
      :storename="fillSetting.storename"
      :mobile="fillSetting.mobile"
    ></Header>
    <!-- Navbar -->
    <Navbar :ruta="ruta"></Navbar>
    <!-- Contenido -->
    <div class="content-wrapper app-content-box">
      <transition name="slide-fade" mode="out-in">
        <router-view
          :ruta="ruta"
          :currency="fillSetting.currency"
        ></router-view>
      </transition>
    </div>
    <!-- Footer -->
    <Footer :ruta="ruta"></Footer>
  </main>
</template>

<script>
import Header from "./layouts/Header";
import Navbar from "./layouts/Navbar";
import Footer from "./layouts/Footer";
export default {
  props: ["ruta"],
  components: {
    Header,
    Navbar,
    Footer,
  },
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
      fullscreenLoading: true,
    };
  },
  mounted() {
    let obj = { valor: Date.now() };
    if (!sessionStorage.getItem("currCustomer")) {
      sessionStorage.setItem("currCustomer", obj);
    }
    this.getAllSettings();
    window.addEventListener("load", function (event) {
      this.fullscreenLoading = false;
    });
    setTimeout(() => {
      this.fullscreenLoading = false;
    }, 3000);
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
  },
};
</script>

<style>
main {
  max-width: 960px !important;
}
.app-content-box {
  padding-bottom: 250px;
}
</style>



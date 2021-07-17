<template>
  <main class="container shadow p-0">
    <!-- Header -->
    <!-- As a link -->
    <div class="bg-primary col-12 p-0">
      <label for></label>
    </div>
    <nav class="navbar navbar-light bg-light shadow-sm">
      <div>
        <img
          :src="`/img/settings/${fillSetting.image}`"
          width="50px"
          alt="LOGO"
          v-if="fillSetting.image"
        />
        <a class="navbar-brand" href="/admin/login">{{
          fillSetting.storename
        }}</a>
      </div>
    </nav>
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
import Footer from "./layouts/Footer";
export default {
  props: ["ruta"],
  components: {
    Header,
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
    };
  },
  mounted() {
    let obj = { valor: Date.now() };
    if (!sessionStorage.getItem("currCustomer")) {
      sessionStorage.setItem("currCustomer", obj);
    }
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

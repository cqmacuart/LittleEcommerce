<template>
  <div>
    <div
      class="bg-light col-12 d-flex justify-content-between px-2 py-1 px-0 border-bottom"
    >
      <a class="mr-5" href="/">
        <span class="fas fa-eye"></span>
        Ver Sitio
      </a>
      <a
        href
        class="btn-sm btn-warning"
        @click.prevent="logout"
        v-loading.fullscreen.lock="fullscreenLoading"
      >
        <span class="fas fa-sign-out-alt"></span>
        Salir
      </a>
      <!-- <button class="btn-sm btn-warning"></button> -->
    </div>
    <nav class="navbar bg-white p-0">
      <div class="d-inline p-2">
        <router-link :to="'/admin/home'">
          <img
            :src="`/img/settings/${fillSetting.image}`"
            width="90px"
            alt="LOGO"
            class="img-fluid"
            v-if="fillSetting.image"
          />
        </router-link>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      toogleSearch: false,
      fillSetting: {
        storeid: "",
        storename: "",
        mobile: "",
        city: "",
        country: "",
        location: "",
        image: "",
        currency: "",
      },
      fullscreenLoading: false,
    };
  },
  mounted() {
    this.getAllSettings();
  },
  methods: {
    toogleSearchBar: function () {
      this.toogleSearch = !this.toogleSearch;
    },
    getAllSettings: function () {
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
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    logout() {
      this.fullscreenLoading = true;
      let url = `/authenticate/logout`;
      axios.post(url).then((response) => {
        if (sessionStorage.getItem("userAdmin")) {
          sessionStorage.removeItem("userAdmin");
        }
        window.location.href = "/admin/login";
        // this.fullscreenLoading = false;
      });
    },
  },
};
</script>

<style>
</style>

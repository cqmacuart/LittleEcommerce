<template>
  <div>
    <h2 class="m-0 admin-title">Listado de Monedas segun Pa&iacute;ses</h2>
    <hr class="mt-0" />
    <!-- Form -->
    <section
      class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
    >
      <div class="col-10 m-auto px-0 px-sm-2 table-responsive">
        <table class="table table-bordered table-hover table-sm">
          <thead>
            <tr>
              <th>Pa&iacute;s</th>
              <th class="text-center text-nowrap">Moneda</th>
              <th class="text-center text-nowrap" style="width: 1%">ISO</th>
              <th class="text-center text-nowrap" style="width: 10%">
                S&iacute;mbolo
              </th>
              <th class="text-center text-nowrap" style="width: 10%"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(currency, index) in currencies" :key="index">
              <th>{{ currency.country }}</th>
              <th class="text-center">{{ currency.currency }}</th>
              <th class="text-center">{{ currency.code }}</th>
              <th class="text-center">{{ currency.symbol }}</th>
              <th class="text-center">
                <el-checkbox
                  v-loading.fullscreen.lock="fullscreenLoading"
                  :checked="currency.estado_id == 1 ? true : false"
                  @change="currencyIO(currency.id)"
                ></el-checkbox>
              </th>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
export default {
  name: "currency",
  props: ["updateCurrencies"],
  data() {
    return {
      fullscreenLoading: false,
      currencies: [],
    };
  },
  mounted() {
    this.getCurrencies();
  },
  methods: {
    getCurrencies() {
      axios
        .get("/admin/currencies")
        .then((response) => {
          this.currencies = response.data;
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    currencyIO(id) {
      this.fullscreenLoading = true;
      axios
        .put(`/admin/currencies/${id}`)
        .then((response) => {
          this.updateCurrencies();
          this.fullscreenLoading = false;
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
</style>

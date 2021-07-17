<template>
  <section class="container col-12 mt-3 pb-5">
    <div class="col-12 text-center pb-2">
      <el-input
        placeholder="Buscar por Referencia"
        v-model="transacSearch"
        :class="'buscarpedido'"
      ></el-input>
      <el-button
        type="primary"
        icon="el-icon-search"
        size="mini"
        round
        @click="getAllTransactions"
        >Buscar / Reiniciar</el-button
      >
    </div>
    <template v-if="transacList.length">
      <div class="accordion" id="accordionExample">
        <div
          class="card"
          v-for="(transaction, index) in resultadosPaginados"
          :key="index"
        >
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button
                class="btn btn-link btn-block text-left"
                type="button"
                data-toggle="collapse"
                :data-target="`#tr${transaction.id_transaccion}`"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
                Transacci&oacute;n :{{ transaction.id_transaccion }} |
                <span
                  :class="
                    transaction.error == '00' ? 'text-success' : 'text-danger'
                  "
                  >{{ transaction.respuesta_text }}</span
                >
              </button>
            </h2>
          </div>
          <div
            :id="`tr${transaction.id_transaccion}`"
            class="collapse"
            :class="index == 0 ? 'show' : ''"
            aria-labelledby="headingOne"
            data-parent="#accordionExample"
          >
            <div class="card-body">
              <p class="my-1 text-capitalize">
                <b>Referencia: </b>{{ transaction.id_transaccion }}
              </p>
              <p class="my-1 text-capitalize">
                <b>tipo: </b>{{ transaction.tipo }}
              </p>
              <p class="my-1 text-capitalize">
                <b>Estado: </b>{{ transaction.status }}
              </p>
              <p class="my-1 text-capitalize">
                <b>error: </b>{{ transaction.error }}
              </p>
              <p class="my-1 text-capitalize">
                <b>Respuesta: </b>{{ transaction.respuesta_text }}
              </p>
              <p class="my-1 text-capitalize">
                <b>Cliente: </b>{{ transaction.customer_id }}
              </p>
              <p class="my-1 text-capitalize">
                <b>Nombre: </b>{{ transaction.customer_name }}
              </p>
              <p class="my-1 text-capitalize">
                <b>id cliente: </b>{{ transaction.cliente }}
              </p>
              <p class="my-1 text-capitalize">
                <b>factura: </b>{{ transaction.factura }}
              </p>
              <p class="my-1 text-capitalize">
                <b>Método: </b>{{ transaction.franquicia }}
              </p>
              <p class="my-1 text-capitalize">
                <b>banco: </b>{{ transaction.banco }}
              </p>
              <p class="my-1 text-capitalize">
                <b>tarjeta: </b>{{ transaction.tarjeta }}
              </p>
              <p class="my-1 text-capitalize">
                <b>moneda: </b>{{ transaction.moneda }}
              </p>
              <p class="my-1 text-capitalize">
                <b>monto: </b>{{ transaction.monto | numeral("0,0.00") }}
              </p>
              <p class="my-1 text-capitalize">
                <b>ip: </b>{{ transaction.ip }}
              </p>
              <p class="my-1 text-capitalize">
                <b>fecha_transaccion: </b>{{ transaction.fecha_transaccion }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Paginacion -->
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
                >Previous</a
              >
            </li>
            <li
              class="page-item"
              v-for="(page, index) in paginas"
              :key="index"
              :class="page == pageNumber ? ' active' : ''"
            >
              <a class="page-link" href="#" @click.prevent="selectPage(page)">{{
                page + 1
              }}</a>
            </li>
            <li class="page-item" v-if="pageNumber < pageCount - 1">
              <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </template>
    <template v-else>
      <div class="alert alert-info">
        <p>No se han encontrado registros...</p>
      </div>
    </template>
    <!-- Cambiar estatus de orden -->
  </section>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      transacList: [],
      transacStates: [],
      statusSearch: "",
      transacSearch: "",
      filterSearch: "",
      currentTransacc: "",
      dialogVisible: false,
      //   Paginación
      pageNumber: 0,
      perPage: 6,
      fullscreenLoading: false,
    };
  },
  mounted() {
    this.getAllTransactions();
  },
  computed: {
    //   metodos de paginacion
    pageCount() {
      let a = this.transacList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.transacList.slice(inicio, fin);
    },
    paginas() {
      let a = this.transacList.length,
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
  },
  methods: {
    //   Cargar Categorías Guardadas
    getAllTransactions: function () {
      this.transacList = [];
      this.filterSearch = this.transacSearch
        ? this.transacSearch
        : this.statusSearch;
      let url = this.filterSearch
        ? `/admin/pagos/filtered/${this.filterSearch}`
        : `/admin/pagos`;
      axios
        .get(url)
        .then((response) => {
          this.incializarPaginacion();
          response.data.forEach((element) => {
            this.transacList.push({
              id: element.id,
              id_transaccion: element.id_transaccion,
              tipo: element.tipo,
              status: element.status,
              error: element.error,
              respuesta_text: element.respuesta_text,
              customer_id: element.customer_id,
              customer_name: element.customer_name,
              cliente: element.cliente,
              factura: element.factura,
              franquicia: element.franquicia,
              banco: element.banco,
              tarjeta: element.tarjeta,
              moneda: element.moneda,
              monto: element.monto,
              ip: element.ip,
              fecha_transaccion: element.fecha_transaccion,
            });
          });
          this.transacSearch = "";
          this.statusSearch = "";
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
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
  },
};
</script>

<style>
.el-radio {
  width: 100%;
}
.el-dialog {
  width: 100%;
}
.buscarpedido {
  max-width: 200px;
}
</style>

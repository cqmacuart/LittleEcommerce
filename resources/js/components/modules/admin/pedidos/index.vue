<template>
  <section class="container col-12 mt-3 pb-5">
    <div class="col-12 text-center pb-2">
      <el-select
        :class="'buscarpedido'"
        v-model="statusSearch"
        clearable
        filterable
        placeholder="Ordenar por estatus"
        suffix-icon="el-icon-search"
        @change="getAllOrders"
      >
        <el-option
          v-for="state in orderStates"
          :key="state.value"
          :label="state.label"
          :value="state.value"
        ></el-option>
      </el-select>
      <el-input
        placeholder="Buscar por Orden"
        v-model="orderSearch"
        :class="'buscarpedido'"
      ></el-input>
      <el-button
        type="primary"
        icon="el-icon-search"
        size="mini"
        round
        @click="getAllOrders"
        >Buscar / Reiniciar</el-button
      >
    </div>
    <template v-if="orderList.length">
      <div class="col-12 d-flex flex-wrap">
        <div
          v-for="(order, index) in resultadosPaginados"
          :key="index"
          class="col-12 col-sm-6 col-md-4 mt-2"
        >
          <div class="card h-100">
            <div class="card-header">
              <el-link
                type="primary"
                v-text="order.number"
                class="font-weight-bolder"
              ></el-link>
            </div>
            <div class="card-body">
              <div class="card-title">
                <label
                  v-if="order.status == 1"
                  class="badge badge-danger"
                  v-text="order.estado"
                ></label>
                <label
                  v-if="order.status == 2"
                  class="badge badge-primary"
                  v-text="order.estado"
                ></label>
                <label
                  v-if="order.status == 3"
                  class="badge badge-warning"
                  v-text="order.estado"
                ></label>
                <label
                  v-if="order.status == 4"
                  class="badge badge-success"
                  v-text="order.estado"
                ></label>
                <label
                  v-if="order.status == 5"
                  class="badge badge-default"
                  v-text="order.estado"
                ></label>
                <label
                  v-if="order.status == 6"
                  class="badge badge-danger"
                  v-text="order.estado"
                ></label>
              </div>
              <div>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Nombre:</span>
                  <span v-text="order.dataClient[0].nombre"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Ciudad:</span>
                  <span v-text="order.dataClient[0].ciudad"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Dirección:</span>
                  <span v-text="order.dataClient[0].direccion"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Celular:</span>
                  <span v-text="order.dataClient[0].celular"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Email:</span>
                  <span v-text="order.dataClient[0].email"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Comentario:</span>
                  <span v-text="order.dataClient[0].comentario"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder">Transacción:</span>
                  <span v-text="order.transaccion"></span>
                </p>
                <p class="text-muted m-0">
                  <span class="font-weight-bolder"
                    >¿Acepta que le notifiquen?:</span
                  >
                  <span
                    v-text="order.dataClient[0].notificacion ? 'Si' : 'No'"
                  ></span>
                </p>
              </div>
            </div>
            <div class="card-footer d-flex px-0 justify-content-around">
              <a :href="order.link" target="_blank" class="col-6 text-center">
                <el-button icon="el-icon-view" type="primary" round size="mini"
                  >Ver</el-button
                >
              </a>
              <el-button
                type="danger"
                icon="el-icon-delete"
                size="mini"
                circle
                @click="deleteOrder(order.value)"
              ></el-button>
              <a
                :href="order.link"
                target="_blank"
                class="col-6 text-center"
                @click.prevent="toggleDialog(order.status, order.value)"
              >
                <el-button
                  icon="el-icon-sort"
                  type="warning"
                  round
                  size="mini"
                  :disabled="order.status == 5"
                  >Cambiar</el-button
                >
              </a>
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
    <el-dialog
      title="Estados de Pedido"
      :visible.sync="dialogVisible"
      :class="'col-12 col-sm-6 col-md-4 m-auto'"
    >
      <div>
        <div
          class="form-check"
          v-for="(estado, index) in orderStates"
          :key="index"
        >
          <div class="col-12 py-1">
            <input
              class="form-check-input"
              type="radio"
              name="exampleRadios"
              :id="index"
              :value="estado.value"
              :checked="estado.value == currentStatus"
              @change="currentStatus = estado.value"
            />
            <label
              class="form-check-label badge font-weight-bolder text-left"
              :class="selectClass(estado.value)"
              :for="index"
              v-text="estado.label"
            ></label>
          </div>
          <hr class="my-1" />
        </div>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button
          type="primary"
          @click="(dialogVisible = false), setNewState(currentOrder)"
          v-loading.fullscreen.lock="fullscreenLoading"
          >Confirm</el-button
        >
      </span>
    </el-dialog>
  </section>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      orderList: [],
      orderStates: [],
      statusSearch: "",
      orderSearch: "",
      filterSearch: "",
      currentStatus: "",
      currentOrder: "",
      dialogVisible: false,
      //   Paginación
      pageNumber: 0,
      perPage: 6,
      fullscreenLoading: false,
    };
  },
  mounted() {
    this.getAllOrders();
    this.getOrderStates();
  },
  computed: {
    //   metodos de paginacion
    pageCount() {
      let a = this.orderList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.orderList.slice(inicio, fin);
    },
    paginas() {
      let a = this.orderList.length,
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
    setNewState(id) {
      this.fullscreenLoading = true;
      const params = {
        estado: this.currentStatus,
      };
      axios.put(`/orders/${id}`, params).then((response) => {
        // console.log(response.data);
        if (response.status == 200) {
          //   console.log(response.data);
          location.reload();
        }
        this.fullscreenLoading = false;
      });
    },
    //   Cargar Categorías Guardadas
    getAllOrders: function () {
      this.orderList = [];
      this.filterSearch = this.orderSearch
        ? this.orderSearch
        : this.statusSearch;
      let url = this.filterSearch
        ? `/orders/filtered/${this.filterSearch}`
        : `/orders`;
      axios
        .get(url)
        .then((response) => {
          this.incializarPaginacion();
          response.data.forEach((element) => {
            this.orderList.push({
              value: element.id,
              number: element.pedido,
              link: element.link,
              estado: element.estado,
              transaccion: element.transaccion,
              dataClient: [
                {
                  nombre: element.nombre,
                  ciudad: element.ciudad,
                  direccion: element.direccion,
                  celular: element.celular,
                  email: element.email,
                  comentario: element.comentario,
                  notificacion: element.notificacion,
                },
              ],
              status: element.status,
            });
          });
          this.orderSearch = "";
          this.statusSearch = "";
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getOrderStates: function () {
      this.orderStates = [];
      axios.get(`/orderStates`).then((response) => {
        response.data.forEach((element) => {
          this.orderStates.push({
            value: element.id,
            label: element.descripcion,
          });
        });
      });
    },
    handleClose() {
      this.$confirm("Are you sure to close this dialog?")
        .then((_) => {
          done();
        })
        .catch((_) => {});
    },
    toggleDialog(status, orden) {
      this.currentOrder = orden;
      this.currentStatus = status;
      this.dialogVisible = true;
    },
    selectClass(id) {
      switch (id) {
        case 1:
          return "badge-danger";
          break;
        case 2:
          return "badge-info";
          break;
        case 3:
          return "badge-warning";
          break;
        case 4:
          return "badge-success";
          break;
        case 5:
          return "badge-default";
          break;
        case 6:
          return "badge-danger";
          break;
        default:
          return "badge-default";
          break;
      }
    },
    deleteOrder: function (id) {
      this.$confirm(
        "Esta a punto de eliminar esta orden. ¿Desea continuar?",
        "Mensaje",
        {
          confirmButtonText: "Si",
          cancelButtonText: "No",
          type: "error",
        }
      )
        .then(() => {
          this.fullscreenLoading = true;
          axios.delete(`/orders/${id}`).then((response) => {
            if (response) {
              this.$toastr.success("Orden eliminada");
              this.getAllOrders();
            }
            this.fullscreenLoading = false;
          });
        })
        .catch(() => {
          this.$toastr.success("Eliminación cancelada");
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
  max-width: 150px;
}
</style>

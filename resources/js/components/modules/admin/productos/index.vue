<template>
  <section class="container col-12 mt-3">
    <form
      :action="`${ruta}/admin/productos/${this.productvalue}/${this.categoryvalue}/${this.statusvalue}`"
    >
      <div class="col-12 text-center pb-2">
        <div
          class="col-12 d-flex flex-nowrap flex-column flex-md-row justify-content-around"
        >
          <el-input
            placeholder="Producto por nombre"
            v-model="productvalue"
            @keyup.enter="getAllProducts"
          ></el-input>
          <el-select v-model="categoryvalue" clearable placeholder="Categoría">
            <el-option
              v-for="item in catoptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
              @keyup.enter="getAllProducts"
            ></el-option>
          </el-select>
          <el-select v-model="statusvalue" clearable placeholder="Estado">
            <el-option
              v-for="item in statoptions"
              :key="item.value"
              :label="item.label"
              :value="item.value"
              @keyup.enter="getAllProducts"
            ></el-option>
          </el-select>
        </div>
        <div class="p-1">
          <button class="btn btn-primary btn-sm">
            <span class="fas fa-search"></span>
            Buscar / Reiniciar
          </button>
        </div>
      </div>
    </form>
    <div class="table-responsive pb-5">
      <template v-if="productList.length">
        <table class="categories-table table table-sm table-hover bordered">
          <thead class="table-active">
            <tr>
              <th class="text-center text-nowrap" style="width: 1%">
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Añadir Producto"
                  placement="top-end"
                >
                  <router-link
                    :to="{ name: 'admin.productos.create' }"
                    class="border btn btn-warning shadow-sm border"
                    style="border-radius: 50px"
                  >
                    <span class="fas fa-plus"></span>
                  </router-link>
                </el-tooltip>
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Añadir por Archivo"
                  placement="top-end"
                >
                  <router-link
                    :to="{ name: 'admin.productos.archive' }"
                    class="border btn btn-info shadow-sm border"
                    style="border-radius: 50px"
                  >
                    <span class="fas fa-archive"></span>
                  </router-link>
                </el-tooltip>
              </th>
              <th class="text-center text-nowrap" style="width: 20%">Imagen</th>
              <th>Producto</th>
              <th class="text-center">Categoría</th>
              <th class="text-center">Posición</th>
              <th class="text-center">Precio</th>
              <th class="text-center">Estado</th>
              <th class="text-center">Cotizable</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(prod, index) in resultadosPaginados"
              :key="index"
              class="text-nowrap"
            >
              <td class="text-center align-middle">
                <router-link
                  :to="{
                    name: 'admin.productos.edit',
                    params: { id: prod.value },
                  }"
                >
                  <el-button
                    type="primary"
                    icon="el-icon-edit"
                    size="mini"
                    circle
                  ></el-button>
                </router-link>
                <el-button
                  type="info"
                  icon="el-icon-delete"
                  size="mini"
                  circle
                  @click="deleteProduct(prod.value)"
                ></el-button>
              </td>
              <td class="align-middle">
                <div
                  class="img-fluid text-center"
                  style="max-height: 70px; overflow: hidden"
                >
                  <img
                    :src="`/img/products/${prod.image}`"
                    :alt="prod.label"
                    style="max-width: 120px"
                  />
                </div>
              </td>
              <td class="align-middle text-wrap">
                <!-- <span class="fas fa-eye"></span> -->
                {{ prod.label }}
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                {{ prod.category }}
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                {{ prod.position }}
              </td>
              <td
                class="text-right text-nowrap align-middle"
                style="width: 10%"
              >
                {{ prod.price | numeral("0,0.00") }}
                <b>{{ fillSetting.currency }}</b>
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                <button
                  class="btn btn-sm rounded-pill"
                  :class="prod.status == 1 ? ' btn-success' : 'btn-danger'"
                  v-text="prod.status == 1 ? 'Activo' : 'Inactive'"
                  @click="setOnOff(prod.value, index)"
                ></button>
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                <el-switch
                  v-model="prod.quotable"
                  active-color="#13ce66"
                  inactive-color="#ff5500"
                  :class="'mt-2'"
                  @change="setQuotable(prod.value)"
                >
                </el-switch>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- Pagination -->
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
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="selectPage(page)"
                  >{{ page + 1 }}</a
                >
              </li>
              <li class="page-item" v-if="pageNumber < pageCount - 1">
                <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </template>
      <template v-else>
        <table class="categories-table table table-sm table-hover bordered">
          <thead class="table-active">
            <tr>
              <th class="text-center text-nowrap" style="width: 100%">
                <router-link
                  :to="{ name: 'admin.productos.create' }"
                  class="btn btn-success"
                >
                  <span class="fas fa-plus"></span>
                  Agregar un Producto Nuevo
                </router-link>
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Añadir por Archivo"
                  placement="top-end"
                >
                  <router-link
                    :to="{ name: 'admin.productos.archive' }"
                    class="border btn btn-info shadow-sm border"
                    style="border-radius: 50px"
                  >
                    <span class="fas fa-archive"></span>
                  </router-link>
                </el-tooltip>
              </th>
            </tr>
          </thead>
        </table>
      </template>
    </div>
  </section>
</template>

<script>
export default {
  props: ["ruta", "producto", "estado", "categoria"],
  data() {
    return {
      catoptions: [],
      statoptions: [
        { value: 1, label: "Activo" },
        { value: 2, label: "Inactivo" },
      ],
      fillSetting: {
        currency: "",
      },
      productList: [],
      productvalue: null,
      categoryvalue: null,
      statusvalue: null,
      //   Paginación
      pageNumber: 0,
      perPage: 10,
    };
  },
  mounted() {
    this.getAllProducts();
    this.getAllCategories();
    this.getAllSettings();
  },
  computed: {
    //   metodos de paginacion
    pageCount() {
      let a = this.productList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.productList.slice(inicio, fin);
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
  },
  methods: {
    getAllSettings: function () {
      this.settings = [];
      axios
        .get("/admin/settings")
        .then((response) => {
          this.fillSetting.currency = response.data.currency;
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    //   Cargar Categorías Guardadas
    getAllProducts: function () {
      this.productList = [];
      let url =
        this.producto || this.categoria || this.estado
          ? `/products/filtered/${this.producto}/${this.categoria}/${this.estado}`
          : `/products`;
      axios
        .get(url)
        .then((response) => {
          this.incializarPaginacion();
          response.data.forEach((element) => {
            this.productList.push({
              value: element.id,
              label: element.nombre,
              image: element.image,
              category: element.categoryname,
              position: element.position,
              status: element.estado_id,
              price: element.price,
              quotable: element.quotable == 1 ? true : false,
            });
          });
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
            // this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getAllCategories: function () {
      axios
        .get("/categories")
        .then((response) => {
          response.data.forEach((element) => {
            this.catoptions.push({
              value: element.id,
              label: element.nombre,
            });
          });
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    deleteProduct: function (id) {
      this.$confirm(
        "Esta a punto de eliminar este producto. ¿Desea continuar?",
        "Mensaje",
        {
          confirmButtonText: "Si",
          cancelButtonText: "No",
          type: "warning",
        }
      )
        .then(() => {
          axios.delete(`/products/${id}`).then((response) => {
            if (response) {
              this.$toastr.success("Producto eliminado");
              this.getAllProducts();
            }
          });
        })
        .catch(() => {
          this.$toastr.info("Eliminación cancelada");
        });
    },
    onSubmit() {
      return true;
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
    setQuotable(id) {
      const params = {
        product_id: id,
      };
      axios
        .post(`/products/setQuotable`, params)
        .then((response) => {
          if (response.data) {
            this.$toastr.info("El producto se ha actualizado exitosamente");
          }
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    setOnOff(id, index) {
      const params = {
        product_id: id,
      };
      axios
        .post(`/products/setOnOff`, params)
        .then((response) => {
          let indexPageNumber = this.pageNumber * this.perPage;
          if (response.data === 1) {
            this.$toastr.info("Activo", "OK!");
            this.productList[index + indexPageNumber].status = 1;
          } else if (response.data === 2) {
            this.$toastr.info("Inactivo", "OK!");
            this.productList[index + indexPageNumber].status = 2;
          } else {
            this.$toastr.error("Algo ha Ocurrido.", "Error");
          }
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

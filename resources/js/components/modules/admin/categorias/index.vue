<template>
  <section class="container col-12 mt-3">
    <div class="col-12 text-center pb-2">
      <el-select
        v-model="catSearch"
        clearable
        filterable
        placeholder="Buscar Categoría"
        suffix-icon="el-icon-search"
      >
        <el-option
          v-for="item in catList"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        ></el-option>
      </el-select>
      <el-button
        type="primary"
        icon="el-icon-search"
        size="mini"
        round
        :disabled="catSearch.length == 0"
        @click.prevent="searchCategory(catSearch)"
        >Buscar</el-button
      >
      <el-button
        type="danger"
        icon="el-icon-refresh-left"
        size="mini"
        round
        @click.prevent="getAllCategories"
        >Reset</el-button
      >
    </div>
    <div class="table-responsive pb-5">
      <template v-if="catList.length">
        <table class="categories-table table table-sm table-hover bordered">
          <thead class="table-active">
            <tr>
              <th class="text-center text-nowrap" style="width: 1%">
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Añadir Categoría"
                  placement="top-end"
                >
                  <router-link
                    :to="{ name: 'admin.categorias.create' }"
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
                    :to="{ name: 'admin.categorias.archive' }"
                    class="border btn btn-info shadow-sm border"
                    style="border-radius: 50px"
                  >
                    <span class="fas fa-archive"></span>
                  </router-link>
                </el-tooltip>
              </th>
              <th class="text-center text-nowrap" style="width: 20%">Banner</th>
              <th>Nombre</th>
              <th class="text-center">Posición</th>
              <th class="text-center">Estado</th>
              <th class="text-center">Tipo</th>
              <!-- <th class="text-center"></th> -->
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(cat, index) in resultadosPaginados"
              :key="index"
              class="text-nowrap"
            >
              <td class="text-center align-middle">
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Editar Categoría"
                  placement="top-end"
                >
                  <router-link
                    :to="{
                      name: 'admin.categorias.edit',
                      params: { id: cat.value },
                    }"
                  >
                    <el-button
                      type="primary"
                      icon="el-icon-edit"
                      size="mini"
                      circle
                    ></el-button>
                  </router-link>
                </el-tooltip>
                <el-tooltip
                  class="item"
                  effect="dark"
                  content="Eliminar Categoría"
                  placement="top-end"
                >
                  <el-button
                    type="info"
                    icon="el-icon-delete"
                    size="mini"
                    circle
                    @click="deleteCategory(cat.value)"
                    v-if="cat.value > 1"
                  ></el-button>
                </el-tooltip>
              </td>
              <td class="align-middle">
                <div
                  class="img-fluid text-center"
                  style="max-height: 70px; overflow: hidden"
                >
                  <img
                    :src="`/img/categories/${cat.image}`"
                    :alt="cat.label"
                    style="max-width: 120px"
                  />
                </div>
              </td>
              <td class="align-middle text-wrap">
                <!-- <span class="fas fa-eye"></span> -->
                {{ cat.label }}
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                {{ cat.position }}
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                <button
                  class="btn btn-sm rounded-pill"
                  :class="cat.status == 1 ? ' btn-success' : 'btn-danger'"
                  v-text="cat.status == 1 ? 'Activo' : 'Inactive'"
                  @click="setOnOff(cat.value, index)"
                ></button>
              </td>
              <td
                class="text-center text-nowrap align-middle"
                style="width: 10%"
              >
                <button
                  class="btn btn-sm rounded-pill"
                  :class="cat.type == 1 ? ' btn-primary' : 'btn-secondary'"
                  v-text="cat.type == 1 ? 'Productos' : 'Servicios'"
                ></button>
              </td>
              <!-- <td class="text-center align-middle">
                  <el-button type="info" size="mini" round>
                    <i class="fas fa-sitemap"></i>
                    Subcat
                  </el-button>
                </td>-->
              <td class="text-center align-middle">
                <a :href="`${ruta}/admin/productos/null/${cat.value}/null`">
                  <el-button type="info" size="mini" round>
                    <i class="fab fa-apple"></i>
                    Items
                  </el-button>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
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
      </template>
      <template v-else>
        <table class="categories-table table table-sm table-hover bordered">
          <thead class="table-active">
            <tr>
              <th class="text-center text-nowrap" style="width: 100%">
                <router-link
                  :to="{ name: 'admin.categorias.create' }"
                  class="btn btn-success"
                >
                  <span class="fas fa-plus"></span>
                  Agregar una Categoría Nueva
                </router-link>
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
  props: ["ruta"],
  data() {
    return {
      catList: [],
      catSearch: "",
      //   Paginación
      pageNumber: 0,
      perPage: 8,
    };
  },
  mounted() {
    this.getAllCategories();
  },
  computed: {
    //   metodos de paginacion
    pageCount() {
      let a = this.catList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.catList.slice(inicio, fin);
    },
    paginas() {
      let a = this.catList.length,
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
    searchCategory(id) {
      this.catSearch = "";
      this.catList = [];
      axios
        .get(`/categories/${id}`)
        .then((response) => {
          this.incializarPaginacion();
          this.catList.push({
            value: response.data.id,
            label: response.data.nombre,
            image: response.data.image,
            position: response.data.position,
            status: response.data.estado_id,
            type: response.data.tipo_id,
          });
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getAllCategories: function () {
      this.catSearch = "";
      this.catList = [];
      axios
        .get("/categories")
        .then((response) => {
          response.data.forEach((element) => {
            this.catList.push({
              value: element.id,
              label: element.nombre,
              image: element.image,
              position: element.position,
              status: element.estado_id,
              type: element.tipo_id,
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
    deleteCategory: function (id) {
      this.$confirm(
        "Esta a punto de eliminar esta categoría. ¿Desea continuar?",
        "Mensaje",
        {
          confirmButtonText: "Si",
          cancelButtonText: "No",
          type: "warning",
        }
      )
        .then(() => {
          axios.delete(`/categories/${id}`).then((response) => {
            if (response) {
              this.$toastr.success("Categoría eliminada");
              this.getAllCategories();
            }
          });
        })
        .catch(() => {
          this.$toastr.info("Eliminación cancelada");
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
    setOnOff(id, index) {
      const params = {
        category_id: id,
      };
      axios
        .post(`/categories/setOnOff`, params)
        .then((response) => {
          let indexPageNumber = this.pageNumber * this.perPage;
          if (response.data === 1) {
            this.$toastr.info("Activo", "OK!");
            this.catList[index + indexPageNumber].status = 1;
          } else if (response.data === 2) {
            this.$toastr.info("Inactivo", "OK!");
            this.catList[index + indexPageNumber].status = 2;
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

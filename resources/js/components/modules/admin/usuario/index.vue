<template>
  <section class="container col-12 mt-3">
    <div class="table-responsive pb-5">
      <template v-if="userList.length">
        <table class="table table-sm table-hover bordered">
          <thead class="table-active">
            <tr>
              <th class="text-center text-nowrap"></th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Email</th>
              <th class="text-center">Tipo</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in userList" :key="user.id" class="text-nowrap">
              <td class="text-center align-middle">
                <router-link
                  :to="{
                    name: 'admin.usuarios.edit',
                    params: { id: user.value },
                  }"
                >
                  <el-button
                    type="primary"
                    icon="el-icon-edit"
                    size="mini"
                    circle
                  ></el-button>
                </router-link>
              </td>
              <td class="align-middle text-center">
                {{ user.name }}
              </td>
              <td class="text-center text-nowrap align-middle">
                {{ user.email }}
              </td>
              <td class="text-center text-nowrap align-middle">
                {{ user.role }}
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
    </div>
  </section>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      userList: [],
      //   Paginación
      pageNumber: 0,
      perPage: 8,
    };
  },
  mounted() {
    this.getAllUsers();
  },
  computed: {
    //   metodos de paginacion
    pageCount() {
      let a = this.userList.length,
        b = this.perPage;
      return Math.ceil(a / b);
    },
    resultadosPaginados() {
      let inicio = this.pageNumber * this.perPage,
        fin = inicio + this.perPage;
      return this.userList.slice(inicio, fin);
    },
    paginas() {
      let a = this.userList.length,
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
    getAllUsers: function () {
      this.userList = [];
      axios
        .get("/admin/users")
        .then((response) => {
          response.data.forEach((element) => {
            this.userList.push({
              value: element.id,
              role: element.role,
              name: element.name,
              email: element.email,
            });
          });
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    // deleteCategory: function (id) {
    //   this.$confirm(
    //     "Esta a punto de eliminar esta categoría. ¿Desea continuar?",
    //     "Mensaje",
    //     {
    //       confirmButtonText: "Si",
    //       cancelButtonText: "No",
    //       type: "warning",
    //     }
    //   )
    //     .then(() => {
    //       axios.delete(`/categories/${id}`).then((response) => {
    //         if (response) {
    //           this.$toastr.success("Categoría eliminada");
    //           this.getAllCategories();
    //         }
    //       });
    //     })
    //     .catch(() => {
    //       this.$toastr.info("Eliminación cancelada");
    //     });
    // },
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
</style>

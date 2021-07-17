<template>
  <section class="container col-12 mt-3">
    <div class="col-12 border rounded pt-2 bg-white pb-5">
      <h2 class="m-0 admin-title">Nueva Categoría</h2>
      <hr class="mt-0" />
      <!-- Form -->
      <section
        class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
      >
        <div class="col-12 col-md-4">
          <img
            :src="`/img/categories/${fillCategory.categoryImageName}`"
            alt
            class="img-fluid"
            v-if="fillCategory.categoryImageName"
          />
          <img
            v-else
            src="/img/settings/mobilestore_logo.jpg"
            alt
            class="img-fluid"
          />
        </div>
        <div class="col-12 col-md-8 px-0 px-sm-2">
          <table class="table table-sm">
            <tbody>
              <tr>
                <th
                  class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle border-top-0"
                  style="width: 1%"
                >
                  Nombre:
                </th>
                <td class="border-top-0">
                  <input
                    type="text"
                    class="form-control form-control-sm border-0"
                    placeholder="Nombre de la Categoría"
                    v-model="fillCategory.categoryName"
                    autofocus
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Descripción:
                </th>
                <td>
                  <textarea
                    name="descripcion"
                    id="descripcion"
                    rows="2"
                    class="form-control form-control-sm border-0 textarea"
                    placeholder="Descripción de la Categoría"
                    maxlength="250"
                    v-model="fillCategory.categoryDescription"
                  ></textarea>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Posición:
                </th>
                <td>
                  <label for class="form-label d-sm-none text-muted ml-2"
                    >Posición:</label
                  >
                  <el-input-number
                    v-model="fillCategory.categoryPosition"
                    controls-position="right"
                    :min="1"
                    :max="max"
                    size="mini"
                    :class="'col-12 p0'"
                  ></el-input-number>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Tipo:
                </th>
                <td>
                  <select
                    name="type"
                    id="type"
                    class="custom-select form-control-sm border-0 py-0 pl-1 select text-muted"
                    v-model="fillCategory.categoryType"
                  >
                    <option selected disabled value>
                      <small class="text-muted">Tipo de Categoría</small>
                    </option>
                    <option
                      v-for="(type, index) in typeList"
                      :key="index"
                      :value="type.value"
                    >
                      <small class="text-muted" v-text="type.label"></small>
                    </option>
                  </select>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Estado:
                </th>
                <td>
                  <select
                    name="status"
                    id="status"
                    class="custom-select form-control-sm border-0 py-0 pl-1 select text-muted"
                    v-model="fillCategory.categoryStatus"
                  >
                    <option selected disabled value>
                      <small class="text-muted">Estado de Categoría</small>
                    </option>
                    <option
                      v-for="(state, index) in statusList"
                      :key="index"
                      :value="state.value"
                    >
                      <small class="text-muted" v-text="state.label"></small>
                    </option>
                  </select>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Padre:
                </th>
                <td>
                  <select
                    name="parent"
                    id="parent"
                    class="custom-select form-control-sm border-0 py-0 pl-1 select text-muted"
                    v-model="fillCategory.categoryParent"
                  >
                    <option selected disabled value>
                      <small class="text-muted">Categoría padre</small>
                    </option>
                    <option
                      v-for="(cat, index) in catList"
                      :key="index"
                      :value="cat.value"
                    >
                      <small class="text-muted" v-text="cat.label"></small>
                    </option>
                  </select>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Imagen:
                </th>
                <td>
                  <div class="custom-file">
                    <input
                      type="file"
                      class="custom-file-input form-control-sm border-0 border-bottom"
                      name="customFile"
                      id="customFile"
                      accept="image/gif, image/jpeg, image/png"
                      v-loading.fullscreen.lock="fullscreenLoading"
                      @change="getImageFile"
                    />
                    <label
                      class="custom-file-label text-left border-0 border-bottom"
                      for="customFile"
                      v-text="
                        fillCategory.categoryImageName.length
                          ? fillCategory.categoryImageName
                          : 'Elija una imagen'
                      "
                    ></label>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-right py-3">
                  <router-link
                    :to="{ name: 'admin.categorias' }"
                    class="btn btn-sm btn-outline-secondary"
                  >
                    <span class="fas fa-arrow-left"></span>
                    Atras
                  </router-link>
                  <button
                    class="btn btn-sm btn-primary"
                    @click.prevent="setCategory"
                  >
                    <span class="fas fa-check"></span>
                    Crear
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <!-- End Form -->
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      fillCategory: {
        categoryName: "",
        categoryDescription: "",
        categoryPosition: "",
        categoryType: "",
        categoryStatus: 1,
        categoryParent: 1,
        categoryImageName: "",
      },
      form: new FormData(),
      catList: [],
      typeList: [],
      statusList: [],
      fullscreenLoading: false,
      errors: [],
      max: 0,
    };
  },
  mounted() {
    this.getCategoryTypes();
    this.getCategoryStatus();
    this.getAllCategories();
  },
  methods: {
    //   CONSTRUCTORES >>>
    getCategoryTypes: function () {
      this.typeList = [];
      axios
        .get("/types")
        .then((response) => {
          response.data.forEach((element) => {
            this.typeList.push({
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
    getCategoryStatus: function () {
      this.statusList = [];
      axios
        .get("/status")
        .then((response) => {
          response.data.forEach((element) => {
            this.statusList.push({
              value: element.id,
              label: element.nombre,
            });
          });
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            // this.app.Toastr.error("Caduco su Sesión");
            // localStorage.removeItem("user-authenticate");
            // this.$router.push("/login");
            this.$toastr.error("Error " + error.response.status);
          }
        });
    },
    getAllCategories: function () {
      this.catList = [];
      axios
        .get("/categories")
        .then((response) => {
          this.fillCategory.categoryPosition = response.data.length + 1;
          this.max = response.data.length + 1;
          response.data.forEach((element) => {
            this.catList.push({
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
    // CONSTRUCTORES <<<
    setCategory: function () {
      if (this.validate()) {
        if (this.fillCategory.categoryImage) {
          const params = {
            nombre: this.fillCategory.categoryName,
            descripcion: this.fillCategory.categoryDescription,
            position: this.fillCategory.categoryPosition,
            estado_id: this.fillCategory.categoryStatus,
            tipo_id: this.fillCategory.categoryType,
            parent_id: this.fillCategory.categoryParent,
            image: this.fillCategory.categoryImageName,
          };
          axios.post("/categories", params).then((response) => {
            if (response.data) {
              this.$toastr.success("La categoría se ha creado exitosamente");
              this.$router.push("/admin/categorias");
            }
          });
        }
      } else {
        this.errors.forEach((element) => {
          this.$toastr.error(element.error, "!Oops", {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: "toast-bottom-left",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "5000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
          });
        });
      }
    },
    getImageFile: function (e) {
      this.fillCategory.categoryImage = e.target.files[0];
      this.saveImageFile();
    },
    saveImageFile() {
      this.fullscreenLoading = true;
      this.form.append("file", this.fillCategory.categoryImage);
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      let url = "/categories/saveFile";
      axios.post(url, this.form, config).then((response) => {
        this.fillCategory.categoryImageName = response.data;
        this.fullscreenLoading = false;
      });
    },
    validate() {
      this.errors = [];
      let check = true;
      if (this.fillCategory.categoryName.length == 0) {
        this.errors.push({ error: "El nombre de la categoría es requerido." });
        check = false;
      }
      if (this.fillCategory.categoryPosition == 0) {
        this.errors.push({ error: "La posición de la categoría es requerido" });
        check = false;
      }
      if (this.fillCategory.categoryType.length == 0) {
        this.errors.push({ error: "El tipo de la categoría es requerido" });
        check = false;
      }
      if (this.fillCategory.categoryStatus.length == 0) {
        this.errors.push({ error: "El estado de la categoría es requerido" });
        check = false;
      }
      if (this.fillCategory.categoryImageName.length == 0) {
        this.errors.push({ error: "La imagen de la categoría es requerido" });
        check = false;
      }
      return check;
    },
  },
};
</script>

<style>
.el-input-number {
  width: 100%;
}
.textarea {
  resize: none;
}
.select {
  height: 1.4rem;
}
</style>

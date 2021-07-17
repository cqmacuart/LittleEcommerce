<template>
  <section class="container col-12 mt-3">
    <div class="col-12 border rounded pt-2 bg-white pb-5">
      <h2 class="m-0 admin-title">Modificar Producto</h2>
      <hr class="mt-0" />
      <!-- Form -->
      <section
        class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
      >
        <div class="col-12 col-md-4 text-center position-relative">
          <img
            :src="`/img/products/${fillProducts.productImageName}`"
            alt
            class="img-fluid"
            v-if="fillProducts.productImageName"
          />
          <div
            class="position-absolute delete-icon-box"
            v-if="fillProducts.productImageName != 'nofound.png'"
          >
            <button
              class="btn btn-danger text-white rounded-circle border"
              @click="clearImage"
            >
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
        <div class="col-12 col-md-8 px-0 px-sm-2">
          <table class="table table-sm">
            <tbody>
              <tr>
                <th
                  class="d-none d-sm-table-cell text-nowrap text-left align-bottom align-sm-middle border-top-0"
                  style="width: 1%"
                >
                  <b>(<span class="text-danger">*</span>)</b>
                  Nombre:
                </th>
                <td class="border-top-0">
                  <input
                    type="text"
                    class="form-control form-control-sm border-0"
                    placeholder="Nombre del Producto"
                    autofocus
                    v-model="fillProducts.productName"
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th
                  class="d-none d-sm-table-cell align-bottom align-sm-middle text-nowrap"
                >
                  <b>(<span class="text-danger">*</span>)</b>
                  Descripción Corta:
                </th>
                <td>
                  <input
                    type="text"
                    class="form-control form-control-sm border-0"
                    placeholder="Breve descripción del producto"
                    maxlength="80"
                    autofocus
                    v-model="fillProducts.productShort"
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th
                  class="d-none d-sm-table-cell align-bottom align-sm-middle text-nowrap"
                >
                  Descripción Larga:
                </th>
                <td>
                  <textarea
                    name="long_des"
                    id="long_des"
                    rows="2"
                    class="form-control form-control-sm border-0 textarea"
                    placeholder="Descripción extendida"
                    v-model="fillProducts.productLong"
                  ></textarea>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  <b>(<span class="text-danger">*</span>)</b>
                  Categoría:
                </th>
                <td>
                  <select
                    name="category"
                    id="category"
                    class="custom-select form-control-sm border-0 py-0 pl-1 select text-muted"
                    v-model="fillProducts.productCategory"
                  >
                    <option selected disabled value>
                      <small class="text-muted">Elija una categoría</small>
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
                  Posición:
                </th>
                <td>
                  <label for class="form-label d-sm-none text-muted ml-2"
                    >Posición:</label
                  >
                  <el-input-number
                    v-model="fillProducts.productPosition"
                    controls-position="right"
                    :min="1"
                    :max="max"
                    size="mini"
                    :class="'col-12 p-0'"
                  ></el-input-number>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Precio:
                </th>
                <td>
                  <label for class="form-label d-sm-none text-muted ml-2"
                    >Precio:</label
                  >
                  <vue-numeric
                    class="form-control form-control-sm text-right"
                    :precision="2"
                    separator="."
                    placeholder="0,00"
                    v-model="fillProducts.productPrice"
                    :empty-value="'0,00'"
                  ></vue-numeric>
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Inventario:
                </th>
                <td>
                  <label for class="form-label d-sm-none text-muted ml-2"
                    >Inventario:</label
                  >
                  <el-input-number
                    v-model="fillProducts.productQuantity"
                    :min="0"
                    @blur="
                      fillProducts.productQuantity === undefined
                        ? fillProducts.productQuantity
                        : 0
                    "
                    placeholder="Producto en Inventario"
                    size="mini"
                    :class="'col-12 p-0'"
                  ></el-input-number>
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
                    v-model="fillProducts.productStatus"
                  >
                    <option selected disabled value>
                      <small class="text-muted">Estado</small>
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
                  <b>(<span class="text-danger">*</span>)</b>
                  Imagen:
                </th>
                <td>
                  <div
                    class="custom-file"
                    v-if="fillProducts.productImageName == 'nofound.png'"
                  >
                    <input
                      type="file"
                      class="custom-file-input form-control-sm border-0 border-bottom"
                      id="customFile"
                      v-loading.fullscreen.lock="fullscreenLoading"
                      @change="getImageFile"
                    />
                    <label
                      class="custom-file-label text-left border-0 border-bottom"
                      for="customFile"
                      v-text="fillProducts.productImageName"
                    ></label>
                  </div>
                  <div v-else class="text-center">
                    <button
                      class="btn btn-danger text-white rounded-pill w-25"
                      @click="clearImage"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>

              <tr>
                <td class="d-none d-sm-table-cell"></td>
                <td>
                  <p class="text-danger">
                    **<small>
                      Las dimensiones de la imagen deben ser cuadradas. (ejmp
                      500px x 500px)</small
                    >
                  </p>
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-right py-3">
                  <router-link
                    :to="{ name: 'admin.productos' }"
                    class="btn btn-sm btn-outline-secondary"
                  >
                    <span class="fas fa-arrow-left"></span>
                    Atras
                  </router-link>
                  <button
                    class="btn btn-sm btn-primary"
                    @click.prevent="setProduct"
                  >
                    <span class="fas fa-check"></span>
                    Actualizar
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
  props: ["id"],
  data() {
    return {
      fillProducts: {
        productName: "",
        productShort: "",
        productLong: "",
        productCategory: "",
        productPosition: "",
        productPrice: "",
        productQuantity: "",
        productStatus: "",
        productImageName: "",
      },
      form: new FormData(),
      catList: [],
      statusList: [],
      fullscreenLoading: false,
      errors: [],
      max: 9999999,
    };
  },
  mounted() {
    this.getEditProduct();
    this.getCategoryStatus();
    this.getAllCategories();
    this.getAllProducts();
  },
  methods: {
    //   CONSTRUCTORES >>>
    getAllProducts: function () {
      let url = `/products`;
      axios
        .get(url)
        .then((response) => {
          this.max = response.data.length;
        })
        .catch((error) => {
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
            console.log(error.response.status);
          }
        });
    },
    getAllCategories: function () {
      this.catList = [];
      axios
        .get("/categories")
        .then((response) => {
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
            // this.app.Toastr.error("Caduco su Sesión");
            // localStorage.removeItem("user-authenticate");
            // this.$router.push("/login");
            console.log(error.response.status);
          }
        });
    },
    // CONSTRUCTORES <<<
    setProduct: function () {
      if (this.validate()) {
        const params = {
          nombre: this.fillProducts.productName,
          short_des: this.fillProducts.productShort,
          long_des: this.fillProducts.productLong,
          estado_id: this.fillProducts.productStatus,
          category_id: this.fillProducts.productCategory,
          position: this.fillProducts.productPosition,
          quantity: this.fillProducts.productQuantity,
          price: this.fillProducts.productPrice,
          image: this.fillProducts.productImageName,
        };
        axios.put(`/products/${this.id}`, params).then((response) => {
          if (response.data) {
            this.$toastr.info("El producto se ha actualizado exitosamente");
            this.$router.push("/admin/productos");
          }
        });
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
      this.fillProducts.productImage = e.target.files[0];
      this.saveImageFile();
    },
    saveImageFile() {
      this.fullscreenLoading = true;
      this.form.append("file", this.fillProducts.productImage);
      const config = { headers: { "Content-Type": "multipart/form-data" } };
      let url = "/products/saveFile";
      axios.post(url, this.form, config).then((response) => {
        this.fillProducts.productImageName = response.data;
        this.fullscreenLoading = false;
      });
    },
    getEditProduct: function () {
      let productId = this.id;
      let url = "/products/" + productId + "/edit";
      axios
        .get(url, {
          params: {
            id: this.id,
          },
        })
        .then((response) => {
          this.fillProducts.productName = response.data.nombre;
          this.fillProducts.productShort = response.data.short_des;
          this.fillProducts.productLong = response.data.long_des;
          this.fillProducts.productCategory = response.data.category_id;
          this.fillProducts.productPosition = response.data.position;
          this.fillProducts.productQuantity = response.data.quantity;
          this.fillProducts.productPrice = response.data.price.replace(
            ".",
            ","
          );
          this.fillProducts.productStatus = response.data.estado_id;
          this.fillProducts.productImageName = response.data.image;
        });
    },
    validate() {
      this.errors = [];
      let check = true;
      if (this.fillProducts.productName.length == 0) {
        this.errors.push({ error: "El nombre del producto es requerido." });
        check = false;
      }
      if (this.fillProducts.productShort.length == 0) {
        this.errors.push({ error: "La Descripción del producto es requerido" });
        check = false;
      }
      if (this.fillProducts.productImageName.length == 0) {
        this.errors.push({ error: "La imagen del producto es requerida" });
        check = false;
      }
      return check;
    },
    clearImage() {
      this.fullscreenLoading = true;
      const params = {
        image: this.fillProducts.productImageName,
      };
      axios
        .put(`/products/clearimage/${this.id}`, params)
        .then((response) => {
          if (response.data) {
            this.$toastr.success("El imagen borrada exitosamente");
            setTimeout(() => {
              this.$router.go();
            }, 1200);
          } else {
            this.$toastr.error("La imagen no ha sido borrada");
            setTimeout(() => {
              this.$router.go();
            }, 1200);
          }
          this.fullscreenLoading = false;
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$toastr.error("Error en la actualización del producto");
            setTimeout(() => {
              this.$router.go();
            }, 1200);
            this.fullscreenLoading = false;
          }
        });
    },
  },
};
</script>

<style>
.textarea {
  resize: none;
}
.select {
  height: 1.4rem;
}

.delete-icon-box {
  top: 0;
  right: 0;
}
</style>

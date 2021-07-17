<template>
  <section class="container col-12 mt-3">
    <div class="col-12 border rounded pt-2 bg-white pb-5">
      <h2 class="m-0 admin-title">Lote de Productos</h2>
      <hr class="mt-0" />
      <!-- Form -->
      <section
        class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
      >
        <div class="col-12">
          <p class="text-justify m-0">
            <code
              >Para cargar un lote de productos deber&aacute; cargar un archivo
              en formato <b>xlsx.</b></code
            >
          </p>
          <p class="text-justify m-0">
            <code>Las Categorías deberán estar previamente creadas </code>
          </p>
          <p class="text-justify m-0">
            <code
              >Este archivo deber&aacute; cumplir con las siguientes
              condiciones.</code
            >
          </p>
          <ul>
            <li>
              <small>
                Un archivo con una fila de cabeceras en minúsculas (sin
                caracteres especiales)
              </small>
            </li>
            <li>
              Las siguientes columnas en el orden mostrado:
              <ol>
                <li><small>nombre: puede ser alfanumérico</small></li>
                <li>
                  <small
                    >descripcion (alfanumérico no mayor a 255 caracteres)</small
                  >
                </li>
                <li><small>descripcion2 (Descripcion Larga)</small></li>
                <li>
                  <small
                    >estado: debe ser numérico (1 activo, 2 inactivo)</small
                  >
                </li>
                <li>
                  <small
                    >categor&iacute;a: el nombre debe ser exacto a la categoría
                    creada</small
                  >
                </li>
                <li><small>cantidad: (0 por defecto)</small></li>
                <li>
                  <small
                    >precio: Sin separadores de mil y decimales separados por
                    punto</small
                  >
                </li>
              </ol>
            </li>
            <li>
              Para mayor facilidad y menos molestias utilice descargue
              <a href="#" target="_blank" @click.prevent="downloadFile"
                >Aqu&iacute;</a
              >
              un archivo de ejemplo para llenarlo.
            </li>
          </ul>
        </div>
        <div class="col-12 px-0 px-sm-2">
          <table class="table table-sm">
            <tbody>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Archivo:
                </th>
                <td>
                  <div class="">
                    <div class="fileform">
                      <label class="filebutton" style="margin: 0"
                        ><i class="fas fa-download"></i>
                        <input
                          class="fileinput"
                          ref="fileupload"
                          type="file"
                          @change.prevent="fileselected"
                          v-loading.fullscreen.lock="fullscreenLoading"
                          accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        />
                      </label>
                    </div>
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
                    @click.prevent="pushFile"
                    :disabled="save ? false : true"
                    v-loading.fullscreen.lock="fullscreenLoading"
                  >
                    <span class="fas fa-check"></span>
                    Crear por Archivo
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm">
            <thead>
              <tr>
                <th class="text-nowrap" style="width: 1%">Nombre</th>
                <th class="text-wrap" style="width: 10%">Descripción</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Categor&iacute;a</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Precio</th>
              </tr>
            </thead>
            <tbody>
              <tr class="" v-for="(item, index) in record" :key="index">
                <td>{{ item.nombre.slice(0, 30) + "..." }}</td>
                <td>{{ item.descripcion.slice(0, 30) + "..." }}</td>
                <td class="text-center">{{ item.estado }}</td>
                <td class="text-center">{{ item.categoria }}</td>
                <td class="text-center">{{ item.cantidad }}</td>
                <td class="text-center">{{ item.precio }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
      <!-- End Form -->
    </div>
    <el-dialog
      title="Aviso"
      :visible.sync="dialogVisible"
      width="40%"
      :before-close="handleClose"
    >
      <p>
        Tenga en cuenta que los productos con nombre repetido no se generarán,
        al igual que los productos cuyas categor&iacute;as no existan.
      </p>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="dialogVisible = false"
          >Confirm</el-button
        >
      </span>
    </el-dialog>
  </section>
</template>

<script>
import XLSX from "xlsx";
export default {
  props: ["ruta"],
  data() {
    return {
      fillCategory: {
        categoryImageName: "",
      },
      form: new FormData(),
      fullscreenLoading: false,
      errors: [],
      save: false,
      record: [],
      dialogVisible: false,
    };
  },
  mounted() {},
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
    fileselected: function (e) {
      this.fullscreenLoading = true;
      let me = this;
      var files = e.target.files,
        f = files[0];
      var reader = new FileReader();
      reader.onload = function (e) {
        var data = new Uint8Array(e.target.result);
        var workbook = XLSX.read(data, { type: "array" });
        let sheetName = workbook.SheetNames[0];
        /* DO SOMETHING WITH workbook HERE */
        let worksheet = workbook.Sheets[sheetName];
        me.setImportarExcel(XLSX.utils.sheet_to_json(worksheet));
      };
      reader.readAsArrayBuffer(f);
    },
    setImportarExcel(data) {
      if (this.verifyFile(data)) {
        this.record = data;
        this.$toastr.info(
          "Satisactorio ",
          "Archivo ha sido leído correctamente, proceda a guardar."
        );
        this.save = true;
        this.dialogVisible = true;
      } else {
        this.save = false;
      }
      this.fullscreenLoading = false;
    },
    verifyFile(data) {
      let validate = true;
      if (data.length <= 0) {
        this.$toastr.error("Error ", "El archivo no tiene datos");
        validate = false;
      } else if (Object.keys(data[0]).length > 7) {
        this.$toastr.error("Error ", "El archivo tiene más de 6 Columnas");
        validate = false;
      } else {
        data.forEach((element) => {
          if (
            isNaN(element.cantidad) ||
            isNaN(element.precio) ||
            isNaN(element.estado) ||
            element.estado > 2 ||
            element.estado < 1
          ) {
            this.$toastr.error(
              "Error ",
              "Dato inválido en columna TIPO o ESTADO"
            );
            validate = false;
          }
        });
      }
      return validate;
    },
    pushFile() {
      this.fullscreenLoading = true;
      let url = "/products/pushFile";
      console.log(this.record);
      axios
        .post(url, { param: this.record })
        .then((response) => {
          if (response.data) {
            this.$toastr.success(
              "Satisfactorio ",
              "Los productos han sido creadas satisfactoriamente."
            );
            setTimeout(() => {
              location.reload();
            }, 3000);
          } else {
            this.$toastr.error("Error ", "Una categoría ha causado un error");
          }
        })
        .catch((error) => {
          //no estas autenticado
          if (error.response.status == 401) {
            this.$toastr.error("Error " + error.response.status);
          }
          setTimeout(() => {
            location.reload();
          }, 3000);
        });
    },
    handleClose() {
      this.dialogVisible = false;
    },
    downloadFile() {
      axios
        .get("/download/examples/demo_products.xlsx", {
          responseType: "arraybuffer",
        })
        .then((response) => {
          let blob = new Blob([response.data], { type: "application/*" });
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          link.download = "demo_products.xlsx";
          link.click();
        });
    },
  },
};
</script>

<style>
ul {
  padding-left: 10px;
}
ul li,
ol li {
  font-size: 10pt;
}
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

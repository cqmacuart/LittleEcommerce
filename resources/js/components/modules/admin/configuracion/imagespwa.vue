<template>
  <div>
    <h2 class="m-0 admin-title">Imagenes de la aplicación</h2>
    <hr />
    <p>
      Las siguientes im&aacute;genes se requieren para la personalizaci&oacute;n
      de los logos mostrados al iniciar la aplicaci&oacute;n instalada en la
      pantalla de su dispositivo.
    </p>
    <small>
      <span class="text-muted"
        >Favor apegarse a las dimensiones requeridas y al formato PNG para una
        mejor experiencia y personalizaci&oacute;n</span
      >
    </small>
    <hr class="mt-0" />
    <!-- Form -->
    <section
      class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
    >
      <div class="col-12 col-md-8 px-0 px-sm-2">
        <table class="table table-sm">
          <tbody>
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 72x72 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-72x72.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'72x72 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 96x96 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-96x96.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'96x96 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 128x128 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-128x128.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'128x128 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 144x144 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-144x144.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'144x144 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 152x152 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-152x152.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'152x152 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 192x192 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-192x192.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'192x192 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 384x384 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-384x384.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'384x384 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                icon 512x512 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="icon-512x512.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'512x512 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 640x1136 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-640x1136.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'640x1136 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 750x1334 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-750x1334.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'750x1334 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 828x1792 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-828x1792.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'828x1792 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1125x2436 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1125x2436.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1125x2436 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1242x2208 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1242x2208.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1242x2208 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1242x2688 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1242x2688.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1242x2688 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1536x2048 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1536x2048.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1536x2048 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1668x2224 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1668x2224.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1668x2224 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 1668x2388 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-1668x2388.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'1668x2388 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
            <tr class="text-left">
              <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                splash 2048x2732 px:
              </th>
              <td>
                <div class="custom-file">
                  <input
                    type="file"
                    class="custom-file-input form-control-sm border-0 border-bottom"
                    name="splash-2048x2732.png"
                    v-loading.fullscreen.lock="fullscreenLoading"
                    accept="image/png"
                    @change="getResponsiveFile"
                  />
                  <label
                    class="custom-file-label text-left border-0 border-bottom"
                    for="customFile"
                    >'2048x2732 px'</label
                  >
                </div>
              </td>
            </tr>
            <!--  -->
          </tbody>
        </table>
      </div>
    </section>
    <!-- End Form -->
  </div>
</template>

<script>
export default {
  name: "imagesPwa",
  data() {
    return {
      fullscreenLoading: false,
      form: new FormData(),
    };
  },
  methods: {
    getResponsiveFile: function (e) {
      if (e.target.files[0].size < 1000000) {
        this.fullscreenLoading = true;
        this.form.append("file", e.target.files[0]);
        this.form.append("text", e.target.name);
        const config = { headers: { "Content-Type": "multipart/form-data" } };
        let url = "/admin/settings/saveResponsiveFile";
        axios.post(url, this.form, config).then((response) => {
          if (response.status == 200) {
            this.$toastr.success(
              "Imagen de " + e.target.name + " añadida con éxito"
            );
          } else {
            this.$toastr.error("Ha ocurrido un error al cargar la imagen");
          }
          this.fullscreenLoading = false;
        });
      } else {
        this.$toastr.error("La imagen no debe exceder 1MB de espacio");
      }
    },
  },
};
</script>

<style>
</style>

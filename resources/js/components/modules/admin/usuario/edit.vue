<template>
  <section class="container col-12 mt-3">
    <div class="col-12 border rounded pt-2 bg-white pb-5">
      <h2 class="m-0 admin-title">Modificar Usuario</h2>
      <hr class="mt-0" />
      <!-- Form -->
      <section
        class="col-12 d-flex row flex-column flex-sm-row m-auto px-0 px-sm-2"
      >
        <div class="col-12 col-md-8 px-0 px-sm-2 m-auto">
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
                    v-model="fillUser.userNombre"
                    autofocus
                    tabindex="1"
                    required
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Email:
                </th>
                <td>
                  <input
                    type="email"
                    class="form-control form-control-sm border-0"
                    placeholder="Correo electrónico"
                    v-model="fillUser.userEmail"
                    tabindex="2"
                    required
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Contraseña:
                </th>
                <td>
                  <input
                    type="password"
                    class="form-control form-control-sm border-0"
                    placeholder="Ingrese su contraseña"
                    v-model="fillUser.userPassword"
                    tabindex="3"
                    required
                  />
                </td>
              </tr>
              <tr class="text-left">
                <th class="d-none d-sm-table-cell align-bottom align-sm-middle">
                  Confirmar:
                </th>
                <td>
                  <input
                    type="password"
                    class="form-control form-control-sm border-0"
                    placeholder="Ingrese su contraseña nuevamente"
                    v-model="fillUser.userConfirm"
                    tabindex="4"
                    required
                  />
                </td>
              </tr>
              <tr>
                <td colspan="2" class="text-right py-3">
                  <router-link
                    :to="{ name: 'admin.usuarios' }"
                    class="btn btn-sm btn-outline-secondary"
                  >
                    <span class="fas fa-arrow-left"></span>
                    Atras
                  </router-link>
                  <button
                    class="btn btn-sm btn-primary"
                    @click.prevent="setUser"
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
      fillUser: {
        userNombre: "",
        userEmail: "",
        userPassword: "",
        userConfirm: "",
      },
    };
  },
  mounted() {
    this.getEditCategory();
  },
  methods: {
    // CONSTRUCTORES <<<
    setUser: function () {
      if (this.validate()) {
        const params = {
          nombre: this.fillUser.userNombre,
          email: this.fillUser.userEmail,
          password: this.fillUser.userPassword,
        };
        axios.put(`/admin/users/${this.id}`, params).then((response) => {
          if (response.data) {
            this.$toastr.info("Usuario actualizado exitosamente");
            this.$router.push("/admin/usuarios");
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
    getEditCategory: function () {
      let userId = this.id;
      let url = "/admin/users/" + userId + "/edit";
      axios
        .get(url, {
          params: {
            id: this.id,
          },
        })
        .then((response) => {
          this.fillUser.userNombre = response.data.name;
          this.fillUser.userEmail = response.data.email;
        });
    },
    validate() {
      this.errors = [];
      let check = true;
      let mailPattern = new RegExp(
        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
      );
      if (this.fillUser.userNombre.length == 0) {
        this.errors.push({ error: "El nombre del usuario es requerido." });
        check = false;
      }
      if (this.fillUser.userPassword.length == 0) {
        this.errors.push({ error: "La contraseña es requerida." });
        check = false;
      }
      if (this.fillUser.userPassword.length < 8) {
        this.errors.push({ error: "La contraseña es muy corta." });
        check = false;
      }
      if (this.fillUser.userConfirm.length == 0) {
        this.errors.push({ error: "Se requiere confirmar contraseña." });
        check = false;
      }
      if (this.fillUser.userPassword != this.fillUser.userConfirm) {
        this.errors.push({ error: "Los campos de contraseña no coinciden." });
        check = false;
      }
      if (this.fillUser.userEmail.length == 0) {
        this.errors.push({ error: "El correo es un campo requerido" });
        check = false;
      }
      if (!mailPattern.test(this.fillUser.userEmail)) {
        this.errors.push({
          error: "El formato del correo electrónico no es válido",
        });
        check = false;
      }
      return check;
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
</style>

<template>
  <div class="d-flex justify-content-center">
    <div class="col-12 col-sm-6 col-md-5 mt-5">
      <div class="card">
        <div class="card-header">Recordar Contraseña</div>
        <div class="card-body px-1">
          <div class="col-12 p-1">
            <el-input
              placeholder="Correo Electrónico"
              v-model="rememberEmail"
              @keypress.native.enter="remember"
            >
              <i slot="suffix" class="el-input__icon el-icon-user"></i>
            </el-input>
          </div>
          <div class="row">
            <div class="col-12" v-if="error">
              <hr />
              <div
                class="callout callout-danger col-12 rounded mt-1 py-2"
                v-for="(msg, index) in messageError"
                :key="index"
              >
                <p class="m-0 text-muted text-danger" v-text="msg"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button
            class="btn btn-primary float-right"
            @click.prevent="remember"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            Proceder
          </button>
        </div>
      </div>
      <a href="/admin/login"><small>Volver al login</small></a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      rememberEmail: "",
      fullscreenLoading: false,
      error: 0,
      messageError: [],
    };
  },
  methods: {
    remember() {
      if (this.validarCorreo()) {
        return;
      }
      axios
        .get(`/admin/users/remember`, {
          params: {
            correo: this.rememberEmail,
          },
        })
        .then((response) => {
          if (response.status == 200) {
            const mailparams = {
              correo: this.rememberEmail,
              pass: response.data,
            };
            this.fullscreenLoading = true;
            axios.post("/sendingmail/remember", mailparams).then((response) => {
              this.fullscreenLoading = false;
              this.$toastr.info("Se le ha enviado un correo electrónico.");
              this.$router.push({ name: "admin.login" });
            });
          } else {
            this.$toastr.info("Ese correo electrónico no se encuentra registrado.");
          }
        });
    },
    validarCorreo() {
      this.error = 0;
      this.messageError = [];
      if (!this.rememberEmail) {
        this.messageError.push(
          "El correo es necesario para recuperar su contraseña"
        );
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
  },
};
</script>

<style>
.callout {
  border: thin solid #ccc;
  border-left: 4px solid #ccc;
}
.callout-danger {
  border-left-color: #e3342f;
}
</style>

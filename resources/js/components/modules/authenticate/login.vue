<template>
  <div class="d-flex justify-content-center">
    <div class="col-12 col-sm-6 col-md-5 mt-5">
      <div class="card">
        <div class="card-header">Ingreso de administrador</div>
        <div class="card-body px-1">
          <div class="col-12 p-1">
            <el-input
              placeholder="Usuario"
              v-model="fillLogin.user"
              @keypress.native.enter="login"
            >
              <i slot="suffix" class="el-input__icon el-icon-user"></i>
            </el-input>
          </div>
          <div class="col-12 p-1">
            <el-input
              placeholder="Contraseña"
              v-model="fillLogin.password"
              show-password
              @keypress.native.enter="login"
            >
              <i slot="suffix" class="el-input__icon el-icon-lock"></i>
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
            class="btn btn-primary btn-sm ml-3 float-right"
            @click.prevent="login"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            Login
          </button>
          <button
            class="btn btn-danger btn-sm ml-3 float-right text-nowrap"
            @click.prevent="remember"
            v-loading.fullscreen.lock="fullscreenLoading"
          >
            Olvidé la contraseña
          </button>
        </div>
      </div>
      <a href="/"><small>Volver a inicio</small></a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["ruta"],
  data() {
    return {
      fillLogin: {
        user: "",
        password: "",
      },
      fullscreenLoading: false,
      error: 0,
      messageError: [],
    };
  },
  methods: {
    login() {
      if (this.validarLogin()) {
        return;
      }
      this.fullscreenLoading = true;
      let url = `/authenticate/login`;
      axios
        .post(url, {
          usuario: this.fillLogin.user,
          password: this.fillLogin.password,
        })
        .then((response) => {
          if (response.data.code == 401) {
            this.loginFailed();
          }
          if (response.data.code == 200) {
            let obj = {
              user: response.data.userAuth,
              moment: Date.now(),
            };
            if (!sessionStorage.getItem("userAdmin")) {
              sessionStorage.setItem("userAdmin", obj);
            }
            this.loginSuccess();
          }
          //   this.fullscreenLoading = false;
        });
    },
    validarLogin() {
      this.error = 0;
      this.messageError = [];
      if (!this.fillLogin.user) {
        this.messageError.push("El campo usuario es obligatorio");
      }
      if (!this.fillLogin.password) {
        this.messageError.push("El campo contraseña es obligatorio");
      }
      if (this.messageError.length) {
        this.error = 1;
      }
      return this.error;
    },
    loginFailed() {
      this.error = 0;
      this.messageError = [];
      this.messageError.push("Error: usuario o contraseña inválidos");
      this.fillLogin.password = "";

      if (this.messageError.length) {
        this.error = 1;
      }
      this.fullscreenLoading = false;
      return this.error;
    },
    loginSuccess() {
      this.$router.push({ name: "admin.home" });
      location.reload();
      //   window.location.href = "admin";
    },
    remember() {
      this.fullscreenLoading = true;
      this.$router.push({ name: "admin.remember" });
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

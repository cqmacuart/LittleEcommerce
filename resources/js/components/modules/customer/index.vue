<template>
  <div v-if="!error">
    <!-- <section class="col-12 p-0 m-0 text-center">
      <img :src="`/img/categories/${categoryImage}`" alt class="img-fluid" v-if="categoryImage" />
    </section>-->
    <div class="col-12 pt-2 pb-1 text-center border-bottom">
      <a :href="`${ruta}/admin/home`" class="badge badge-warning">Revisar</a>
      <h5
        class="font-weight-bolder customer-title"
        v-if="orderHeader.length > 0"
      >
        Pedido {{ orderHeader[0].pedido }}
        <!-- <span class="fab fa-opencart fa-2x"></span> -->
      </h5>
      <a href="/">
        <h5 class="text-center">Volver al inicio.</h5>
      </a>
      <div
        v-if="orderHeader.length > 0"
        class="col-12 p-0 text-center text-muted"
      >
        <p class="m-0">
          <small
            >Puede Revisar la información de su pedido en el siguiente
            enlace</small
          >
        </p>
        <a :href="orderHeader[0].link">
          <code v-text="orderHeader[0].link"></code>
        </a>
      </div>

      <p class="text-center text-muted text-info"></p>
    </div>
    <div class="col-12 m-auto p-0 d-flex flex-col flex-sm-row row">
      <section
        class="container-md p-0 p-sm-3 col-12 col-sm-6 order-2 order-sm-1"
      >
        <div
          class="col-12 p-0"
          v-for="(product, index) in orderProducts"
          :key="index"
        >
          <div class="card h-100 col-12 mt-1 pr-3 pl-0 pt-md-0 card-product">
            <div class="row no-gutters h-100">
              <div
                class="col-4 d-flex align-items-center justify-content-center"
              >
                <img
                  :src="`/img/products/${product.image}`"
                  alt
                  class="img-fluid card-image"
                  v-if="product.image"
                  width="80px"
                />
              </div>
              <div class="col-8">
                <div class="card-header bg-transparent relative p-1">
                  <h5
                    v-text="product.nombre"
                    class="overflow-hidden text-nowrap m-0"
                  ></h5>
                </div>
                <div class="card-body p-1">
                  <small>
                    <p class="card-text" v-text="product.short_des"></p>
                  </small>
                  <p class="card-text p-0">
                    <small class="text-muted"
                      >{{ product.quantity }}x {{ currency }}
                      {{ product.price | numeral("0,0.00") }}
                    </small>
                  </p>
                </div>
                <div class="card-footer py-1 px-3">
                  <p
                    class="card-text text-primary text-right font-weight-bolder totalize"
                  >
                    {{ currency }}
                    {{ (product.quantity * product.price) | numeral("0,0.00") }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section
        class="container-md p-0 p-sm-3 col-12 col-sm-6 pb-3 order-1 order-sm-2 clearfix mt-1"
      >
        <div class="col-12 p-0 bg-white h-100">
          <table
            class="table table-sm table-bordered m-0"
            v-if="orderCustomer.length > 0"
          >
            <caption class="pl-3 text-muted">
              <small>**El valor del domicilio no se encuentra incluído</small>
            </caption>
            <tr>
              <th class="totalize text-black" style="width: 1%">Status</th>
              <td class="text-center">
                <label class="text-muted m-0" for v-if="orderHeader.length > 0">
                  <span
                    class="badge badge-info"
                    v-text="orderHeader[0].estado"
                  ></span>
                </label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black" style="width: 1%">Cliente</th>
              <td class="text-left">
                <label
                  class="text-muted m-0"
                  for
                  v-text="orderCustomer[0].nombre"
                ></label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black" style="width: 1%">Ciudad</th>
              <td class="text-left">
                <label
                  class="text-muted m-0"
                  for
                  v-text="orderCustomer[0].ciudad"
                ></label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black" style="width: 1%">Direccion</th>
              <td class="text-left">
                <label
                  class="text-muted m-0"
                  for
                  v-text="orderCustomer[0].direccion"
                ></label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black" style="width: 1%">Email</th>
              <td class="text-left">
                <label
                  class="text-muted m-0"
                  for
                  v-text="orderCustomer[0].email"
                ></label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black" style="width: 1%">Comentarios</th>
              <td class="text-left">
                <label
                  class="text-muted m-0"
                  for
                  v-text="orderCustomer[0].comentario"
                ></label>
              </td>
            </tr>
            <tr>
              <th class="totalize text-black">
                <label for class="m-0 py-2">Total</label>
              </th>
              <td class="text-right">
                <label class="totalize m-0 py-2" v-if="orderHeader.length > 0">
                  {{ currency }}
                  {{ orderHeader[0].amount | numeral("0,0.00") }}</label
                >
              </td>
            </tr>
          </table>
        </div>
      </section>
    </div>
  </div>
  <div v-else>
    <div class="alert alert-warning">
      <p class="text-center font-weight-bolder font-italic">
        <span class="fas fa-info"></span>
        {{ error }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["ruta", "serial", "currency"],
  data() {
    return {
      shoppingCart: [],
      orderHeader: [],
      orderProducts: [],
      orderCustomer: [],
      error: null,
    };
  },
  mounted() {
    this.getOrder(this.serial);
    // this.getCartTotalAmount();
  },
  methods: {
    getOrder(token) {
      axios.get(`/miorden/${token}`).then((response) => {
        if (response.status == 200) {
          this.orderHeader = response.data.order;
          this.orderCustomer = response.data.customer;
          //   Por cada detalle buscar su producto
          response.data.details.forEach((element) => {
            this.getProduct(element.product_id, element.quantity);
          });
        } else {
          this.error = "El token de la orden es incorrecto o no existe";
        }
      });
    },
    getProduct(id, qty) {
      axios.get(`/products/${id}`).then((response) => {
        let product = [];
        product = response.data;
        product["quantity"] = qty;
        this.orderProducts.push(product);
      });
    },
  },
};
</script>

<style>
</style>

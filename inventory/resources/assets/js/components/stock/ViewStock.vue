<template>
  <div class="wrap">
    <div class="body">
      <div class="row">
        <edit-stock :categorys="categorys" :vendors="vendors"></edit-stock>
        <update-qty></update-qty>
      </div>

      <div class="loading" v-if="isLoading">
        <h2 style="text-align:center">Cargando.......</h2>
      </div>

      <div class="row">
        <div class="col-md-4">
          <select class="form-control select2" data-live-serach="true" @change="getProduct()" v-model="category"
            v-select="category">
            <option value>Todas las categorías</option>
            <option v-for="(cat, index) in categorys" :value="cat.id">{{ cat.name }}</option>
          </select>
        </div>
        
        <div class="col-md-4">
          <select class="form-control select2" data-live-serach="true" @change="getData(1)" v-model="product"
            v-select="product" >
            <option value>Todos los productos</option>

            <option v-for="(pd, index) in products" :value="pd.id">{{ pd.product_name }}</option>
          </select>
        </div>
      </div>

      <div id="tabla_principal" class="table-responsive" >
        <table class="table table-condensed table-hover table-bordered">
          <thead>
            <tr>
              <th>N° orden ingreso</th>
              <th>Factura</th>
              <th>Observaciones generales</th>
              
              <th style="text-align: center">Ver productos</th>
              <th style="text-align: center">Editar observación</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in stocks.data" v-if="shouldShowRow(value)">
              <td>
                #{{ value.orden }}
              </td>
              <td>
                {{ value.factura }}
              </td>
              <td>
                {{ value.note }}
              </td>

              <td style="text-align: center">
                <button type="button"
                  class="btn bg-orange btn-circle waves-effect waves-circle waves-float"
                  @click="selectOrder(value.orden)">
                  <i class="material-icons">remove_red_eye</i>
                </button>
              </td>
              <td style="text-align: center">
                <button @click="editStock(value.id, value.category_id)" type="button"
                  class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">edit</i>
                </button>
              </td>
              </tr>
          </tbody>
        </table>
      </div>

      <div v-if="tabla_secundaria" class="table-responsive">
        
        <h2 v-if="cerrar" class="pull-right">
          <a href @click="reload()" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
            <i class="material-icons">close</i>
          </a>
        </h2>

        <label disabled="true">Orden ingreso: #{{ selectedOrder }}</label> 
        
        <table class="table table-condensed table-hover table-bordered">
          <thead>
            <tr>
              <th>Categoría</th>
              <th>Producto</th>
              <th>Proveedor</th>

              <th>Cantidad</th>
              <th>Fecha</th>
              
              <th style="text-align: center">Editar cantidad</th>
              <th style="text-align: center">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in stocks.data" v-if="value.orden === selectedOrder">

              <td>{{ value.category.name }}</td>
              <td>{{ value.product.product_name }}</td> 
              <td>{{ value.vendor.name }}</td>
                
              <td>{{ value.current_quantity }}</td>
              <td>{{ value.fecha }}</td>

              <td style="text-align: center">
                <button @click="editQty(value.id, value.category_id)" type="button"
                  class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">add</i>
                </button>
              </td>
              <td style="text-align: center">
                <button @click="deleteStock(value.id)" type="button" 
                  class="btn bg-pink btn-circle waves-effect waves-circle waves-float" >
                  <i class="material-icons">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.js";
import MomentMixin from "../../moment_mixin.js";

import editStock from "./editStock.vue";
import UpdateQuantity from "./UpdateQuantity.vue";


export default {
  props: ["categorys", "vendors"],

  mixins: [mixin, MomentMixin],

  components: {
    "edit-stock": editStock,
    "update-qty": UpdateQuantity,
  },

  data() {
    return {
      stocks: [],
      hideInput: true,
      id: "",
      name: "",
      product: "",
      marca: "",
      detalle: "",
      material: "",
      iva: "",
      category: "",
      vendor: "",
      orden: "",
      factura: "",
      products: [],
      isLoading: true,
      selectedOrder: null,
      filtros: false,
      tabla_secundaria: false,
      cerrar: false,
    };
  },

  created() {

    var _this = this;
    this.getData();

    EventBus.$on("stock-created", function () {
      window.history.pushState({}, null, location.pathname);
      _this.getData();
    });
  },


  methods: {

    shouldShowRow(value) {
      const ordersCount = JSON.parse(localStorage.getItem('orders')) || {};
      const currentOrder = value.orden;

      if (!ordersCount[currentOrder]) {
        ordersCount[currentOrder] = 1;
        localStorage.setItem('orders', JSON.stringify(ordersCount));
        return true;//oculta
      } else {
        return false;//muestra
      }
    },

    selectOrder(order) {
      document.getElementById("tabla_principal").style.display="none";

      this.tabla_secundaria=true;
      this.cerrar=true;

      this.selectedOrder = order;
    },

    getData(page = 1) {
      this.isLoading = true;
      axios
        .get(
          base_url +
          "stock-list?page=" +
          page +
          "&product=" +
          this.product +
          "&category=" +
          this.category +
          "&vendor=" +
          this.vendor
        )
        .then((response) => {
          // console.log(response.data);

          this.stocks = response.data;
          this.isLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getProduct() {
      if (this.category === "") {
        this.products = [];

        this.product = "";
      } else {
        this.products = [];
        axios
          .get(base_url + "category/product/" + this.category)
          .then((response) => {
            this.products = response.data;
          });
      }
      this.getData(1);  
    },

    editStock(id, category_id) {
      EventBus.$emit("edit-stock", id, category_id);
    },

    editQty(id) {
      EventBus.$emit("edit-qty", id);
    },

    reload(){
      location.reload();
    },

    deleteStock(id) {
      Swal(
        {
          title: "¿Estás seguro?",
          text: "¡No podrás revertir esto!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "¡Sí, eliminar!",
        },
        () => { }
      ).then((result) => {
        if (result.value) {
          axios.get(base_url + "stock/delete/" + id).then((res) => {
            EventBus.$emit("stock-created", 1);

            this.successALert(res.data);
          });
        }
      });
    },
  },
};
</script>
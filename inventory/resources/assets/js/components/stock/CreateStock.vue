<template>
  <div class="wrap">
    <div class="modal fade" id="create-stock" tabindex="-1" role="dialog" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Agregar orden ingreso</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors">{{ error[0] }}</li>
              </ul>
            </div>
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">category</i>
                    </span>
                    <div class="form-line">
                      <select id="select_categoria" class="form-control select2" v-model="stock.category" v-select="stock.category"
                        @change="findProduct()">
                        <option value>Selecciona una categoría</option>

                        <option v-for="(value, index) in categorys" :value="value.id">{{ value.name }}</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">shopping_cart</i>
                    </span>
                    <div class="form-line">
                      <select id="select_producto" class="form-control select2" v-model="stock.product" v-select="stock.product">
                        <option value="">Selecciona un producto</option>

                        <option v-for="(value, index) in products" :value="value.id">{{ value.product_name }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">people</i>
                    </span>
                    <div class="form-line">
                      <select id="select_proveedor" class="form-control select2" v-model="stock.vendor" v-select="stock.vendor">
                        <option value>Selecciona un proveedor</option>
                        <option v-for="(vd, index) in vendors" :value="vd.id">{{ vd.name }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">add</i>
                    </span>
                    <div class="form-line">
                      <input id="input_cantidad" type="text" class="form-control" :placeholder="'Cantidad a ingresar' + (stock.product ? ' - ' + products.find(vd => vd.id === stock.product).details : '')" v-model="stock.current_quantity" @input="validateNumberInput" min="1"/>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">receipt</i>
                    </span>
                    <div class="form-line">
                      <input id="input_factura" type="text" class="form-control" placeholder="N° factura" v-model="stock.factura" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">calendar_month</i>
                    </span>
                    <div class="form-line">
                      <vuejs-datepicker id="datepicker_fecha" :input-class="'form-control'" v-model="stock.fecha" value-format="dd-MM-yyyy" placeholder="Selecciona una fecha"></vuejs-datepicker>
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br/>
            <button v-if="showAddButton" @click="createStock()" type="button" class="btn btn-success waves-effect">Agregar producto</button>
            
            <button v-if="showAddButton2" @click="resetForm()" type="button" class="btn btn-default waves-effect">
              ¿Agregar otro producto?
            </button>
            
            <button @click="reload()" type="button" class="btn btn-default waves-effect"
              data-dismiss="modal">Finalizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import Datepicker from "vuejs-datepicker";
import Multiselect from 'vue-multiselect';
import mixin from "../../mixin";

export default {
  props: ["vendors", "date", "categorys"],

  mixins: [mixin],

  components: {
    "vuejs-datepicker": Datepicker,
    Multiselect
  },

  data() {
    return {
      stock: {
        currentUrl: "",
        currentUrlPart: "",
        product: "",
        category: "",
        marca: "",
        detalle: "",
        material: "",
        vendor: "",
        unit: "",
        quantity: "",
        current_quantity: "",
        bodega_stock_quantity: "",
        minimum: "",
        buying_price: "",
        selling_price: "",
        note: "",
        factura: "",
        fecha: "",
        orden: ""
      },
      showAddButton: true,
      showAddButton2: false,
      products: [],
      errors: null,
    };
  },

  created() {

    this.setCurrentUrlPart();
    this.$nextTick(() => {
      this.$forceUpdate();
      this.resetForm();
    });
  },

  methods: {
    setCurrentUrlPart() {
      const urlParts = window.location.href.split('/');
      this.stock.currentUrlPart = urlParts[urlParts.length - 1];
    },
    findProduct() {
      if (this.stock.category === "") {
        this.products = [];
      } else {
        this.products = [];
        axios
          .get(base_url + "category/product/" + this.stock.category)
          .then((response) => {
            this.products = response.data;
          });
      }
    },

    createStock() {

      axios
        .post(base_url + "stock", this.stock)
        .then((response) => {
          //$("#create-stock").modal("hide");
          this.showAddButton = false;
          this.showAddButton2 = true;
          //this.resetForm();
          this.errors = null;
          EventBus.$emit("stock-created", response.data);
          this.successALert(response.data);
          // Obtener ID
          const selectCategoria = document.getElementById('select_categoria');
          // Deshabilitar input
          selectCategoria.disabled = true;

          // Obtener ID
          const selectProducto = document.getElementById('select_producto');
          // Deshabilitar input
          selectProducto.disabled = true;

          // Obtener ID
          const selectProveedor = document.getElementById('select_proveedor');
          // Deshabilitar input
          selectProveedor.disabled = true;

          // Obtener ID
          const inputCantidad = document.getElementById('input_cantidad');
          // Deshabilitar input
          inputCantidad.disabled = true;

          // Obtener ID
          const inputFactura = document.getElementById('input_factura');
          // Deshabilitar input
          inputFactura.disabled = true;

          // Obtener ID
          const inputFecha = document.getElementById('datepicker_fecha');
          // Deshabilitar input
          inputFecha.disabled = true;

          // Obtener ID
          const inputObservacion = document.getElementById('input_observaciones');
          // Deshabilitar input
          inputObservacion.disabled = true;
        })
        .catch((err) => {
          if (err.response) {
            this.errors = err.response.data.errors;
          }
        });
    },

    validateNumberInput(){
      this.stock.current_quantity = this.stock.current_quantity.replace(/[^0-9.]/g, '');
    },

    defaultValue(){
      if(this.stock.currentUrl == "" ){
        this.stock.currentUrl = window.location.href;
      }
    },

    resetForm() {
      this.showAddButton = true;
      this.showAddButton2 = false;
      this.stock.product = "";
      this.stock.category = "";
      this.stock.current_quantity = "";
      this.stock.fecha = "";

      // Obtener ID
      const selectCategoria = document.getElementById('select_categoria');
      // Deshabilitar input
      selectCategoria.disabled = false;

      // Obtener ID
      const selectProducto = document.getElementById('select_producto');
      // Deshabilitar input
      selectProducto.disabled = false;

      // Obtener ID
      const inputCantidad = document.getElementById('input_cantidad');
      // Deshabilitar input
      inputCantidad.disabled = false;

      // Obtener ID
      const inputFecha = document.getElementById('datepicker_fecha');
      // Deshabilitar input
      inputFecha.disabled = false;

    },
    reload(){
      location.reload();
    }
  },
};
</script>
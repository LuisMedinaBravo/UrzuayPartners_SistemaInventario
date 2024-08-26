<template>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h2 v-if="!invoice_state" style="position: absolute; margin: 18px 0 0 20px; z-index: 2;">
      <button @click="showInvoice" type="button" class="btn bg-teal">
        Nueva solicitud de material
      </button>
    </h2>
    <div v-if="ocultar_crear_solicitud" v-show="invoice_state" class="card">
      <div class="header" style="padding-bottom: 60px;">
        <h2 class="pull-left">Crear solicitud</h2>

        <h2 class="pull-right">
          <a href @click.prevent="showInvoice" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
            <i class="material-icons">close</i>
          </a>
        </h2>
      </div>

      <div class="body">
        <form @submit.prevent="store()">
          <div class="row">
          </div>

          <div class="row">
            <div class="col-md-6">
              <p>Número de solicitud</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">speaker_notes</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name v-model="'#' + invoice.invoice_no">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <p>Fecha de la solicitud</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">calendar_month</i>
                </span>
                <div class="form-line">
                  <vuejs-datepicker :input-class="'form-control'" :format="'yyyy-MM-dd'" value-format="yyyy-MM-dd" :value="getCurrentDate()" :disabled="true"></vuejs-datepicker>
                  <span class="requiredField" v-if="(errors.hasOwnProperty('invoice_date'))">{{ (errors.hasOwnProperty('invoice_date')) ? errors.invoice_date[0] : '' }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- main invoice part  -->
          <div class="">
            <div class="table-responsive">
              <table class="table table-bordered table-condensed" style="min-height: 200px; width: 100%">
                <thead class="bg-teal">
                  <tr>
                    <th style="text-align:center;"></th>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Categoría</th>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Producto</th>
                    <th style="letter-spacing: 0.1em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Cantidad</th>
                    <th style="letter-spacing: 0.1em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Marca/modelo</th>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Patente</th>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Código</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(vl, index) in invoice.product">
                    <td>
                      <a href @click.prevent="removeItem(index)" style="color: red">
                        <i class="material-icons">delete</i>
                      </a>
                    </td>
                    <td>
                      <multiselect v-model="invoice.product[index].category" deselect-label="" track-by="id" label="name"
                        open-direction="bottom" placeholder="Selecciona categoría" :options="categorys"
                        @input="findProduct(index)" :allow-empty="false">
                      </multiselect>
                    </td>

                    <td>
                      <multiselect v-model="invoice.product[index].product_id" deselect-label="" track-by="id"
                        label="product_name" open-direction="bottom" placeholder="Seleccionar producto"
                        :options="invoice.product[index].products" @input="findStock(index)" :allow-empty="false">
                      </multiselect>
                    </td>

                    <td>
                      <input class="form-control" type="number" name
                        v-model="invoice.quantity"
                        placeholder="Cantidad">
                    </td>

                      <td>
                        <input type="text" class="form-control" name="marca_modelo" v-model="invoice.marca_modelo" placeholder="Requerido"></input>
                      </td>

                      <td>
                        <input type="text" class="form-control" name="patente" v-model="invoice.patente" placeholder="Requerido"></input>
                      </td>

                      <td>
                        <input type="text" class="form-control" name="codigo" v-model="invoice.codigo" placeholder="Opcional"></input>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row" style="margin-top: 10px">
              <div class="col-md-12">
                <a href @click.prevent="addmore" class="btn bg-teal">+ Añadir más</a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" style="margin-top: 20px">
              <div class="form-group">
                <button type="submit" class="btn bg-teal">Generar solicitud de material</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";

import mixin from "../../mixin";

import Datepicker from "vuejs-datepicker";

import Multiselect from 'vue-multiselect';

export default {
  props: ["categorys", "customers"],
  mixins: [mixin],

  components: {
    "vuejs-datepicker": Datepicker,
    Multiselect
  },

  data() {
    return {
      sedeLS: '',
      ocultar_crear_solicitud: false,
      invoice: {
        invoice_no: "",
        invoice_date: new Date().toISOString(),
        marca_modelo: "",
        patente: "",
        codigo: "",
        observaciones: "",
        valor_venta: "",
        sede_lista_solicitud: localStorage.getItem('sede'),
        estado: "Pendiente",
        quantity: "",
        product: [
          {
            category: "",
            product_id: "",
            estado: "Pendiente",
            products: [],
            stocks: []
          }
        ]
      },
      invoice_state: false,
      errors: {}
    };
  },

  created() {
    this.sedeLS = localStorage.getItem('rol');
    if(this.sedeLS == 'administrador'){
      this.invoice_state=true;
      this.ocultar_crear_solicitud=false;
    }
    if(this.sedeLS == 'encargado'){
      this.invoice_state=true;
      this.ocultar_crear_solicitud=false;
    }
    if(this.sedeLS == 'jefetaller'){
      this.invoice_state=true;
      this.ocultar_crear_solicitud=false;
    }
    if(this.sedeLS == 'maestro'){
      this.invoice_state=false;
      this.ocultar_crear_solicitud=true;
    }
   },

  methods: {
    
    getCurrentDate() {
      return new Date().toISOString();
    },

    store() {
      axios
        .post(base_url + "invoice", this.invoice)
        .then(response => {
          this.successALert(response.data);

          this.resetForm();

          this.invoice_state = false;

          EventBus.$emit("invoice-created", 1);
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;

            Swal("Oops", "¡por favor complete el formulario con los datos correctos!", "error");
          } else {
            this.successAlert(error);
          }
        });
    },

    findProduct(index) {
      if (this.invoice.product[index].category === "") {
        this.invoice.product[index].products = [];
      } else {
        axios
          .get(
            base_url +
            "category/product/" +
            this.invoice.product[index].category.id
          )
          .then(response => {
            this.invoice.product[index].products = response.data;
            this.invoice.product[index].stocks = [];
          });
      }
    },

    findStock(index) {
      if (this.invoice.product[index].product_id === "") {
        this.invoice.product[index].stocks = [];
      } else {
        axios
          .get(
            base_url +
            "chalan-list/chalan/" +
            this.invoice.product[index].product_id.id
          )
          .then(response => {
            this.invoice.product[index].stocks = response.data;
          });
      }
    },

    showInvoice() {
      this.invoice_state = !this.invoice_state;

      axios.get(base_url + "get/invoice/number").then(response => {
        this.invoice.invoice_no = response.data;
      });

      window.scrollTo(0, top);
    },

    addmore() {
      this.invoice.product.push({
        category: "",
        product_id: "",
        quantity: 0,
        products: [],
        stocks: []
      });
    },

    removeItem(index) {
      var _this = this;
      if (_this.invoice.product.length > 1) {
        _this.invoice.product.splice(index, 1);
      }
    },

    resetForm() {
      this.invoice = {
        invoice_no: "",
        invoice_date: "",
        product: [
          {
            category: "",
            product_id: "",
            quantity: 0,
            products: [],
            stocks: []
          }
        ]
      };
    },
  },
};
</script>

<style type="text/css">
  .requiredField {
    color: red;
  }
</style>
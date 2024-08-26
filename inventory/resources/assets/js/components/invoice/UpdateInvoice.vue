<template>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div v-show="invoice_state" class="card">
      <div class="header">
        <h2 class="pull-left">
          Ver/Editar solicitud de material

        </h2>

        <h2 class="pull-right">
          <a href="" @click.prevent="showInvoice" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
            <i class="material-icons">close</i>
          </a>
        </h2>
      </div>

      <div class="body">

        <form>

          <div class="row">

            <div class="col-md-4">
              <p>Número de solicitud</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">assignment</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="'#' + invoice.invoice_no">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Fecha solicitud</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">calendar_month</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.invoice_date">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Técnico Automotriz</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">engineering</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.user_name">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Marca/Modelo</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">directions_car</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.marca_modelo">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Patente</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">image_aspect_ratio</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.patente">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Código</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">password</i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.codigo">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <p>Observaciones generales</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">border_color</i>
                </span>
                <div class="form-line">
                  <textarea class="form-control" type="text" name="" placeholder="Opcional" v-model="invoice.observaciones" :disabled="isInputDisabled || invoice.estado === 'Aceptado' || invoice.estado === 'Rechazado'"></textarea>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>Estado solicitud</p>
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons" :class="{ 'text-success': invoice.estado === 'Aceptado', 'text-danger': invoice.estado === 'Rechazado', 'text-warning': invoice.estado === 'Pendiente' }"> {{ invoice.estado === 'Aceptado' ? 'check_circle' : invoice.estado === 'Rechazado' ? 'cancel' : 'error' }} </i>
                </span>
                <div class="form-line">
                  <input class="form-control" type="text" disabled name="" v-model="invoice.estado">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="table-responsive">
              <table class="table table-bordered table-condensed">
                <thead class="bg-teal">
                  <tr>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Categoría</th>
                    <th style="letter-spacing: 0.3em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Producto</th>
                    <th style="letter-spacing: 0.2em; width: 15%; padding-left: 10px; padding-right: 10px; text-align:center;">Cantidad</th>
                  </tr>
                </thead>

                <tbody>

                  <tr v-for="(vl, index) in invoice.product">   

                    <td style="width:350px">
                      <select class="form-control" v-model="invoice.product[index].category" @change="findProduct(index)" disabled>
                        <!-- <option value="">Seleccionar categoría</option> -->
                        <option v-for="(value, index) in categorys" :value="value.id">{{ value.name }}</option>

                      </select>
                      <span v-if="errors['product.' + index + '.category']" class="requiredField">{{
                        errors['product.' + index + '.category'][0] }}</span>
                    </td>

                    <td style="width:350px">
                      <select class="form-control" v-model="invoice.product[index].product_id" @change="findStock(index)" disabled>
                        <!-- <option value="">Seleccionar producto</option> -->
                        <option v-for="pr in vl.products" :value="pr.id">{{ pr.product_name }}</option>

                      </select>
                      <span v-if="errors['product.' + index + '.product_id']" class="requiredField">{{
                        errors['product.' + index + '.product_id'][0] }}</span>
                    </td>

                    <td> 
                      <input class="form-control" type="number" v-model="invoice.product[index].quantity" :disabled="invoice.estado === 'Aceptado' || invoice.estado === 'Rechazado'"> 
                    </td>
                    
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="rowButton">
            <div v-if="ocultar_columna_editar && invoice.estado !== 'Aceptado' && invoice.estado !== 'Rechazado'" class="form-group col-md-4" style="text-align: center;">
              <button class="btn bg-teal" @click.prevent="store">Aceptar solicitud</button>
            </div>
            <div v-if="ocultar_columna_editar && invoice.estado !== 'Aceptado' && invoice.estado !== 'Rechazado'" class="form-group col-md-4" style="text-align: center;">
              <button class="btn bg-red" @click.prevent="storeRechazar">Rechazar solicitud</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script>

import { EventBus } from '../../vue-asset';

import mixin from '../../mixin';

import Datepicker from 'vuejs-datepicker';

export default {

  props: ['categorys', 'customers'],
  mixins: [mixin],

  components: {
    'vuejs-datepicker': Datepicker,
  },

  data() {

    return {
      sedeLS: '',
      ocultar_columna_editar: true,
      isInputDisabled: false,
      isButtonDisabled: false,
      invoice: {
        invoice_no: '',
        user_id: '',
        user_name: '',
        invoice_date: '',
        marca_modelo: "",
        patente: "",
        codigo: "",
        observaciones: "",
        estado: "",
        product: [
          {
            category: '',
            product_id: '',
            quantity: '',
            products: [],
            stocks: [],
          }
        ],
      },
      currentRowIndex: -2, // Índice de la fila actual
      intervalId: null, // Guardar la referencia del intervalo
      invoice_state: false,
      errors: {},
    }
  },

  created() {

    this.sedeLS = localStorage.getItem('rol');

    if (this.sedeLS === 'maestro') {
        // Ocultar el botón si el rol es "maestro"
        this.ocultar_columna_editar = false;
        this.isInputDisabled = true;
    }

    var _this = this;
    EventBus.$on('edit-invoice', function (id) {

      _this.editData(id);
      _this.invoice_state = true;

      window.scrollTo(0, 0);
    });
  },

  computed: {
  quantityPlaceholder() {
    return this.invoice.quantity.pop();
  }
},

  methods: {
    getQuantityByIndex(rowIndex) {
    if (this.invoice.quantity && Array.isArray(this.invoice.quantity) && rowIndex < this.invoice.quantity.length) {
    
      const quantity = this.invoice.quantity[rowIndex];
      this.invoice.quantity.splice(rowIndex, 1);
      return quantity;
    
    } else {
    
      return 'HOLAAAAA';
    
    }
  },
  updateCurrentRow(rowIndex) {
    this.currentRowIndex = rowIndex;
  },

    editData(id) {

      axios.get(base_url + 'invoice/' + id + '/edit')

        .then(response => {
          this.invoice = response.data;
        })
    },

    store() {
      axios.post(base_url + 'invoice/update/' + this.invoice.invoice_no, this.invoice)
        .then(response => {

          this.successALert(response.data);

          this.resetForm();

          this.invoice_state = false;

          EventBus.$emit('invoice-created', 1);

        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;

            Swal("Oops", "Faltan datos en alguno de los campos de la tabla", "error");
          }
          else {
            this.successAlert(error);
          }
        });
    },


    storeRechazar() {
      axios.post(base_url + 'invoice/updateRechazar/' + this.invoice.invoice_no, this.invoice)
        .then(response => {

          this.successALert(response.data);

          this.resetForm();

          this.invoice_state = false;

          EventBus.$emit('invoice-created', 1);

        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;

            Swal("Oops", "Faltan datos en alguno de los campos de la tabla", "error");
          }
          else {
            this.successAlert(error);
          }
        });
    },


    findProduct(index) {

      if (this.invoice.product[index].category === '') {

        this.invoice.product[index].products = [];

      }
      else {

        axios.get(base_url + 'category/product/' + this.invoice.product[index].category)
          .then(response => {

            this.invoice.product[index].products = response.data;
            this.invoice.product[index].stocks = [];

          })

      }
    },

    findStock(index) {

      if (this.invoice.product[index].product_id === '') {
        this.invoice.product[index].stocks = [];
      }
      else {
        axios.get(base_url + 'chalan-list/chalan/' + this.invoice.product[index].product_id)
          .then(response => {
            this.invoice.product[index].stocks = response.data;
          })
      }
    },

    showInvoice() {

      this.invoice_state = !this.invoice_state;
      // $("html, body").animate({ scrollTop: 0 }, 800);

      axios.get(base_url + 'get/invoice/number')
        .then(response => {

          this.invoice.invoice_no = response.data;

        })
      window.scrollTo(0, top);
    },

    resetForm() {

      this.invoice = {
        invoice_no: '',
        invoice_date: '',
        product: [
          {
            category: '',
            product_id: '',
            products: [],
            stocks: [],
          }
        ],
      }
    },
  },

  // end of method section 

  mounted() {
  // Iniciar el intervalo para actualizar el índice
  this.intervalId = setInterval(this.updateIndex, 5000); // Actualizar cada 5 segundos
},
beforeUnmount() {
  // Detener el intervalo cuando se desmonte el componente
  clearInterval(this.intervalId);
}
}
</script>

<style type="text/css">
.requiredField {
  color: red;
}
.rowButton {
  display: flex;
  justify-content: center;
}
</style>
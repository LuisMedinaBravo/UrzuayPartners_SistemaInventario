<template>
  <div class="wrap">
    <div class="body" style="position: relative;">
      <update-invoice :categorys="categorys" :customers="customers"></update-invoice>

      <div class="row">
        <div class="col-md-4">
          <input type="text" class="form-control " v-on:keyup="getData(1)" v-model="invoice_id"
            placeholder="Buscar por número de solicitud">
        </div>
        <div class="col-md-4" v-if="sede_in_localStorage !== 'linares' && sede_in_localStorage !== 'molina'">
          <input type="text" class="form-control" v-on:keyup="getData(1)" v-model="sede_lista_solicitud" placeholder="Buscar por sede">
        </div>
        <div class="col-md-4">
          <select class="form-control" v-model="estado" v-on:change="getData(1)">
            <option value="">Filtrar por estado</option>
            <option value="Aceptado">Aceptado</option>
            <option value="Rechazado">Rechazado</option>
            <option value="Pendiente">Pendiente</option>
          </select>
        </div>
      </div>

      <div class="loading" v-if="isLoading">
        <h2 style="text-align:center">Cargando.......</h2>
      </div>

      <div class="table-responsive" v-else>

        <table class="table table-condensed table-hover table-bordered">
          <thead>
            <tr>
              <th>N° solicitud</th>
              <th>Fecha solicitud</th>
              <th>Técnico automotriz</th>
              <th>Sede</th>
              <th>Marca/modelo</th>
              <th>Patente</th>
              <th>Código</th>
              <th>Observaciones generales</th>
              <th>Estado</th>
              <th style="text-align: center">Ver</th>
              <th style="text-align: center">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in invoices.data">
              <td>#{{ value.id }}</td>
              <td>{{ value.sell_date | moment('LL') }}</td>
              <td>{{ value.user.name }}</td>
              <td>{{ value.sede_lista_solicitud }}</td>
              <td>{{ value.marca_modelo }}</td>
              <td>{{ value.patente }}</td>
              <td>{{ value.codigo }}</td>
              <td>{{ value.observaciones }}</td>
              <td :class="{'text-danger': value.estado === 'Rechazado', 'text-success': value.estado === 'Aceptado', 'text-black': value.estado === 'Pendiente'}">{{ value.estado }}</td>
              <td style="text-align: center">

                <button @click="editInvoice(value.id)" type="button"
                  class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">remove_red_eye</i>
                </button>
              </td>

              <td style="text-align: center">
                <button @click="deleteInvoice(value.id)" type="button"
                  class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <pagination :pageData="invoices"></pagination>

    </div>
  </div>
</template>

<script>

import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.js';
import MomentMixin from '../../moment_mixin.js';
import Pagination from '../pagination/pagination.vue';

import Datepicker from 'vuejs-datepicker';
import UpdateInvoice from './UpdateInvoice.vue';

export default {

  props: ['categorys', 'customers'],

  mixins: [mixin, MomentMixin],

  components: {

    'update-invoice': UpdateInvoice,
    'vuejs-datepicker': Datepicker,
    'pagination': Pagination,
  },

  data() {
    return {
      invoice_id: '',
      estado: '',
      sede_in_localStorage: localStorage.getItem('sede'),
      sede_lista_solicitud: localStorage.getItem('sede'),
      start_date: new Date('2019-02-03'),
      end_date: '',
      invoices: [],
      format: 'yyyy-MM-dd',
      url: base_url + 'invoice/',
      isLoading: true,
    }
  },

  created() {

    if(this.sede_lista_solicitud === "bodega_central"){
      this.sede_lista_solicitud = '';
    }

    var _this = this;
    this.getData();

    EventBus.$on('invoice-created', function () {
      _this.getData();
    });
  },

  methods: {

    getData(page = 1) {

      this.isLoading = true;
      axios.get(base_url + "invoice-list?page=" + page + "&invoice_id=" + this.invoice_id  + "&estado=" + this.estado  + "&sede_lista_solicitud=" + this.sede_lista_solicitud +   "&start_date=" + this.end_date + "&end_date=" + this.start_date).then(response => {
        this.invoices = response.data;
        this.isLoading = false;

      }).catch(error => {

        console.log(error);
      })
    },

    editInvoice(id) {

      EventBus.$emit('edit-invoice', id);

    },

    deleteInvoice(id) {

      Swal({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: "Cancelar",
        confirmButtonText: '¡Sí, eliminar!'
      }, () => {

      }).then((result) => {
        if (result.value) {

          axios.get(base_url + 'invoice/delete/' + id)
            .then(res => {

              EventBus.$emit('invoice-created', 1);

              this.successALert(res.data);
            })
        }
      })
    },

    pageClicked(pageNo) {
      var vm = this;
      vm.getData(pageNo);
    },
  },
}

</script>

<style>
  .text-danger {
    color: red;
    font-weight: bold;
  }
  .text-success {
    color: green;
    font-weight: bold;
  }
  .text-black {
    color: black;
    font-weight: bold;
  }
</style>
<template>
  <div class="wrap">
    <div class="body">
      <div class="row">
        <div class="col-md-4">
          <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por nombre" name=""
            v-model="name">
        </div>
        </div>
      </div>

      <div class="loading" v-if="isLoading">
        <h2 style="text-align:center">Cargando.......</h2>
      </div>

      <div class="table-responsive" v-else>
        <table class="table table-condensed table-hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Abreviación</th>
              <th style="text-align: center">Editar</th>
              <th style="text-align: center">Eliminar</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in customers.data" v-bind:key="index">
              <td>{{ value.customer_name }}</td>
              <td>{{ value.abreviacion }}</td>
              <td style="text-align: center">
                <button @click="editcustomer(value.id)" type="button"
                  class="btn btn-warning btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">edit</i>
                </button>
              </td>
              <td style="text-align: center">
                <button  @click="deleteCategory(value.id)" type="button"
                  class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                  <i class="material-icons">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <pagination :pageData="customers"></pagination>

      <div class="row">
        <update-customer></update-customer>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";

import UpdateCustomer from "./UpdateCustomer.vue";
import Pagination from '../pagination/pagination.vue';

export default {
  mixins: [mixin],

  components: {
    "update-customer": UpdateCustomer,
    "pagination": Pagination,
  },

  data() {
    return {
      customers: [],
      name: "",
      abreviacion: "",
      isLoading: true,
    };
  },
  created() {
    var _this = this;
    this.getData();

    EventBus.$on("customer-created", function () {
      _this.getData();
    });
  },

  methods: {
    getData(page = 1) {
      this.isLoading = true;
      axios
        .get(
          base_url +
          "customer-list?page=" +
          page +
          "&name=" +
          this.name +
          "&abreviacion=" +
          this.abreviacion
        )
        .then(response => {
          // console.log(response.data);

          this.customers = response.data;
          this.isLoading = false;
        })
        .catch(error => {
          console.log(error);
        });
    },

    // edit vendor

    editcustomer(id) {
      EventBus.$emit("customer-edit", id);
    },

    showMessage(data) {
      if (data.status == "success") {
        Swal.fire({
          title: "Success Alert",
          text: data.message,
          icon: "success",
          customClass: {
            popup: 'swal2-centered'
          }
        });
      } else {
        Swal.fire({
          title: "Error Alert",
          text: data.message,
          icon: "error",
          customClass: {
            popup: 'swal2-centered'
          }
        });
      }
    },

    deleteCategory(id) {
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
          axios.get(base_url + "customer/delete/" + id).then((res) => {
            EventBus.$emit("category-created", 1);
            this.successALert(res.data);
          });
        }
      });
    },

    pageClicked(pageNo) {
      var vm = this;
      vm.getData(pageNo);
    }
  },

  computed: {
  }
};
</script>
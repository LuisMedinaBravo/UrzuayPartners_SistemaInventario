<template>
  <div class="wrap">
    <div class="modal fade" id="create-customer" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Unidad nueva</h4>
          </div>
          <div class="modal-body">
            <!-- <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors">{{ error[0] }}</li>
              </ul>
            </div> -->
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors" :key="error.id">{{ error[0] }}</li>
              </ul>
            </div>
            <form>
              <div class="row">
                
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">straighten</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Nombre" v-model="customer.customer_name">
                    </div>
                  </div>
                </div>

                <!-- <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">vpn_key</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Rut" v-model="customer.rut" @input="validateRutInput" maxlength="12">
                    </div>
                  </div>
                  <p style="text-align: center; font-size: 12px; margin-top: -20px">Ejemplo formato: <i>11.111.111-K</i></p>
                </div> -->

                <!-- <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Correo electrónico"
                        v-model="customer.email">
                    </div>
                  </div>
                </div> -->

                <!-- <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">phone</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Teléfono" v-model="customer.phone" @input="validatePhoneInput" maxlength="12">
                    </div>
                  </div>
                </div> -->

                <!-- <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Dirección" v-model="customer.address" />
                    </div>
                  </div>
                </div> -->

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">short_text</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Abreviación" v-model="customer.abreviacion" />
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br>
            <button @click="createCustomer" type="button" class="btn btn-success waves-effect">Guardar</button>
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";

export default {
  mixins: [mixin],

  data() {
    return {
      customer: {
        customer_name: "",
        // email: "",
        // phone: "",
        // address: "",
        // rut: "",
        abreviacion: ""
      },

      errors: null
    };
  },

  methods: {
    createCustomer() {
      axios
        .post(base_url + "customer", this.customer)

        .then(response => {
          $("#create-customer").modal("hide");

          this.customer = {
            customer_name: "",
            // email: "",
            // phone: "",
            // address: "",
            // rut: "",
            abreviacion: ""
          };
          this.errors = null;
          EventBus.$emit("customer-created", response.data);

          // this.showMessage(response.data);

          this.successALert(response.data);
        })
        .catch(err => {
          if (err.response) {
            this.errors = err.response.data.errors;
          }
        });
    },
  },

  // end of method section

  created() { }
};
</script>
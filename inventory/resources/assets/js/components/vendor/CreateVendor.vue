<template>
  <div class="wrap">
    <div class="modal fade" id="create-vendor" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Información del proveedor</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger" v-if="errors">
              <ul>
                <li v-for="error in errors">{{ error[0] }}</li>
              </ul>
            </div>
            <form>
              <div class="row">
                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Nombre" v-model="vendor.name" />
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Correo electrónico"
                        v-model="vendor.email"/>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">vpn_key</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Rut" v-model="vendor.rut" @input="validateRutInput" maxlength="12" />
                    </div>
                  </div>
                  <p style="text-align: center; font-size: 12px; margin-top: -20px">Ejemplo formato: <i>11.111.111-K</i></p>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">phone</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Teléfono" v-model="vendor.phone" @input="validatePhoneInput" maxlength="12"/>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                    <div class="form-line">
                      <select class="form-control" v-model="vendor.region">
                        <option v-for="region in regions" :value="region.region">{{ region.region }}</option>
                      </select>
                    </div>
                  </div>
                  <p style="text-align: center; font-size: 12px; margin-top: -20px">Seleccionar región</p>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">location_on</i>
                    </span>
                    <div class="form-line">
                      <select class="form-control" v-model="vendor.commune">
                        <option v-for="commune in vendor.region ? getCommunes(vendor.region) : []" :value="commune">{{ commune }}</option>
                      </select>
                    </div>
                  </div>
                  <p style="text-align: center; font-size: 12px; margin-top: -20px">Seleccionar comuna</p>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">person_pin_circle</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Dirección" v-model="vendor.address" />
                    </div>
                  </div>
                  <div style="border-top: 2px solid #000; margin: 20px 0;"></div>
                </div>
            
                <p>Información de contacto (opcional)</p>
                <div class="col-md-6"> 
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">face</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Nombre contacto" v-model="vendor.soporte_nombre" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">drafts</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Correo contacto" v-model="vendor.soporte_correo"/>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">add_call</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Teléfono contacto" v-model="vendor.soporte_phone" @input="validatePhoneInput" maxlength="12" />
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br />
            <button @click="createVendor" type="button" class="btn btn-success waves-effect">Guardar</button>
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

import regionData from './comunas-regiones.json';

export default {
  mixins: [mixin],

  data() {
    return {
      vendor: {
        name: "",
        rut: "",
        email: "",
        phone: "",
        address: "",
        soporte_nombre: "",
        soporte_correo: "",
        soporte_phone: "",
        region: null,
        commune: null
      },
      regions: regionData.regiones,
      errors: null,
    };
  },

  methods: {
    getCommunes(regionName) {
      const selectedRegion = this.regions.find(r => r.region === regionName);
      return selectedRegion ? selectedRegion.comunas : [];
    },

    createVendor() {
      axios
        .post(base_url + "supplier", this.vendor)

        .then((response) => {
          $("#create-vendor").modal("hide");

          this.vendor = { name: "", rut: "", email: "", phone: "", address: "", region: "", commune: "", soporte_nombre: "", soporte_correo: "", soporte_phone: "" };
          this.errors = null;
          EventBus.$emit("vendor-created", response.data);

          // this.showMessage(response.data);

          this.successALert(response.data);
        })
        .catch((err) => {
          if (err.response) {
            this.errors = err.response.data.errors;
          }
        });
    },
     validateRutInput() {
       // Regular expression to match only numbers, ".", "-", and "K"
       // Limit the input to 12 characters
       this.vendor.rut = this.vendor.rut.slice(0, 12);
       this.vendor.rut = this.vendor.rut.replace(/[^0-9\.\-K]/g, '');
    },
    validatePhoneInput() {
      this.vendor.phone = this.vendor.phone.replace(/[^0-9+]/g, '');
      this.vendor.soporte_phone = this.vendor.soporte_phone.replace(/[^0-9+]/g, '');
    }
  },
  created() {}
};
</script>
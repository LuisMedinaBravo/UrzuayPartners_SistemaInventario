<template>
  <div class="wrap">
    <div class="modal fade" id="create-product" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Información del producto</h4>
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
                      <i class="material-icons">category</i>
                    </span>

                    <select id="mySelect2" class="form-control select2" v-model="product.category"
                      v-select="product.category">
                      <option value="0">Selecciona una categoría</option>

                      <option v-for="(value, index) in categorys" :value="value.id" v-bind:key="index">{{ value.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">shopping_cart</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Nombre" v-model="product.name" />
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">local_offer</i>
                    </span>
                    <div class="form-line">
                      <input type="text" class="form-control date" placeholder="Marca" v-model="product.marca" />
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">short_text</i>
                    </span>

                    <select id="mySelect3" class="form-control select2" v-model="product.unit" v-select="product.unit">
                      <option value="0">Selecciona una unidad</option>

                      <option v-for="(value, index) in units" :value="value.id" v-bind:key="index">{{ value.customer_name }}</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">warning</i>
                    </span>
                    <div class="form-line">
                      <input type="number" class="form-control date" placeholder="Stock crítico" v-model="product.critico" min="0" />
                    </div>
                  </div>
                </div>

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br />
            <button @click="createProduct" type="button" class="btn btn-success waves-effect">Guardar</button>
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
  props: ["categorys", "units"],

  mixins: [mixin],
  mounted() {
    $('#mySelect2').val('0').trigger('change'); // Establece la opción por defecto
    $('#mySelect3').val('0').trigger('change'); // Establece la opción por defecto
  },
  data() {
    return {
      product: {
        category: "",
        unit: "",
        name: "",
        marca: "",
        stock: 0,
        critico: ""
      },
      errors: null,
    };
  },

  methods: {

    createProduct() {

      axios
        .post(base_url + "product", this.product)

        .then((response) => {
          $("#create-product").modal("hide");

          this.product = { name: "", unit: "", imagen: "", marca: "", stock:"", critico: "", category: "" };
          this.errors = null;
          EventBus.$emit("product-created", response.data);

          // this.showMessage(response.data);

          this.successALert(response.data);
          $('#mySelect2').val('0').trigger('change');
          $('#mySelect3').val('0').trigger('change');
        })
        .catch((err) => {
          if (err.response) {
            this.errors = err.response.data.errors;
          }
        });
    },
  },

  // end of method section

  created() { },
};
</script>
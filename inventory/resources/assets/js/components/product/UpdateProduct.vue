<template>
  <div class="col-md-12">
    <div class="modal fade" id="update-product" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Actualizar información del producto</h4>
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
                    <div class="form-line">
                      <select class="form-control select2" v-model="product.category" v-select="product.category">
                        <option value>Selecciona una categoría</option>

                        <option v-for="(value, index) in cat" :value="value.id">{{ value.name }}</option>
                      </select>
                    </div>
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
                    <div class="form-line">
                      <select class="form-control select2" v-model="product.unit" v-select="product.unit">
                        <option value>Selecciona una unidad</option>

                        <option v-for="(value, index) in uni" :value="value.id">{{ value.customer_name }}</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">warning</i>
                    </span>
                    <div class="form-line">
                      <input type="number" class="form-control date" placeholder="Stock crítico" v-model="product.critico" min="0"/>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br />
            <button @click="updateProduct(product.id)" type="button"
              class="btn btn-success waves-effect">Actualizar</button>
            <button @click="closeModal()" type="button" class="btn btn-default waves-effect"
              data-dismiss="modal">Cancelar</button>
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
  props: ["cat", "uni"],

  mixins: [mixin],
  name: "update-product",

  data() {
    return {
      product: {
        id: "",
        category: "",
        unit: "",
        name: "",
        marca: "",
        critico: ""
      },
      errors: null,
    };
  },

  created() {
    
    let vm = this;

    EventBus.$on("product-edit", function (id) {
      vm.product.id = id;

      $("#update-product").modal("show");

      vm.editProduct(id);
    });

    $("#update-product").on("hidden.bs.modal", function () {
      vm.closeModal();
    });
  },
  
  methods: {

    editProduct(id) {
      axios
        .get(base_url + "product/" + id + "/edit")

        .then((response) => {
          console.log('Response data:', response.data);
          this.product = {
            id: response.data.id,
            category: response.data.category_id,
            unit: response.data.unit_id,
            name: response.data.product_name,
            marca: response.data.marca,
            critico: response.data.critico,
          };
        });
    },
    updateProduct(id) {
      axios
        .post(base_url + "product/update/" + id, this.product)
        .then((res) => {
          if (res.data.status == "success") {
            this.successALert(res.data);
            EventBus.$emit("product-created", 1);
            this.closeModal();
            $("#update-product").modal("hide");
          }
        })
        .catch((err) => {
          if (err.response) {
            this.errors = err.response.data.errors;
          }
        });
    },

    closeModal() {
      this.errors = null;
      this.product = { id: 0, name: ""};
      EventBus.$emit("product-created", 1);
    },
  },
};
</script>
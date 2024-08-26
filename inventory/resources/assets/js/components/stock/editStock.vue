<template>
  <div class="wrap">
    <div class="modal fade" id="edit-stock" tabindex="-1" role="dialog" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Editar observación de orden de ingreso</h4>
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
                      <i class="material-icons">description</i>
                    </span>
                    <div class="form-line">
                      <input id="input_observaciones" type="text" class="form-control" placeholder="Observaciones generales" v-model="stock.note" />
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <br />
            <button @click="updateStock(stock.id)" type="button" class="btn btn-success waves-effect">Actualizar</button>
            <button @click="resetForm()" type="button" class="btn btn-default waves-effect"
              data-dismiss="modal">Cerrar</button>
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
  props: ["vendors", "categorys"],
  mixins: [mixin],

  data() {
    return {
      stock: {
        id: "",
        product: "",
        marca: "",
        detalle: "",
        category: "",
        vendor: "",
        quantity: "",
        current_quantity: "",
        buying_price: "",
        selling_price: "",
        material: "",
        note: "",
        chalan_no: "",
        new_qty: "",
        factura: ""
      },
      products: [],
      errors: null,
    };
  },

  created() {
    
    let vm = this;

    EventBus.$on("edit-stock", function (id, category_id) {

      vm.stock.id = id;
      vm.stock.category = category_id;
      vm.editStock(id);
      vm.findProduct();
      $("#edit-stock").modal("show");
    });

    $("#edit-stock").on("hidden.bs.modal", function () {
      vm.resetForm();
    });

  },

  methods: {

    updateStockSellingPrice(){
      this.stock.selling_price = "";
    },
    
    editStock(id) {
      axios.get(base_url + "stock/" + id + "/edit").then((response) => {
        this.stock = {
          id: response.data.id,
          product: response.data.product_id,
          marca: response.data.marca,
          detalle: response.data.detalle,
          category: response.data.category_id,
          vendor: response.data.vendor_id,
          quantity: response.data.stock_quantity,
          current_quantity: response.data.current_quantity-(response.data.current_quantity-1),
          buying_price: response.data.buying_price,
          selling_price: response.data.selling_price,
          material: response.data.material,
          note: response.data.note,
          chalan_no: response.data.chalan_no,

        };
      });
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

    updateStock(id, e) {
      //if (this.stock.state === "yes") {
      //}
          axios
          .post(base_url + "stock/update/" + id, this.stock)

          .then((response) => {
            $("#edit-stock").modal("hide");

            this.resetForm();

            this.errors = null;
            EventBus.$emit("stock-created", response.data);

            this.successALert(response.data);
            location.reload();
          })
          .catch((err) => {
            if (err.response) {
              this.errors = err.response.data.errors;
              location.reload();
            }
          });
    },
    resetForm() {
      this.stock = {
        note: "",
      };
    },
  },
};
</script> 
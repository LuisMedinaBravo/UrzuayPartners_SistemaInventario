<template>
  <div class="wrap">
    <div class="row" v-if="isLoading">
      <h1 style="text-align:center">Cargando...</h1>
    </div>

    <div class="row clearfix" v-if="!isLoading">

      <!-- Resumen para todos los tipos de usuarios -->

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">straighten</i>
          </div>
          <div class="content">
            <div class="text">Total unidades</div>
            <div class="number">{{ info.total_customer }}</div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">category</i>
          </div>
          <div class="content">
            <div class="text">Total categorías</div>
            <div class="number">{{ info.total_category }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">shopping_cart</i>
          </div>
          <div class="content">
            <div class="text">Total productos</div>
            <div class="number">{{ info.total_product }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-orange" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">warning</i>
          </div>
          <div class="content">
            <div class="text">Total producto por debajo stock crítico</div>
            <div class="number">{{ info.total_critico }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-orange hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">people</i>
          </div>
          <div class="content">
            <div class="text">Total proveedores</div>
            <div class="number">{{ info.total_vendor }}</div>
          </div>
        </div>
      </div>

      <!-- Resumen para encargado y jefe de taller de Linares -->

      <div v-if="linares_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">receipt</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes Linares</div>
            <div class="number">{{ info.total_solicitudes_linares }}</div>
          </div>
        </div>
      </div>

      <div v-if="linares_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-teal" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">check</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes aceptadas Linares</div>
            <div class="number">{{ info.total_aceptado_linares }}</div>
          </div>
        </div>
      </div>

      <div v-if="linares_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">close</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes rechazadas Linares</div>
            <div class="number">{{ info.total_rechazado_linares }}</div>
          </div>
        </div>
      </div>

      <div v-if="linares_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">error</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes pendiente Linares</div>
            <div class="number">{{ info.total_pendiente_linares }}</div>
          </div>
        </div>
      </div>

      <!-- Resumen para encargado y jefe de taller de Molina -->

      <div v-if="molina_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">receipt</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes Molina</div>
            <div class="number">{{ info.total_solicitudes_molina }}</div>
          </div>
        </div>
      </div>
      
      <div v-if="molina_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-teal" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">check</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes aceptadas Molina</div>
            <div class="number">{{ info.total_aceptado_molina }}</div>
          </div>
        </div>
      </div>

      <div v-if="molina_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">close</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes rechazadas Molina</div>
            <div class="number">{{ info.total_rechazado_molina }}</div>
          </div>
        </div>
      </div>

      <div v-if="molina_columna_encargado_jefetaller" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">error</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes pendiente Molina</div>
            <div class="number">{{ info.total_pendiente_molina }}</div>
          </div>
        </div>
      </div>

      <!-- Resumen para técnico automotriz -->

      <div v-if="ocultar_columna_maestro" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">receipt</i>
          </div>
          <div class="content">
            <div class="text">Solicitudes realizadas</div>
            <div class="number">{{ info.total_solicitud_tecnico }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_maestro" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-teal" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">check</i>
          </div>
          <div class="content">
            <div class="text">Solicitudes aceptadas</div>
            <div class="number">{{ info.total_aceptado_tecnico }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_maestro" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">close</i>
          </div>
          <div class="content">
            <div class="text">Solicitudes rechazadas</div>
            <div class="number">{{ info.total_rechazado_tecnico }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_maestro" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">error</i>
          </div>
          <div class="content">
            <div class="text">Solicitudes pendientes</div>
            <div class="number">{{ info.total_pendiente_tecnico }}</div>
          </div>
        </div>
      </div>

      <!-- Resumen para administrador -->

      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">inventory</i>
          </div>
          <div class="content">
            <div class="text">Total orden de compra (entradas)</div>
            <div class="number">{{ info.total_existencia }}</div>
          </div>
        </div>
      </div>
      
      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-blue-grey" style="border-radius: 25px; height: 100px;">
          <div class="icon">
            <i class="material-icons">receipt</i>
          </div>
          <div class="content">
            <div class="text">Total lista de solicitudes</div>
            <div class="number">{{ info.total_invoice }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-teal" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">check</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes aceptadas</div>
            <div class="number">{{ info.total_aceptado }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-red" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">close</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes rechazadas</div>
            <div class="number">{{ info.total_rechazado }}</div>
          </div>
        </div>
      </div>

      <div v-if="ocultar_columna_bodega_central" class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink" style="border-radius: 25px; height: 100px;">
        <!-- <div class="info-box bg-deep-purple hover-zoom-effect"> -->
          <div class="icon">
            <i class="material-icons">error</i>
          </div>
          <div class="content">
            <div class="text">Total solicitudes pendientes</div>
            <div class="number">{{ info.total_pendiente }}</div>
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
  data() {
    return {
      info: {},
      isLoading: true,
      sedeLS: '',
      rolLS: '',
      ocultar_columna_bodega_central: true,
      ocultar_columna_maestro: false,
      linares_columna_encargado_jefetaller: false,
      molina_columna_encargado_jefetaller: false
    };
  },

  created() {

    this.sedeLS = localStorage.getItem('sede');

    if(this.sedeLS == "linares"){
      this.ocultar_columna_bodega_central = false;
    }
    if(this.sedeLS == "molina"){
      this.ocultar_columna_bodega_central = false;
    }

    this.rolLS = localStorage.getItem('rol');

    if(this.rolLS == "maestro"){
      this.ocultar_columna_maestro = true;
    }

    if(this.rolLS == "encargado" && this.sedeLS == "linares" ){
      this.linares_columna_encargado_jefetaller = true;
    }
    if(this.rolLS == "jefetaller" && this.sedeLS == "linares" ){
      this.linares_columna_encargado_jefetaller = true;
    }
    if(this.rolLS == "encargado" && this.sedeLS == "molina" ){
      this.molina_columna_encargado_jefetaller = true;
    }
    if(this.rolLS == "jefetaller" && this.sedeLS == "molina" ){
      this.molina_columna_encargado_jefetaller = true;
    }

    this.getData();

  },

  methods: {
    getData() {
      axios.get(base_url + "info-box").then((response) => {
        this.info = response.data;
        this.isLoading = false;
      });
    },
  },
};

</script>
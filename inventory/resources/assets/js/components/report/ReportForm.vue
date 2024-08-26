<template>
	<div class="row">
		<div class="col-md-4">
			<div class="input-group">
				<div class="form-line">
					<select class="form-control select2" name="type" required="" v-model="report_type" v-select="report_type" @change="reloadPage">
						<option :value="''" :disabled="report_type !== ''">Seleccionar tipo de reporte</option>
						<option :value="'stock'">Reporte de entradas</option>
						<option :value="'invoice'">Reporte de solicitudes</option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="input-group">
				<div class="form-line">
				<vuejs-datepicker
					:required="true"
					:placeholder="'Fecha desde'"
					:name="'start_date'"
					:input-class="'form-control'"
					@selected="updateEndDateDisabled"
				></vuejs-datepicker>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="input-group">
				<div class="form-line">
				<vuejs-datepicker
					:required="true"
					:placeholder="'Fecha hasta'"
					:name="'end_date'"
					:input-class="'form-control'"
					:disabled-dates="disabledEndDates"
					v-model="end_date"
					@selected="clearEndDate"
				></vuejs-datepicker>
				</div>
			</div>
		</div>

		<div class="col-md-4" v-if="!isEnable">
			<div class="input-group">
				<div class="form-line">
					<select class="form-control select2" name="category_id" v-model="category_id" v-select="category_id"
						v-on:change="findProduct">
						<option value="">Seleccionar categoría (opcional)</option>
						<option v-for="value in category" :value="value.id">{{ value.name }}</option>
					</select>
				</div>
			</div>
		</div>

		<div class="col-md-4" v-if="!isEnable">
			<div class="input-group">
				<div class="form-line">
					<select class="form-control select2" name="product_id" v-model="product_id" v-select="product_id"
						v-on:change="findStock">
						<option value="">Seleccionar producto (opcional)</option>
						<option v-for="pr in product" :value="pr.id">{{ pr.product_name }}</option>
					</select>
				</div>
			</div>
		</div>


		<div class="col-md-4" v-if="!isEnable">
			<div class="input-group">
				<div class="form-line">
					<select class="form-control select2" name="vendor_id">
						<option value="">Seleccionar proveedor (opcional)</option>
						<option v-for="vn in vendor" :value="vn.id">{{ vn.name }}</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

import { EventBus } from '../../vue-asset';
import Datepicker from 'vuejs-datepicker';
import mixin from '../../mixin.js';

export default {
	props: ['category', 'user', 'customer', 'vendor'],
	components: {
		'vuejs-datepicker': Datepicker,
	},
	mixins: [mixin],

	data() {
		return {
			report_type: '',
			category_id: '',
			product_id: '',
			chalan_id: '',
			product: [],
			chalan: [],
			end_date: null,
      		disabledEndDates: null, // Inicialmente, no hay fechas deshabilitadas en el end_date
		}
	},
	created() {
		if(localStorage.getItem('reporte') === 'stock'){
			//location.reload();
			this.report_type = 'stock';

		}else if(localStorage.getItem('reporte') === 'invoice'){
			//location.reload();
			this.report_type = 'invoice';
		}
	},

	methods: {

		reloadPage() {
			if (this.report_type === 'stock') {
				localStorage.setItem('reporte','stock');
				location.reload();
			} else if (this.report_type === 'invoice') {
				localStorage.setItem('reporte','invoice');
				location.reload();
			}
		},

		updateEndDateDisabled(date) {
			this.disabledEndDates = {
				to: date, // Deshabilitar todas las fechas anteriores a la fecha seleccionada en start_date
			};
			this.end_date = null;
		},
		clearEndDate() {
			this.end_date = null; // Clear the end_date input when the start_date is clicked
		},
		
		findProduct() {
			this.product = [];
			axios.get(base_url + 'category/product/' + this.category_id)
				.then(response => {
					this.product = response.data;
				})
		},

		findStock() {

			this.chalan = [];
			axios.get(base_url + 'chalan-list/chalan/' + this.product_id)
				.then(response => {
					this.chalan = response.data;
				})
		},
	},

	computed: {
		isEnable() {
			return this.report_type === 'invoice' || this.report_type === 'due';
		}
	}
}

</script>
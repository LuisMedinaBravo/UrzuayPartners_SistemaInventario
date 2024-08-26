<template>
	<div class="wrap">
		<div class="modal fade" id="create-user" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<form @submit.prevent="createuser">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="defaultModalLabel">Usuario nuevo</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-danger" v-if="errors">
								<ul>
									<li v-for="error in errors">{{ error[0] }}</li>
								</ul>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">account_circle</i>
										</span>
										<div class="form-line">
											<input type="text" class="form-control date" placeholder="Nombre" v-model="user.name">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">email</i>
										</span>
										<div class="form-line">
											<input type="email" class="form-control date" placeholder="Correo electrónico" v-model="user.email">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">lock</i>
										</span>
										<div class="form-line">
											<input type="password" class="form-control date" placeholder="Ingresar contraseña"
												v-model="user.password">
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">lock_open</i>
										</span>
										<div class="form-line">
											<input type="password" class="form-control date" placeholder="Reingresar contraseña"
												v-model="user.password_confirmation">
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">vpn_key</i>
										</span>
										<div class="form-line">
											<select class="form-control" v-model="user.role">
												<option value="">Seleccionar un rol</option>
												<option v-for="value in role_list" :value="value.id">{{ value.role_name }}</option>
											</select>
										</div>
									</div>
								</div>
								<div style="display: none;"> <div class="col-md-12"> <div class="input-group"> <span class="input-group-addon"> <i class="material-icons">business</i> </span> <div class="form-line"> <input type="text" class="form-control" v-model="user.sede" readonly> </div> </div> </div> </div>
							</div>
						</div>
						<div class="modal-footer">
							<br>
							<button type="submit" class="btn btn-success waves-effect">Guardar</button>
							<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
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


export default {

	mixins: [mixin],

	data() {
		return {
			user: {
				name: '',
				email: '',
				password: '',
				password_confirmation: '',
				role: '',
				sede: '',
				roles: ''
			},
			role_list: [],
			errors: null
		}
	},
	watch: {
		'user.role'(newRole) {
		this.updateSede(newRole);
		}
	},
	mounted() {
		this.roleList();
	},

	methods: {
	
	updateSede(newRole) {
		console.log('newRole:', newRole);
		const selectedRole = this.role_list.find(role => role.id === newRole);
		if (selectedRole) {
		console.log('selectedRole:', selectedRole);
		switch (selectedRole.role_name) {
			case 'Administrador':
			this.user.sede = 'todo';
			this.user.roles = 'administrador';
			break;
			case 'Encargado-Linares':
			this.user.sede = 'linares';
			this.user.roles = 'encargado';
			break;
			case 'Encargado-Molina':
			this.user.sede = 'molina';
			this.user.roles = 'encargado';
			break;
			case 'JefeTaller-Linares':
			this.user.sede = 'linares';
			this.user.roles = 'jefetaller';
			break; 
			case 'JefeTaller-Molina':
			this.user.sede = 'molina';
			this.user.roles = 'jefetaller';
			break;
			case 'Técnico-Linares':
			this.user.sede = 'linares';
			this.user.roles = 'maestro';
			break;
			case 'Técnico-Molina':
			this.user.sede = 'molina';
			this.user.roles = 'maestro';
			break;
			default:
			this.user.sede = 'ninguno';
			this.user.roles = 'ninguno';
		}
		} else {
		console.log('selectedRole not found');
		this.user.sede = 'ninguno';
		}
	},

		createuser() {

			axios.post(base_url + 'user', this.user)

				.then(response => {

					$('#create-user').modal('hide');

					this.user = {
						'name': '',
						'email': '',
						'password': '',
						'password_confirmation': '',
						'role': '',
						'sede': ''
					};

					this.errors = null;
					EventBus.$emit('user-created', response.data);
					this.successALert(response.data);

				})
				.catch(err => {

					if (err.response) {

						this.errors = err.response.data.errors;
					}

				})

		},
		roleList() {

			axios.get(base_url + 'role-list')
				.then(response => {
					this.role_list = response.data;
				});
		},
	},
	created() {
	},
}
</script>
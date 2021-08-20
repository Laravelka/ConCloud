<template>
	<div>
		<div :class="modalClasses" class="fade" id="reject" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Загрузка договора</h4>
						<button type="button" class="close" @click="toggle()">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Название</label>
							<input type="text" class="form-control" id="name" v-model="form.name">
							<small v-if="errors.name" v-html="errors.name[0]" style="color: var(--danger)"></small>
						</div>
						<div class="form-group">
							<label for="contacts">Контакты</label>
							<input type="text" class="form-control" id="contacts" v-model="form.contacts">
							<small v-if="errors.contacts" v-html="errors.contacts[0]" style="color: var(--danger)"></small>
						</div>
						<div class="form-group">
							<drop class="drop" @drop="handleDrop">
								Перетащите документ
								<div class="form-upload w-100">
									<input @change="onChangeInput" class="myInput" type="file"></input>
									<button class="btn btn-outline-primary" style="border-radius: 1rem">
										Или нажмите сюда
									</button>
								</div>
							</drop>
							<small v-if="errors.file" v-html="errors.file[0]" style="color: var(--danger)"></small>
						</div>
						<div class="form-group">
							<label class="w-100">Дата конца контракта</label>
							<div class="w-100">
								<date-picker v-model="form.contract_end" :config="options"></date-picker>
							</div>
							<small v-if="errors.contract_end" v-html="errors.contract_end[0]" style="color: var(--danger)"></small>
						</div>
						<div class="form-group">
							<label class="w-100">Дата заключения контракта</label>
							<div class="w-100">
								<date-picker v-model="form.contract_conclusion" :config="options"></date-picker>
							</div>
							<small v-if="errors.contract_conclusion" v-html="errors.contract_conclusion[0]" style="color: var(--danger)"></small>
						</div>
						<div class="form-group">
							<label class="w-100">Дата подачи расторжения контракта</label>
							<div class="w-100">
								<date-picker v-model="form.contract_termination" :config="options"></date-picker>
							</div>
							<small v-if="errors.contract_termination" v-html="errors.contract_termination[0]" style="color: var(--danger)"></small>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" @click="toggle(), cancelModal()">Отмена</button>
						<button v-if="isLoading" class="btn btn-primary" type="button" disabled>
							<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="
								position: relative;
								bottom: 1.5px;
							"></span>
							Загрузка...
						</button>
						<button v-else type="button" class="btn btn-primary" @click="onClickUpload">
							Загрузить
						</button>
					</div>
				</div>
			</div>
		</div>
		<button @click="toggle()" class="btn btn-outline-success" type="submit" style="border-radius: 1rem">
			<i class="bi bi-cloud-upload custom-size" style="position: relative; top: 2px"></i> Загрузить договор
		</button>
	</div>
</template>

<script>
	import { Drag, Drop } from 'vue-drag-drop';
	import datePicker from 'vue-bootstrap-datetimepicker';
	import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
	import axios from 'axios';
	import moment from 'moment';

	export default {
		data: () => ({
			form: {
				name: '',
				contacts: '',
				formData: new FormData(),
				contract_end: new Date(),
				contract_conclusion: new Date(),
				contract_termination: new Date(),
			},
			options: {
				format: 'DD/MM/YYYY HH:mm',
				useCurrent: true,
				icons: {
					time: 'far fa-clock',
					date: 'far fa-calendar',
					up: 'fas fa-arrow-up',
					down: 'fas fa-arrow-down',
					previous: 'fas fa-chevron-left',
					next: 'fas fa-chevron-right',
					today: 'fas fa-calendar-check',
					clear: 'far fa-trash-alt',
					close: 'far fa-times-circle'
				}
			},
			errors: {},
			isLoading: false,
			modalClasses: ['modal','fade'],
		}),
		components: { Drag, Drop, datePicker },
		methods: {
			cancelModal() {
				this.form = {
					name: '',
					contacts: '',
					formData: new FormData(),
					contract_end: new Date(),
					contract_conclusion: new Date(),
					contract_termination: new Date(),
				};
			},
			onChangeInput(event) {
				const files = event.target.files;
				
				this.form.name = files.item(0).name;
				this.form.formData.append('file', files[0]);
			},
			handleDrop(data, event) {
				event.preventDefault();

				const files = event.dataTransfer.files;

				this.form.name = files.item(0).name;
				this.form.formData.append('file', files[0]);
			},
			toggle() {
				document.body.className += ' modal-open';

				let modalClasses = this.modalClasses;
			
				if (modalClasses.indexOf('d-block') > -1) {
					modalClasses.pop();
					modalClasses.pop();
			
					//hide backdrop
					let backdrop = document.querySelector('.modal-backdrop');

					document.body.removeChild(backdrop);
				} else {
					modalClasses.push('d-block');
					modalClasses.push('show');
			
					//show backdrop
					let backdrop = document.createElement('div');
					backdrop.classList = "modal-backdrop fade show";
					document.body.appendChild(backdrop);
				}
			},
			onClickUpload() {
				this.isLoading = true;
				
				const data = this.form.formData;
				data.append('name', this.form.name);
				data.append('contacts', this.form.contacts);
				data.append('contract_end', moment(this.form.contract_end).format('YYYY-MM-DD HH:mm:ss'));
				data.append('contract_conclusion', moment(this.form.contract_conclusion).format('YYYY-MM-DD HH:mm:ss'));
				data.append('contract_termination', moment(this.form.contract_termination).format('YYYY-MM-DD HH:mm:ss'));

				axios.post('/files/upload', data, {
					onUploadProgress: function(progressEvent) {
						console.log(parseInt(Math.round(( progressEvent.loaded / progressEvent.total) * 100)));
					}
				}).then((response) => {
					this.toggle();
					this.$emit('fileUpload');
					this.isLoading = false;
				}).catch((error) => {
					let that = this;
					this.isLoading = false;

					if (
						error.response &&
						error.response.data &&
						error.response.data.messages
					) {
						const { messages } = error.response.data;

						this.errors = messages;
					} else if (
						error.response &&
						error.response.data &&
						error.response.data.message
					) {
						alert(error.response.data.message);
					} else {
						console.error(error);
					}
					setTimeout(() => {
						that.errors = {};
					}, 4000);
				});
			}
		}
	}
</script>

<style>
	.modal-mask {
		position: fixed;
		z-index: 9998;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, .5);
		display: table;
		transition: opacity .3s ease;
	}

	.modal-wrapper {
		display: table-cell;
		vertical-align: middle;
	}

	.drag, .drop {
		display: inline-block;
	}

	.drop {
		background: #eee;
		border-top: 2px solid #ccc;
		border-left: 2px solid #ddd;
	}
	.drag, .drop {
		box-sizing: border-box;
		display: inline-block;
		border-radius: 1rem;
		width: 100%;
		height: 150px;
		background: #efefef;
		vertical-align: middle;
		margin-right: 20px;
		position: relative;
		padding: 5px;
		padding-top: 35px;
		text-align: center;
		margin: 3px;
		border: 3px dashed #3490dc;
	}

	.form-upload {
		position: relative;
		overflow: hidden;
		display: inline-block;
	}

	.form-upload .myInput {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
	}

	.w-100 {
		width: 100%!important;
	}
</style>
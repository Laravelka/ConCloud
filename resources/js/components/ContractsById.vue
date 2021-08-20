<template>
	<div class="card">
		<div class="card-header">
			<b style="position: relative; top: 2px;"><i class="bi bi-files"></i> Договора</b>
			<span class="badge badge-light float-right">
				<i @click="getFiles()" class="bi bi-arrow-repeat custom-size" style="color: var(--primary)"></i>
			</span>
		</div>
		<div v-if="false" class="card-header d-flex justify-content-center" style="
			background: transparent;
		">
			<file-modal @fileUpload="onFileUpload"></file-modal>
		</div>
		<div v-if="isLoad" class="d-flex justify-content-center p-4">
			<div class="spinner-border" role="status">
				<span class="sr-only">Загрузка...</span>
			</div>
		</div>
		<div v-else-if="isError" class="d-flex justify-content-center p-4">
			<span style="color: var(--danger); padding: 4.5px">Ошибка загрузки</span>
		</div>
		<div v-else-if="arrFiles.length == 0" class="d-flex justify-content-center p-4">
			<span style="color: var(--secondary); padding: 4.5px">Пока что пусто...</span>
		</div>
		<ul v-else class="list-group list-group-flush">
			<li v-for="(item, index) in arrFiles" v-bind:key="index" class="list-group-item">
				<b>Название: </b>{{ item.name }}<br>
				<b>Контакты: </b>{{ item.contacts }}<br>
				<b>Дата конца контракта: </b>{{ item.contract_end }}<br>
				<b>Дата заключения контракта: </b>{{ item.contract_conclusion }}<br>
				<b>Дата подачи расторжения контракта: </b>{{ item.contract_termination }}<br>

				<span v-show="false" class="badge badge-light float-right">
					<i class="bi bi-x-circle custom-size" style="color: var(--danger)"></i>
				</span>
			</li>
		</ul>
	</div>
</template>

<script>
	import axios from 'axios';

	export default {
		name: 'ContractsById',
		data: () => ({
			arrFiles: [],
			isLoad: true,
			isError: false,
		}),
		methods: {
			onFileUpload() {
				this.getFiles();
			},
			getFiles() {
				this.isLoad = true;
				axios.get('/admin/users/files/getById/1').then((response) => {
					const { data } = response;
					
					console.log(data.length);

					this.arrFiles = data;
					this.isLoad = false;
				}).catch((error) => {
					let that = this;
					
					setTimeout(() => {
						that.isError = true;
						that.isLoad = false;
					}, 3000);
				});
			}
		},
		created() {
			this.getFiles();

            console.log(this.$props);
		}
	}
</script>

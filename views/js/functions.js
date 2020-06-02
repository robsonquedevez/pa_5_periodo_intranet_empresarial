$(document).ready(() => {

	const mdLoading = $('#loading');
	
	/* --------------     Derpartament        ------------------ */

	const frmRegDepartament = $('#frm-register-departament');
	const frmRegDepartamentUp = $('#frm-register-departament-update');

	function deleteDepartament(ev){
		let id = ev.target.parentElement.parentElement.dataset.id;
		let row = ev.target.parentElement.parentElement;

		$.ajax({
			url: '/register/departament/delete/'+ id,
			method: 'delete',
			dataType: 'json',
			beforeSend: function(response){
				mdLoading.modal('show');
			},
			success: function(response){
				console.log(response);

				row.remove();

				mdLoading.modal('hide');
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	}

	function updateDepartament(ev){

		let id = ev.target.parentElement.parentElement.dataset.id;
		let departamento = ev.target.parentElement.parentElement.cells[0].textContent;
		let gestor = ev.target.parentElement.parentElement.cells[1].textContent;

		$('#index').val(id);

		$('#idDepartamentoUp').val(departamento);

		$('#idGestorUp option:eq(0)').text(gestor);

		
		$('#modalUpdateDepartament').modal('show');
	}

	frmRegDepartamentUp.submit((ev) => {
		ev.preventDefault();

		let data = frmRegDepartamentUp.serialize();

		$.ajax({
			url: '/register/departament/update',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){	
				$('#modalUpdateDepartament').modal('hide');			
				mdLoading.modal('show');
			},
			success: function(response){

				if(response.status){

					$('#table-departament > tbody > tr').each(function (index) {
						
						if($(this)[0].dataset.id == response.message.id){							
							$(this)[0].children[0].textContent = response.message.departamento;
							$(this)[0].children[1].textContent = response.message.gestor;
						}
					});								

				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}					

				mdLoading.modal('hide');
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	});

	frmRegDepartament.submit((ev) => {
		ev.preventDefault();
		let data = frmRegDepartament.serialize();

		$.ajax({
			url: '/register/departament/insert',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){
				mdLoading.modal('show');
			},
			success: function(response){
				if(response.status){
					let table = $('#table-departament tbody');

					let newRow = `
						<tr data-id=${response.message.id}>
	                      	<td>${response.message.departamento}</td>
	                      	<td>${response.message.gestor}</td>
	                      	<td>
	                      		<button  class="btn far fa-trash-alt center btnDelDepartament"></button>
	                      		<button class="btn fa fa-edit center btnUpDepartament"></button>
	                      	</td>
	                    </tr>
					`;

					table.append(newRow).on('click', '.btnDelDepartament', (ev) => {deleteDepartament(ev)}).on('click', '.btnUpDepartament', (ev) => {updateDepartament(ev)});
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');				
				}

				frmRegDepartament[0].reset();
				$('#idDepartamento').focus();

				mdLoading.modal('hide');				
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	});

	$('.btnDelDepartament').click((ev) => {
		deleteDepartament(ev)
	});

	$('.btnUpDepartament').click((ev) => {
		updateDepartament(ev);
	});

	/* --------------     User      ------------------ */

	const frmRegUser = $('#frm-register-user');
	const frmRegUserUp = $('#frm-register-user-update');

	function deleteUser(ev){
		let id = ev.target.parentElement.parentElement.dataset.id;
		let row = ev.target.parentElement.parentElement;

		$.ajax({
			url: '/register/user/delete/'+ id,
			method: 'delete',
			dataType: 'json',
			beforeSend: function(response){
				mdLoading.modal('show');
			},
			success: function(response){
				console.log(response);

				row.remove();

				mdLoading.modal('hide');
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	}

	function updateUser(ev){

		let id = ev.target.parentElement.parentElement.dataset.id;
		let nome = ev.target.parentElement.parentElement.cells[0].textContent;
		let usuario = ev.target.parentElement.parentElement.cells[1].textContent;
		let departamento = ev.target.parentElement.parentElement.cells[2].textContent;
		let gestor = ev.target.parentElement.parentElement.cells[3].textContent;

		console.log(id);

		$('#idUserUp').val(id);
		$('#idNomeUp').val(nome);
		$('#idUsuarioUp').val(usuario);
		$('#idDepartamentoUp option:eq(0)').text(departamento);

		if(gestor == "Sim"){
			$('#idGestorUp option:eq(0)').prop('selected', true);
		}else{
			$('#idGestorUp option:eq(1)').prop('selected', true);
		}

		$('#modalUpdateUser').modal('show');
	}

	frmRegUser.submit((ev) => {
		ev.preventDefault();
		let data = frmRegUser.serialize();

		$.ajax({
			url: '/register/user/insert',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){
				mdLoading.modal('show');
			},
			success: function(response){
				console.log(response);

				if(response.status){

					let table = $('#table-user tbody');

					let newRow = `

						<tr data-id=${response.message.id}>
		                    <td>${response.message.nome}</td>
		                    <td>${response.message.usuario}</td>
		                    <td>${response.message.departamento}</td>
		                    <td>${response.message.gestor}</td>
		                    <td>
		                    	<button class="btn far fa-trash-alt center btnDeleteUser"></button>
		                    	<button class="btn far fa-edit center btnUpdateUser"></button>
		                    </td>
	                  	</tr>
					`;
					
					table.append(newRow).on('click', '.btnDeleteUser', (ev) => {deleteUser(ev)}).on('click', '.btnUpdateUser', (ev) => {updateUser(ev)});

					frmRegUser[0].reset();
					$('#idNome').focus();

				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}

				mdLoading.modal('hide');
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	});

	frmRegUserUp.submit((ev) => {
		ev.preventDefault();
		let data = frmRegUserUp.serialize();

		$.ajax({
			url: '/register/user/update',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){
				$('#modalUpdateUser').modal('hide');
				mdLoading.modal('show');
			},
			success: function(response){
				console.log(response);

				if (response.status) {
					$('#table-user > tbody > tr ').each(function (index) {						
						if($(this)[0].dataset.id == response.message.id){							
							$(this)[0].children[0].textContent = response.message.nome;
							$(this)[0].children[1].textContent = response.message.usuario;
							$(this)[0].children[2].textContent = response.message.departamento;
							$(this)[0].children[3].textContent = response.message.gestor;
						}
					});
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}
				
				mdLoading.modal('hide');
			},
			error: function(response){
				console.log(response);
				mdLoading.modal('hide');
			}
		});
	});

	$('.btnDeleteUser').click((ev) => {
		deleteUser(ev);
	});

	$('.btnUpdateUser').click((ev) => {
		updateUser(ev);
	});

});

	/* --------------     User      ------------------ */

	const frmRegCategory = $('#frm-register-category');

	frmRegCategory.submit((ev) => {

		ev.preventDefault();
		let data = frmRegCategory.serialize();

		$.ajax({
			url: '/register/category/insert',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){
				$('#loading').modal('show');
			},
			success: function(response){
				console.log(response);
				$('#loading').modal('hide');

				if(response.status){

					let table = $('#table-category tbody');

					let newRow = `

						<tr data-id=${response.message.id}>
		                    <td>${response.message.categoria}</td>
		                    <td>${response.message.departamento}</td>
		                    <td>
		                    	<button class="btn far fa-trash-alt center btnDelCategory"></button>
		                    	<button class="btn far fa-edit center btnUpCategory"></button>
		                    </td>
	                  	</tr>
					`;
					
					table.append(newRow).on('click', '.btnDelCategory', (ev) => {deleteUser(ev)}).on('click', '.btnUpCategory', (ev) => {updateUser(ev)});

					frmRegCategory[0].reset();
					$('#idNome').focus();

				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}

			},
			error : function(response){
				console.log(response);
				$('#loading').modal('hide');
			}
		});
	});
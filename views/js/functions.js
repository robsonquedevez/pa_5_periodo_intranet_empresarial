$(document).ready(() => {

	const mdLoading = $('#loading');
	
	/* --------------     Derpartament        ------------------ */

	const frmRegDepartament = $('#frm-register-departament');

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

		console.log(departamento, gestor, id);

		/*$.ajax({
			url: '/register/departament/update/',
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
		});*/
	}

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
				console.log(response);

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

					table.append(newRow).on('click', '.btnDelDepartament', (ev) => {deleteDepartament(ev)});
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');				
				}

				$('#idDepartamento').val("").focus();
				$('#idGestor').prop('selectedIndex',0);

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
		updateDepartament(ev)
	});

	/* --------------     User      ------------------ */

	const frmRegUser = $('#frm-register-user');

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
		                    <td><button class="btn far fa-trash-alt center btnDeleteUser"></button></td>
	                  	</tr>
					`;
					
					table.append(newRow).on('click', '.btnDeleteUser', (ev) => {deleteUser(ev)});
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

});
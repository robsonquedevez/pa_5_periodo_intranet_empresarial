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
	const frmRegCategoryUp = $('#frm-register-category-update');

	function deleteCategory(ev){
		let id = ev.target.parentElement.parentElement.dataset.id;
		let row = ev.target.parentElement.parentElement;

		$.ajax({
			url: '/register/category/delete/'+ id,
			method: 'delete',
			dataType: 'json',
			beforeSend: function(response){
				$('#loading').modal('show');
			},
			success: function(response){
				console.log(response);

				row.remove();

				$('#loading').modal('hide');
			},
			error: function(response){
				console.log(response);
				$('#loading').modal('hide');
			}
		});
	}

	function updateCategory(ev){
		let id = ev.target.parentElement.parentElement.dataset.id;
		let categoria = ev.target.parentElement.parentElement.cells[0].textContent;
		let departamento = ev.target.parentElement.parentElement.cells[1].textContent;

		$('#idCategoryDbUp').val(id);
		$('#idCategoryUp').val(categoria);
		$('#idDepartamentoUp option:eq(0)').text(departamento);

		$('#modalUpdateCategory').modal('show');
	}

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

	frmRegCategoryUp.submit((ev) => {
		ev.preventDefault();
		let data = frmRegCategoryUp.serialize();

		$.ajax({
			url: '/register/category/update',
			method: 'post',
			data: data,
			dataType: 'json',
			beforeSend: function(response){
				$('#modalUpdateCategory').modal('hide');
				$('#loading').modal('show');
			},
			success: function(response){
				console.log(response);

				if (response.status) {
					$('#table-category > tbody > tr ').each(function (index) {						
						if($(this)[0].dataset.id == response.message.id){							
							$(this)[0].children[0].textContent = response.message.categoria;
							$(this)[0].children[1].textContent = response.message.departamento;
						}
					});
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}
				
				$('#loading').modal('hide');
			},
			error: function(response){
				console.log(response);
				$('#loading').modal('hide');
			}
		});
	});

	$('.btnDelCategory').click((ev) => {
		deleteCategory(ev);
	});

	$('.btnUpCategory').click((ev) =>{
		updateCategory(ev);
	});

	/* --------------     File      ------------------ */


	$("#idFile").change((ev) => {
		$('#nameFileInput').text(ev.target.files[0].name);
	});

	$('#idDepartamentoFile').change((ev) => {
		$.ajax({
			url: '/file/include/categoria/' + ev.target.value,
			method: 'post',
			dataType: 'json',
			beforeSend: function(response){

				$('#idCategoriaFile > option').each(function(index){
					if (index != 0) {
						this.remove();
					}
				});

				$('#loading').modal('show');
			},
			success: function(response){

				$(response.message).each(function(index) {
					$('#idCategoriaFile').append(`<option value="${this.id}">${this.nome}</option>`);
				});		

				$('#idCategoriaFile').attr('disabled', false);

				$('#loading').modal('hide');
			},
			error: function(response){

			}
		});
	});

	const frmFileInclude = $('#frm-include-file');
	const frmFileUpdate = $('#frm-update-file');

	function deleteFile(ev){
		let id = ev.target.parentElement.parentElement.dataset.id;
		let row = ev.target.parentElement.parentElement;

		$('#idDeleteFile').val(id);

		$('#modalConfirmDeleteFile').modal('show');		

		$('#btnDelFileOk').click((ev) => {

			$('#modalConfirmDeleteFile').modal('hide');

			$.ajax({
				url: '/file/include/delete/'+ id,
				method: 'delete',
				dataType: 'json',
				beforeSend: function(response){
					$('#loading').modal('show');
				},
				success: function(response){
					console.log(response);

					row.remove();

					$('#loading').modal('hide');
				},
				error: function(response){
					console.log(response);
					$('#loading').modal('hide');
				}
			});
		});				
	}

	function updateFile(ev){

		let id = ev.target.parentElement.parentElement.dataset.id;
		let nome = ev.target.parentElement.parentElement.cells[0].textContent;
		let departamento = ev.target.parentElement.parentElement.cells[2].textContent;
		let categoria = ev.target.parentElement.parentElement.cells[3].textContent;

		$('#idNomeFileUp').val(nome);
		$('#idDepartamentoFileUp option:eq(0)').text(departamento);
		$('#idCategoriaFileUp option:eq(0)').text(categoria);

		

		new Promise((resolve, reject) => {
			$.ajax({
				url: '/file/include/infUpdate/' + id,
				method: 'post',
				dataType: 'json',
				success: function(response){				

					if (response.message.tipo) {
						$('#idPrivadoUp').attr('checked', false);
						$('#idPublicoUp').attr('checked', true);
					}else{
						$('#idPublicoUp').attr('checked', false);
						$('#idPrivadoUp').attr('checked', true);
					}
					$('#nameFileInputUp').text(response.message.nomeArquivo);

					resolve();
				},
				error: function(response){
					console.log(response);
					reject();
				}
			});

		}).then(() => {
			$('#modalUpdateFile').modal('show');
		}).catch(()=>{
			$('#text-response').html('Erro ao fazer alteração, tente novamente');
			$('#response').modal('show');
		});
	}

	frmFileInclude.submit((ev) => {
		ev.preventDefault();
		let data = new FormData();

		if (ev.target[3].checked) {
			$type = 'Publico'
		}else{
			$type = 'Privado'
		}
		
		data.append("nome", ev.target[0].value);
		data.append("departamento", ev.target[1].value);
		data.append("categoria", ev.target[2].value);
		data.append("tipo", $type);
		data.append("file", ev.target[5].files[0]);
		
		$.ajax({
			url: '/file/include/insert',
			type: 'post',
			data: data,
			dataType: 'json',
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			beforeSend: function(response){
				$('#loading').modal('show');
			},
			success: function(response){

				if (response.status) {
					let table = $('#table-files > tbody');

					let newRow = `
						<tr data-id="${response.message.id}">
		                    <td>${response.message.nome}</td>
		                    <td>${response.message.usuario}</td>
		                    <td>${response.message.departamento}</td>
		                    <td>${response.message.categoria}</td>
		                    <td>${response.message.tamanho}</td>
		                    <td>${response.message.data}</td>
		                    <td>
		                      <button class="btn far fa-trash-alt center btnDelFile" title="Excluir"></button>
		                      <button class="btn far fa-edit center btnUpdateFile" title="Editar"></button>
		                      <a class="btn far fa-file-pdf center" href="http://www.intranet.com.br${response.message.caminho}" title="${response.message.anexoNome}" target="_blank"></a>
		                    </td>
	                  	</tr>
					`;

					table.append(newRow).on('click', '.btnDelFile', (ev) => {deleteFile(ev)}).on('click', '.btnUpdateFile', (ev) => {updateFile(ev)});

					frmFileInclude[0].reset();
					$('#idCategoriaFile').attr('disabled', true);
					$('#nameFileInput').text('Escolher arquivo');
					$('#idNome').focus();
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}

				$('#loading').modal('hide');
			},
			error: function(response){
				$('#loading').modal('hide');
				console.log(response);
			}
		});
	});

	frmFileUpdate.submit((ev) => {
		ev.preventDefault();
		let data = new FormData();
	});

	$('.btnDelFile').click((ev) => {
		deleteFile(ev);
	});

	/* --------------     File      ------------------ */

	$('#btnChangeAvatar').click(() => {
		$('#profileAvatar').trigger('click');
	});

	$('#profileAvatar').change((ev) => {
		let id = $('#IdUserSession').val();

		let data = new FormData();

		data.append('id', id);
		data.append('file', ev.target.files[0]);

		$.ajax({
			url: '/register/user/avatar',
			type: 'post',
			data: data,
			dataType: 'json',
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			beforeSend: function(response){
				$('#loading').modal('show');
			},
			success: function(response){
				console.log(response);

				if (response.status) {
					$('#imgProfile').attr('src', "/views/img/avatar/" + response.message.avatar);
					$('#imgAvatarHeader').attr('src', "/views/img/avatar/" + response.message.avatar);
				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}

				$('#loading').modal('hide');
			},
			error: function(response){
				console.log(response);
				$('#loading').modal('hide');
			}

		});
	});

	$('.btnHistory').click((ev) => {
		let id = ev.target.parentElement.parentElement.dataset.id;

		$.ajax({
			url: '/file/private/log/' + id,
			type: 'post',
			dataType: 'json',
			beforeSend: function(response){
				$('#loading').modal('show');
			},
			success: function(response){				

				if (response.status) {			

					$('.timeline').remove();

					$(response.message).each(function(){

						if(this.tipo == 'Inserido'){
							timeLine = `
								<div class="timeline">
	                              <div class="timeline-icon"><i class="fas fa-plus-circle"></i></div>
	                              <span class="year">${this.data}</span>
	                              <div class="timeline-content">
	                                  <h5 class="title">${this.tipo}</h5>
	                                  <p class="description">
	                                      <span>${this.arquivo}</span><br>
	                                      Alterado por: </span>${this.usuario}</span>
	                                  </p>
	                              </div>
		                         </div>
							`;
							$('#timelineBody').append(timeLine);
						}else{
							timeLine = `
								<div class="timeline">
	                              <div class="timeline-icon"><i class="fas fa-edit"></i></div>
	                              <span class="year">${this.data}</span>
	                              <div class="timeline-content">
	                                  <h5 class="title">${this.tipo}</h5>
	                                  <p class="description">
	                                      <span>${this.arquivo}</span><br>
	                                      Alterado por: </span>${this.usuario}</span> 
	                                  </p>
	                              </div>
		                         </div>
							`;
							$('#timelineBody').append(timeLine);
						}
						$('#historyModal').modal('show');
					});

				}else{
					$('#text-response').html(response.message);
					$('#response').modal('show');
				}

				$('#loading').modal('hide');
			},
			error: function(response){
				console.log(response);
				$('#loading').modal('hide');
			}

		});
	});

	$('.btnUpdateFile').click((ev) => {
		updateFile(ev);
	});
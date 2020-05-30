<?php if(!class_exists('Rain\Tpl')){exit;}?>
                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Cadastro de Usuários
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Categorias-->
                      <form action="/register/user/insert" method="post" id="frm-register-user">
      
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Nome: </label>
                            <input type="text" class="form-control" id="idNome" placeholder="Nome" name="nome" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Departamento:</label>
                            <select class="custom-select" name="departamento" id="idDepartamento">
                              <option value="">Selecione</option>
                              
                              <?php $counter1=-1;  if( isset($departaments) && ( is_array($departaments) || $departaments instanceof Traversable ) && sizeof($departaments) ) foreach( $departaments as $key1 => $value1 ){ $counter1++; ?>

                              <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>

                              <?php } ?>

                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Gestor:</label>
                            <select class="custom-select" name="gestor" id="idGestor">
                              <option value="1">Sim</option>
                              <option value="0">Não</option>
                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Usuário: </label>
                            <input type="text" class="form-control" id="idUsuario" placeholder="Usuário" name="usuario" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Senha: </label>
                            <input type="password" class="form-control" id="idSenha" placeholder="Senha" name="senha" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Repetir Senha: </label>
                            <input type="password" class="form-control" id="idRepetiSenha" placeholder="Repetir Senha" name="repetirSenha" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            
                            <div class="input-group">
                              <button type="submit" class="btn btn-primary" id="idSalvarUser">Gravar Usuário</button>
                            </div>
                          </div>

                          
                        </div>
                    
                      </form> 
                      <!-- Fim Form Cadastro de Categorias -->
      
                      <!-- Inicio Tabela Departamento -->

                      <div class="form-row">
                        <div class="col-md-4 mb-3">
                          <label>Pesquise Por:</label>
                          <select class="custom-select" name="departamento" id="idDepartamento">
                            <option value="">Nome</option>
                            <option value="">Usuário</option>
                            <option value="">Departamento</option>
                          </select>
                        </div>
  
                        <div class="col-md-4 mb-3">
                          <label>Pesquise Por:</label>
                          <div class="input-group">
                            
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Busque por..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                              </button>
                            </div>
                          </div>
                        </div>
  
                      </div>


                      <br>
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table-user" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Nome</th>
                              <th>Usuário</th>
                              <th>Departamento</th>
                              <th>Gestor</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php $counter1=-1;  if( isset($users) && ( is_array($users) || $users instanceof Traversable ) && sizeof($users) ) foreach( $users as $key1 => $value1 ){ $counter1++; ?>

                              <tr data-id=<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>>
                                <td><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["usuario"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["departamento"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo formatManagerRequest($value1["gestor"]); ?></td>
                                <td>
                                  <button class="btn far fa-trash-alt center btnDeleteUser"></button>
                                  <button class="btn far fa-edit center btnUpdateUser"></button>
                                   <button class="btn far fa-key center btnUpdateUser"></button>
                                </td>
                              </tr>

                            <?php } ?>

                          </tbody>
                        </table>
                      </div>
                        
                    </div>
                  </div>
      
              </div>

      </div>
      <div class="modal fade" id="response" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body"> 
                <span id="text-response"></span>
              </div>
              <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-primary">Fechar</button>
              </div>             
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalUpdateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body"> 
                <span id="text-response"></span>
              </div>
              <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                  <button data-dismiss="modal" class="btn btn-success">Salvar</button>
              </div>             
            </div>
          </div>
        </div>
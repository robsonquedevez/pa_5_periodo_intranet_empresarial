<?php if(!class_exists('Rain\Tpl')){exit;}?>
                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Cadastro de Categorias
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Categorias-->
                      <form action="" method="post">
      
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Nome Categoria: </label>
                            <input type="text" class="form-control" id="idCategoria" placeholder="Categoria" name="categoria" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Departamento:</label>
                            <select class="custom-select" name="departamento" id="idDepartamento">
                              <option value="">Recursos Humanos</option>
                              <option value="">Tecnologia da Informação</option>
                              <option value="">Marketing</option>
                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Gravar: </label>
                            <div class="input-group">
                              <button type="button" class="btn btn-primary" id="idSalvarCat">Incluir Categoria</button>
                            </div>
                          </div>
                        </div>
                    
                      </form> 
                      <!-- Fim Form Cadastro de Categorias -->
      
                      <!-- Inicio Tabela Departamento -->
                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Categoria</th>
                              <th>Departamento</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>Rede</td>
                              <td>Tecnologia da Infomação</td>
                              <td><button class="btn far fa-trash-alt center"></button></td>
                            </tr>
                            <tr>
                              <td>2</td>
                              <td>Folha de Pagamento</td>
                              <td>Recursos Humanos</td>
                              <td><button class="btn far fa-trash-alt center"></button></td>
                            </tr>
                        </table>
                      </div>
      
      
                        
                    </div>
                  </div>
      
      
                
      
              </div>
              <!-- /.container-fluid -->

      </div>
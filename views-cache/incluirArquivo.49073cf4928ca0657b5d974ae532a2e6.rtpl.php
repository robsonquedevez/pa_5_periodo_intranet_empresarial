<?php if(!class_exists('Rain\Tpl')){exit;}?>
                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Incluir Arquivo
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Deparmento -->
                      <form action="" method="post">
      
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Selecione o arquivo: </label>
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                              <label class="custom-file-label" for="validatedCustomFile">Escolher arquivo...</label>
                              <div class="invalid-feedback">Por favor, incluir o arquivo!</div>
                            </div>                         
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Departamento:</label>
                            <select class="custom-select" name="gestor" id="idGestor">
                              <option value="">Tecnologia da Informação</option>
                              <option value="">Marketing</option>
                              <option value="">Recursos Humanos</option>
                            </select>
                          </div>

                          <div class="col-md-3 mb-3">
                            <label>Tipo: </label>
                            <div class="custom-control custom-radio">
                              <input type="radio" class="custom-control-input" id="idPublico" name="publico" required>
                              <label class="custom-control-label" for="idPublico">Público</label>
                            </div>
                            <div class="custom-control custom-radio mb-3">
                              <input type="radio" class="custom-control-input" id="idPrivado" name="privado" required>
                              <label class="custom-control-label" for="idPrivado">Privado</label>
                              <div class="invalid-feedback">Necessário selecionar se ele será público ou privado!</div>
                            </div>
                        </div>

                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Categorias:</label>
                            <select class="custom-select" name="gestor" id="idGestor">
                              <option value="">Rede</option>
                              <option value="">Infra</option>
                              <option value="">Segurança Informação</option>
                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for=""><span><i class="far fa-save"></i></span> Gravar:</label>
                            <div class="input-group">
                              <button type="button" class="btn btn-primary" id="idSalvarDpt">Incluir Arquivo</button>
                            </div>
                          </div>
                        </div>

                        
                        
                        
                    
                      </form> 
                      <!-- Fim Form Cadastro de Deparmento -->
      
                      <!-- Inicio Tabela Departamento -->
                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Nome do Arquivo:</th>
                              <th>Usuário:</th>
                              <th>Departamento:</th>
                              <th>Categoria:</th>
                              <th>Tamanho:</th>
                              <th>Data da Inclusão:</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>1</td>
                              <td>Gestão de Impressoras.pdf</td>
                              <td>Diego Broetto</td>
                              <td>Tecnologia da Informação</td>
                              <td>Infra</td>
                              <td>35mb</td>
                              <td>01/01/2020 15:30</td>
                              <td><button class="btn far fa-trash-alt center"></button></td>
                            </tr>
                        </table>
                      </div>
      
      
                        
                    </div>
                  </div>
 
              </div>
              <!-- /.container-fluid -->
      </div>
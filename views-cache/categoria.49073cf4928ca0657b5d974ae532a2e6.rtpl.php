<?php if(!class_exists('Rain\Tpl')){exit;}?>
                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Cadastro de Categorias
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Categorias-->
                      <form id="frm-register-category">
      
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Nome Categoria: </label>
                            <input type="text" class="form-control" id="idCategoria" placeholder="Categoria" name="categoria" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Departamento:</label>
                            <select class="custom-select" name="departamento" id="idDepartamento">
                              <option value="0">Selecione</option>

                              <?php $counter1=-1;  if( isset($departament) && ( is_array($departament) || $departament instanceof Traversable ) && sizeof($departament) ) foreach( $departament as $key1 => $value1 ){ $counter1++; ?>

                                <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>

                              <?php } ?>

                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Gravar: </label>
                            <div class="input-group">
                              <button type="submit" class="btn btn-primary" id="idSalvarCat">Incluir Categoria</button>                              
                            </div>
                          </div>
                        </div>
                    
                      </form> 
                      <!-- Fim Form Cadastro de Categorias -->
      
                      <!-- Inicio Tabela Departamento -->
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table-category" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Categoria</th>
                              <th>Departamento</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php $counter1=-1;  if( isset($category) && ( is_array($category) || $category instanceof Traversable ) && sizeof($category) ) foreach( $category as $key1 => $value1 ){ $counter1++; ?>

                               <tr data-id="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                  <td><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                  <td><?php echo htmlspecialchars( $value1["departamento"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                  <td>
                                    <button class="btn far fa-trash-alt center btnDelCategory"></button>
                                    <button class="btn far fa-edit center btnUpCategory"></button>
                                  </td>
                                </tr>

                            <?php } ?>

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

             <div class="modal fade" id="modalUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <form id="frm-register-category-update">
                    <div class="modal-body"> 
                      <div class="form-group form-row">
                        <input type="hidden" name="idCategoryDbUp" id="idCategoryDbUp" value="">
                        <label>Categoria</label>
                        <input type="text" name="categoria" class="form-control" id="idCategoryUp">
                        <label>Departamento</label>
                        <select class="custom-select" name="departamento" id="idDepartamentoUp">
                              <option value="0"></option>

                              <?php $counter1=-1;  if( isset($departament) && ( is_array($departament) || $departament instanceof Traversable ) && sizeof($departament) ) foreach( $departament as $key1 => $value1 ){ $counter1++; ?>

                                <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>

                              <?php } ?>

                            </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                  </form>             
                </div>
              </div>
            </div>
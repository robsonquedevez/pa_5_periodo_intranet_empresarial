<?php if(!class_exists('Rain\Tpl')){exit;}?>                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Cadastro de Departamento
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Deparmento -->
                      <form action="/register/departament/insert" method="post" id="frm-register-departament">
      
                        <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label>Departamento</label>
                            <input type="text" class="form-control" id="idDepartamento" placeholder="Departamento" name="departamento" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Gestor:</label>
                            <select class="custom-select" name="gestor" id="idGestor">
                              <option value="0">Selecione</option>

                              <?php $counter1=-1;  if( isset($managers) && ( is_array($managers) || $managers instanceof Traversable ) && sizeof($managers) ) foreach( $managers as $key1 => $value1 ){ $counter1++; ?>

                              <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>

                              <?php } ?>

                            </select>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label>Gravar: </label>
                            <div class="input-group">
                              <button type="submit" class="btn btn-primary" id="idSalvarDpt">Salvar Departamento</button>
                            </div>
                          </div>
                        </div>
                    
                      </form> 
                      <!-- Fim Form Cadastro de Deparmento -->
      
                      <!-- Inicio Tabela Departamento -->
                      <div class="table-responsive">
                        <table class="table table-bordered" id="table-departament" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th>Departamento</th>
                              <th>Gestor</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php $counter1=-1;  if( isset($departaments) && ( is_array($departaments) || $departaments instanceof Traversable ) && sizeof($departaments) ) foreach( $departaments as $key1 => $value1 ){ $counter1++; ?>

                            <tr data-id=<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>>
                              <td><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                              <td><?php echo htmlspecialchars( $value1["gestor"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                              <td>
                                <button class="btn far fa-trash-alt center btnDelDepartament"></button>
                                <button class="btn fa fa-edit center btnUpDepartament"></button>
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

        <div class="modal fade" id="modalUpdateDepartament" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="frm-register-departament-update">
                <div class="modal-body"> 
                  <div class="form-group form-row">
                    <input type="hidden" name="idDepartamento" id="index" value="">
                    <label>Departamento</label>
                    <input type="text" name="departamento" class="form-control" id="idDepartamentoUp">
                    <label>Gestor</label>
                    <select name="gestor" class="custom-select" id="idGestorUp"> 
                      <option value="-1"></option>
                      <option value="0">Nenhum</option>
                      <?php $counter1=-1;  if( isset($managers) && ( is_array($managers) || $managers instanceof Traversable ) && sizeof($managers) ) foreach( $managers as $key1 => $value1 ){ $counter1++; ?>

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

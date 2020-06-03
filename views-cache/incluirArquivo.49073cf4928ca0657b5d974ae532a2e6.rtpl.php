<?php if(!class_exists('Rain\Tpl')){exit;}?>
                <div class="container-fluid">


                  <div class="card mb-4">
                    <div class="card-header">
                      Incluir Arquivo
                    </div>
                    <div class="card-body">
                      
                      <!-- Inicio Form Cadastro de Deparmento -->
                      <form id="frm-include-file" enctype="multipart/form-data" method="post">

                        <div class="form-row">

                          <div class="col-md-4 mb-3">
                            <div class="form-group">
                              <label>Nome</label>
                              <input type="text" name="nome" id="idNome" class="form-control" required="">
                            </div>
                          </div>

                          <div class="col-md-4 mb-3">
                            <div class="form-group">
                              <label>Departamento:</label>
                              <select class="custom-select" name="departamento" id="idDepartamento" required="">
                                <option value="-1">Selecione</option>
                                <?php $counter1=-1;  if( isset($departamento) && ( is_array($departamento) || $departamento instanceof Traversable ) && sizeof($departamento) ) foreach( $departamento as $key1 => $value1 ){ $counter1++; ?>                                    
                                <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4 mb-3">
                            <div class="form-group">
                              <label>Categorias:</label>
                              <select class="custom-select" name="categoria" id="idCategoria" required="">
                                <option value="-1">Selecione</option>
                                <?php $counter1=-1;  if( isset($categoria) && ( is_array($categoria) || $categoria instanceof Traversable ) && sizeof($categoria) ) foreach( $categoria as $key1 => $value1 ){ $counter1++; ?>                                  
                                <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="form-row">

                          <div class="col-md-1 col-sm-4">
                            <label>Tipo: </label>
                          </div>
                                              
                          <div class="custom-radio col-md-1 col-sm-4">
                            <input type="radio" class="custom-control-input" id="idPublico" name="tipo" checked="">
                            <label class="custom-control-label" for="idPublico">Público</label>
                          </div>
                          <div class="custom-radio col-md-1 col-sm-4">                
                            <input type="radio" class="custom-control-input" id="idPrivado" name="tipo" >
                            <label class="custom-control-label" for="idPrivado">Privado</label>
                          </div>                          

                          <div class="col-md-7 mb-2">
                            <div class="custom-file">
                              <input type="file" name="fileUpload" class="custom-file-input" accept=".doc, .docx, .pdf" id="idFile" required="">
                              <label class="custom-file-label" for="idFile" id="nameFileInput">Escolher arquivo</label>
                            </div>
                          </div>
  
                          <div class="col-md-2 mb-2">
                            <div class="input-group ">
                              <button type="submit" class="btn btn-primary" id="idSalvarDpt">Incluir Arquivo</button>
                            </div>
                          </div>

                        </div>

                      </form> 
                      <!-- Fim Form Cadastro de Deparmento -->
      
                      <!-- Inicio Tabela Departamento -->
                      <div class="table-responsive my-5">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
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

                            <?php $counter1=-1;  if( isset($documento) && ( is_array($documento) || $documento instanceof Traversable ) && sizeof($documento) ) foreach( $documento as $key1 => $value1 ){ $counter1++; ?>

                              <tr data-id="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                                <td><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["usuario"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["departamento"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["categoria"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo htmlspecialchars( $value1["tamanho"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                                <td><?php echo formatDate($value1["dtHrEnvio"]); ?></td>
                                <td>
                                  <button class="btn far fa-trash-alt center"></button>
                                  <button class="btn far fa-edit center"></button>
                                  <button class="btn far fa-clock center"></button>
                                </td>
                              </tr>

                            <?php } ?>
                            
                        </table>
                      </div>
                    </div>
                  </div> 
              </div>
      </div>

      
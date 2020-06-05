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
                              <select class="custom-select" name="departamento" id="idDepartamentoFile" required="">
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
                              <select class="custom-select" name="categoria" id="idCategoriaFile" required="" disabled="">
                                <option value="-1">Selecione</option>                                
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
                        <table class="table table-bordered" id="table-files" width="100%" cellspacing="0">
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
                                <td><?php echo formatByteToKb($value1["tamanho"]); ?></td>
                                <td><?php echo formatDate($value1["dtHrEnvio"]); ?></td>
                                <td>
                                  <button class="btn far fa-trash-alt center btnDelFile" title="Excluir"></button>
                                  <button class="btn far fa-edit center btnUpdateFile" title="Editar"></button>
                                  <a class="btn far fa-file-pdf center" href="http://www.intranet.com.br<?php echo htmlspecialchars( $value1["caminho"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" title="<?php echo htmlspecialchars( $value1["nomeArquivo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" target="_blank"></a>
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

         <div class="modal fade" id="modalConfirmDeleteFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="card-body">
                Deseja realmente excluir?
                <input type="hidden" id="idDeleteFile">
              </div>             
              <div class="card-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                <button type="button" class="btn btn-secundary" id='btnDelFileOk'>Excluir</button>
              </div>
            </div>
          </div>
        </div>

         <div class="modal fade" id="modalUpdateFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="frm-update-file">
                
                <div class="card-body">
                  <input type="hidden" id="idUpdateFile">

                  <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" id="idNomeFileUp">

                    <label>Departamento</label>
                    <select class="custom-select" name="departamento" id="idDepartamentoFileUp">
                      <option value="-1">Selecione</option>
                      <?php $counter1=-1;  if( isset($departamento) && ( is_array($departamento) || $departamento instanceof Traversable ) && sizeof($departamento) ) foreach( $departamento as $key1 => $value1 ){ $counter1++; ?>                                    
                      <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                      <?php } ?>
                    </select>

                      <label>Categorias:</label>
                      <select class="custom-select" name="categoria" id="idCategoriaFileUp">
                        <option value="-1">Selecione</option>                                
                      </select>
                      <hr>
                      <label class="mr-4">Tipo</label>
                      <div class="custom-radio col-sm-6 d-inline mt-4 mr-2">
                        <input type="radio" class="custom-control-input" id="idPublicoUp" name="tipo">
                        <label class="custom-control-label" for="idPublico">Público</label>
                      </div>
                      <div class="custom-radio col-sm-6 d-inline mt-4">                
                        <input type="radio" class="custom-control-input" id="idPrivadoUp" name="tipo" >
                        <label class="custom-control-label" for="idPrivado">Privado</label>
                      </div>
                      <hr>
                      <div class="col-md mb-2">
                        <div class="custom-file">
                          <input type="file" name="fileUpload" class="custom-file-input" accept=".doc, .docx, .pdf" id="idFile" required="">
                          <label class="custom-file-label" for="idFile" id="nameFileInputUp">Escolher arquivo</label>
                        </div>
                      </div>

                </div>             
                <div class="card-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-danger">Cancelar</button>
                  <button type="submit" class="btn btn-success" >Salvar</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>

      
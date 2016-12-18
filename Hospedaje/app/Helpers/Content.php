<?php namespace app\Helpers;
	
	use app\Model\Clase\Usuario as Usuario;
	use app\Core\HelpersView as Helper;

	class Content 
	{

		

		public function modal_html(Usuario $usuario, Helper $helper)
		{
			return '<form action="'.$helper->url('usuario', 'update').'" method="post" name="usuario">
            <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="exampleModalLabel">Modificar Usuario</h3>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="recipient-name" class="control-label">DNI Usuario:</label>
                        <input type="text" value="'.$usuario->getIdUsuario().'" class="form-control" name="dni">
                      </div>

                      <div class="form-group">
                        <label for="text" class="control-label">Nombre:</label>
                        <input type="text" value="'.$usuario->getNombre().'" class="form-control" name="nombre">
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="control-label">Apellido:</label>
                        <input type="text" value="'.$usuario->getApellido().'" class="form-control" name="apellido">
                      </div>

                      <div class="form-group">
                        <label for="message-text" class="control-label">Email:</label>
                        <input type="text" value="'.$usuario->getEmail().'" class="form-control" name="email">
                      </div>

                      <div class="form-group">
                        <label for="recipient-name" class="control-label">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasena">
                      </div>
                      <div class="form-group">
                        <label for="message-text" class="control-label">tipo:</label>
                        <select class="form-control" name="tipo">
                          <option value="normal">Normal</option>
                          <option value="admin">Administrador</option>
                        </select> 

                      </div>
                      <div class="form-group">
                        <label for="message-text" class="control-label">Estado:</label>
                        <select class="form-control" name="estado">
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select> 
                      </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <input class="btn btn-primary" type="submit" value="GUARDAR">
                  </div>
                </div>
              </div>
            </div>
          </form>';
		}
	}

/*		FIN CLASS CONTENT HELPER		*/
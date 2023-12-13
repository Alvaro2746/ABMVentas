<?php

include_once "config.php";
include_once "entidades/usuario.php";

$pg = "Edición de usuario";

$usuario = new Usuario();
$usuario->cargarFormulario($_REQUEST);


if ($_POST) {
    
    $usuarioAux = new Usuario();
    $usuarioAux2 = new Usuario();
    $usuarioAux->obtenerPorUsuario($usuario->usuario);
    $usuarioAux2->obtenerPorCorreo($usuario->correo);

   

    if (isset($_POST["btnGuardar"])) {
        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            //Actualizo un usuario existente

            $usuarioGet = new Usuario();
            $usuarioGet->idusuario=$_GET["id"];
            $usuarioGet->obtenerPorId();


                    // $productoaux->imagen = ;
                                        
                        if ($_FILES["perfil"]["name"]){
                            // borramos imagen 
                            
                                    //se elimina imagen previa
                                    if($usuarioGet->imagen != "no_perfil.png")
                                    {
                                        
               
                                        unlink("foto_perfil/".$usuarioGet->imagen);

                                    }
                                    
           
        
                        //   se carga la imagen y remplazamos
                      $nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //se asigna nombre aleatorio
                      $file = $nombreAleatorio . $_FILES["perfil"]["name"];
                      $url_temp = $_FILES["perfil"]["tmp_name"];
                      $url_insert = dirname(__FILE__) . "/foto_perfil";
                      $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;
                      if (!file_exists($url_insert)) {
                          mkdir($url_insert, 0777, true);
                      };
                      if (move_uploaded_file($url_temp, $url_target)) {
                          echo "El perfil " . htmlspecialchars(basename($file)) . " ha sido cargado con éxito.";
                  
                      } else {
                          echo "Ha habido un error al cargar tu perfil.";
                      }
                      
                      
                    }else{
                        $file=$usuarioGet->imagen;
                    }
        


            if($_POST["txtUsuario"] == $usuarioAux->usuario && $_POST["txtUsuario"] != $usuarioGet->usuario){
                //el usuario existe
                $msgcrear="el usuario ya existe";
                $msgaux=1;

            } elseif($_POST["txtCorreo"] == $usuarioAux2->correo && $_POST["txtCorreo"] != $usuarioGet->correo) {
                //el Correo existe
                
                $msgcrear="Correo Electronico ya esta asosiado a otro usuario";
                $msgaux=2;
            }else{

            $usuario->imagen=$file;
            $usuario->actualizar();
            $_SESSION["msgmodi"]="Usuario modificado con exito";
        $_SESSION["msgmodiaux"]=1;

        header("Location: usuario-listado.php");
            }

        } else {            
            //Es nuevo


            if ($_FILES["perfil"]["name"]){
                        //se elimina imagen previa
                        if($usuarioGet->imagen != "no_perfil.png")
                        {
                            unlink("foto_perfil/".$usuarioGet->imagen);
                        }
            //   se carga la imagen y remplazamos
          $nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //se asigna nombre aleatorio
          $file = $nombreAleatorio . $_FILES["perfil"]["name"];
          $url_temp = $_FILES["perfil"]["tmp_name"];
          $url_insert = dirname(__FILE__) . "/foto_perfil";
          $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;
          if (!file_exists($url_insert)) {
              mkdir($url_insert, 0777, true);
          };
          if (move_uploaded_file($url_temp, $url_target)) {
              echo "El perfil " . htmlspecialchars(basename($file)) . " ha sido cargado con éxito.";
          } else {
              echo "Ha habido un error al cargar tu perfil.";
          }
          }else{
            $file="no_perfil.png";
        }
    

            if($_POST["txtUsuario"] == $usuarioAux->usuario){
                //el usuario existe
                $msgcrear="el usuario ya existe";
                $msgaux=1;

            } elseif($_POST["txtCorreo"] == $usuarioAux2->correo) {
                //el Correo existe
                
                $msgcrear="Correo Electronico ya esta asosiado a otro usuario";
                $msgaux=2;
            }else{
             //el usuario NO existe
            $usuario->imagen=$file;
            $usuario->insertar();
            $_SESSION["msgmodi"]="Usuario agregado con exito";
        $_SESSION["msgmodiaux"]=2;

        header("Location: usuario-listado.php");
    
        }
    }
    } 
    
    if (isset($_POST["btnBorrar"])) {

        if (isset($_GET["id"]) && $_GET["id"] > 0) {
            //Actualizo un usuario existente

            $usuarioGet = new Usuario();
            $usuarioGet->idusuario=$_GET["id"];
            $usuarioGet->obtenerPorId();

        if ($usuarioGet->idusuario == $_SESSION["id"]){


            if($usuarioGet->imagen != "no_perfil.png")
            {
                unlink("foto_perfil/".$usuarioGet->imagen);
            }
            $usuario->eliminar();
            session_destroy();
            header("Location: login.php");          
        }else{

            if($usuarioGet->imagen != "no_perfil.png")
            {
                unlink("foto_perfil/".$usuarioGet->imagen);
            }
            $usuario->eliminar();
            $_SESSION["msgmodi"]="Usuario eliminado con exito";
            $_SESSION["msgmodiaux"]=3;
    
            header("Location: usuario-listado.php");    
        }
    }else{
        $_SESSION["msgmodi"]="Usuario no existe";
        $_SESSION["msgmodiaux"]=3;

        header("Location: usuario-listado.php");    

    }
}

}

if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $usuario->obtenerPorId();
}



include_once "header.php";
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Usuario</h1>
    <div class="row">
        <div class="col-12 mb-3">
            <a href="usuario-listado.php" class="btn btn-primary mr-2">Listado</a>
            <a href="usuario-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
            <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
            <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
        </div>
    </div>

    <?php  if (isset($msgcrear)){ ?>
    <div class="alert alert-danger col-<?php echo $msgaux==1? "2": "5"; ?> " role="alert">
        <?php echo "$msgcrear"; ?>
    </div>
    <?php } ?>


    <div class="row">
        <div class="col-6 form-group">
            <label for="txtUsuario">Usuario:</label>
            <input type="text" required class="form-control" name="txtUsuario" id="txtUsuario"
                value="<?php echo $usuario->usuario ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtCuit">Nombre:</label>
            <input type="text" required class="form-control" name="txtNombre" id="txtNombre"
                value="<?php echo $usuario->nombre ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtCuit">Apellido:</label>
            <input type="text" required class="form-control" name="txtApellido" id="txtApellido"
                value="<?php echo $usuario->apellido ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtCorreo">Correo:</label>
            <input type="email" class="form-control" name="txtCorreo" id="txtCorreo" required
                value="<?php echo $usuario->correo ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtCorreo">Clave:</label>
            <input type="password" class="form-control" name="txtClave" id="txtClave" value="">
            <small>Completar únicamente para cambiar la clave</small>
        </div>
        <div class="col-6 form-group">
            <label for="perfil">foto de perfil:</label>
            <input type="file" class="form-control-file" name="perfil" id="perfil">
            <img src="foto_perfil/<?php echo $usuario->imagen; ?>" class="img-thumbnail">
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "footer.php";?>
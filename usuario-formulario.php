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


            
            if($_POST["txtUsuario"] == $usuarioAux->usuario && $_POST["txtUsuario"] != $usuarioGet->usuario){
                //el usuario existe
                $msgcrear="el usuario ya existe";
                $msgaux=1;

            } elseif($_POST["txtCorreo"] == $usuarioAux2->correo && $_POST["txtCorreo"] != $usuarioGet->correo) {
                //el Correo existe
                
                $msgcrear="Correo Electronico ya esta asosiado a otro usuario";
                $msgaux=2;
            }else{


            $usuario->actualizar();
            $_SESSION["msgmodi"]="Usuario modificado con exito";
        $_SESSION["msgmodiaux"]=1;

        header("Location: usuario-listado.php");
            }

        } else {            
            //Es nuevo
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
             
            $usuario->insertar();
            $_SESSION["msgmodi"]="Usuario agregado con exito";
        $_SESSION["msgmodiaux"]=2;

        header("Location: usuario-listado.php");
    
        }
    }
    } else if (isset($_POST["btnBorrar"])) {
        $usuario->eliminar();
        $_SESSION["msgmodi"]="Usuario eliminado con exito";
        $_SESSION["msgmodiaux"]=3;

        header("Location: usuario-listado.php");
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
        

    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "footer.php";?>
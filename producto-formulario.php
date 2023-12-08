<?php

include_once "config.php";
include_once "entidades/producto.php";
include_once "entidades/tipoproducto.php";

$pg = "Edición de producto";

$tipoProducto = new Tipoproducto();
$aTipoProductos = $tipoProducto->obtenerTodos();

$producto = new Producto();
$productoaux = new Producto();
$producto->cargarFormulario($_REQUEST);
$productoaux->cargarFormulario($_REQUEST);


if($_POST){

    if(isset($_POST["btnGuardar"])){
        if(isset($_GET["id"]) && $_GET["id"] > 0){
            $productoaux->obtenerPorId();
            // $productoaux->imagen = ;
                                
                if ($_FILES["archivo"]["name"]){
                    // borramos imagen 
                 
                    
                            //se elimina imagen previa
                            if($productoaux->imagen == "no_photo.png")
                            {
                                
                            }
                            else
                            {   

                                
                                unlink("img/".$productoaux->imagen);
                            }   

                //   se carga la imagen y remplazamos
              $nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //se asigna nombre aleatorio
              $file = $nombreAleatorio . $_FILES["archivo"]["name"];
              $url_temp = $_FILES["archivo"]["tmp_name"];
              $url_insert = dirname(__FILE__) . "/img";
              $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;
              if (!file_exists($url_insert)) {
                  mkdir($url_insert, 0777, true);
              };
              if (move_uploaded_file($url_temp, $url_target)) {
                  echo "El archivo " . htmlspecialchars(basename($file)) . " ha sido cargado con éxito.";
          
              } else {
                  echo "Ha habido un error al cargar tu archivo.";
              }
              
              
            }else{
                $file=$productoaux->imagen;
            }

            
            //Actualizo un  registro existente
            
            $producto->imagen = $file;
            $producto->actualizar();

              header("Location: producto-listado.php?msg=modificado");

        } else {
            //Es nuevo

            //   se carga la imagen
            if ($_FILES["archivo"]["name"]){

            $nombreAleatorio = date("Ymdhmsi") . rand(1000, 2000); //se asigna nombre aleatorio
            $file = $nombreAleatorio . $_FILES["archivo"]["name"];
            $url_temp = $_FILES["archivo"]["tmp_name"];
            $url_insert = dirname(__FILE__) . "/img";
            $url_target = str_replace('\\', '/', $url_insert) . '/' . $file;
            if (!file_exists($url_insert)) {
                mkdir($url_insert, 0777, true);
            };
            if (move_uploaded_file($url_temp, $url_target)) {
                echo "El archivo " . htmlspecialchars(basename($file)) . " ha sido cargado con éxito.";
        
            } else {
                echo "Ha habido un error al cargar tu archivo.";
            }
          //se agrego un  registro existente
        }else{
          $producto->imagen = "no_photo.png";
        }
        $producto->insertar();
        header("Location: producto-listado.php?msg=ingresado");

        }
    } else if(isset($_POST["btnBorrar"])){
        $productoaux->obtenerPorId();

        
        if ($productoaux->imagen){
         
            if($productoaux->imagen == "no_photo.png")
            {
                
            }
            else
            {   
                unlink("img/".$productoaux->imagen);
            }         }
        
        $producto->eliminar();
        
        header("Location: producto-listado.php?msg=eliminado");
    }
} else if(isset($_REQUEST["id"])){
    $producto->obtenerPorId();

}

include_once "header.php";
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Productos</h1>
    <div class="row">
        <div class="col-12 mb-3">
            <a href="producto-listado.php" class="btn btn-primary mr-2">Listado</a>
            <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
            <button type="submit" class="btn btn-success mr-2" id="btnGuardar" name="btnGuardar">Guardar</button>
            <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar">Borrar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-6 form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" required="" class="form-control" name="txtNombre" id="txtNombre"
                value="<?php echo $producto->nombre; ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtNombre">Tipo de producto:</label>
            <select name="lstTipoProducto" id="lstTipoProducto" class="form-control selectpicker"
                data-live-search="true" required>
                <option value="" disabled selected>Seleccionar</option>
                <?php foreach($aTipoProductos as $tipo): ?>
                <?php if($producto->fk_idtipoproducto ==  $tipo->idtipoproducto): ?>
                <option value="<?php echo $tipo->idtipoproducto ?>" selected><?php echo $tipo->nombre?></option>
                <?php else: ?>
                <option value="<?php echo $tipo->idtipoproducto ?>"><?php echo $tipo->nombre?></option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-6 form-group">
            <label for="txtCantidad">Cantidad:</label>
            <input type="number" required="" class="form-control" name="txtCantidad" id="txtCantidad"
                value="<?php echo $producto->cantidad; ?>">
        </div>
        <div class="col-6 form-group">
            <label for="txtPrecio">Precio:</label>
            <input type="text" class="form-control" name="txtPrecio" id="txtPrecio"
                value="<?php echo $producto->precio; ?>">
        </div>
        <div class="col-12 form-group">
            <label for="txtCorreo">Descripción:</label>
            <textarea type="text" name="txtDescripcion"
                id="txtDescripcion"><?php echo $producto->descripcion; ?></textarea>
        </div>
        <div class="col-6 form-group">
            <label for="archivo">Imagen:</label>
            <input type="file" class="form-control-file" name="archivo" id="archivo">
            <img src="img/<?php echo $producto->imagen; ?>" class="img-thumbnail">
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
ClassicEditor
    .create(document.querySelector('#txtDescripcion'))
    .catch(error => {
        console.error(error);
    });
</script>
<?php include_once "footer.php";?>
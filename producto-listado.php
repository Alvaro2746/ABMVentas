<?php

include_once "config.php";
include_once "entidades/producto.php";
$pg = "Listado de productos";

$producto = new Producto();
$aProductos = $producto->obtenerTodos();

if(isset($_GET["msg"]))

{
  if($_GET["msg"]=="ingresado"){
    $msg["texto"] = "Ingresado correctamente";
    $msg["codigo"] = "alert-primary";
  }elseif($_GET["msg"]=="modificado"){
    $msg["texto"] = "Modificado correctamente";
    $msg["codigo"] = "alert-success";
  }elseif($_GET["msg"]=="eliminado"){
    $msg["texto"] = "Eliminado correctamente";
    $msg["codigo"] = "alert-warning";
  }
}




include_once("header.php"); 
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Listado de productos</h1>
          <div class="row">
                <div class="col-12 mb-3">
                    <a href="producto-formulario.php" class="btn btn-primary mr-2">Nuevo</a>
                </div>
            </div>
            <div class="col-12">
                    <?php if(isset($msg)){ ?>
                    <div class="alert <?php echo $msg["codigo"]; ?>" role="alert">
                        <?php echo $msg["texto"]; ?>
                    </div>
                </div>
                <?php } ?>
          <table class="table table-hover border">
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($aProductos as $producto): ?>
              <tr>
                  <td><img src="img/<?php echo $producto->imagen; ?>" class="img-thumbnail"></td>
                  <td><?php echo $producto->nombre; ?></td>
                  <td><?php echo $producto->cantidad; ?></td>
                  <td>$ <?php echo number_format($producto->precio, 2, ",", "."); ?></td>
                  <td style="width: 110px;">
                      <a href="producto-formulario.php?id=<?php echo $producto->idproducto; ?>"><i class="fas fa-search"></i></a>   
                  </td>
              </tr>
            <?php endforeach; ?>
          </table>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php include_once("footer.php"); ?>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Tiendita Doña Juana</title>

    <!-- Bootstrap 5 desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="estilo_caso_practico3.css">
</head>

<body class="bg-light">
    <div class="container py-4">
        <!-- Botones superiores -->
        <div class="d-flex justify-content-end mb-3">
            <form action="administrar_caso_practico3.php" method="post" class="me-2">
                <button type="submit" name="administrar_usuario" class="btn btn-primary">Administrar usuario</button>
            </form>
            <form action="logout_caso_practico3.php" method="post">
                <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>

        <h1 class="text-center mb-4">Tiendita Doña Juana</h1>

        <!-- Formulario de productos -->
        <form method="POST" class="text-center mb-5">
            <div class="mb-3">
                <label class="form-label">ID Producto (solo para actualizar/eliminar/elim. cantidad):</label>
                <input type="number" name="id_producto" class="form-control w-50 mx-auto">
            </div>

            <div class="mb-3">
                <label class="form-label">Producto:</label>
                <input type="text" name="producto" required class="form-control w-50 mx-auto">
            </div>

            <!--Campo nuevo: Descripción -->
            <div class="mb-3">
                <label class="form-label">Descripción breve:</label>
                <input type="text" name="descripcion" maxlength="100" required class="form-control w-50 mx-auto">
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad:</label>
                <input type="number" name="cantidad" required class="form-control w-50 mx-auto">
            </div>

            <button type="submit" name="accion" value="crear" class="btn btn-success me-2">Crear</button>
            <button type="submit" name="accion" value="actualizar" class="btn btn-warning me-2">Actualizar</button>
            <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
        </form>

<?php
$server = "localhost";
$base   = "tienda";
$usr    = "root";
$pass   = "12345";
require("lib_caso_practico3.php");

// función para crear un registro
if (isset($_POST['accion']) && $_POST['accion'] == 'crear') {
    $producto = $_POST['producto'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $query = "INSERT INTO productos (producto, descripcion, cantidad) VALUES ('$producto', '$descripcion', $cantidad)";
    $res = ejecutar($query, $server, $base, $usr, $pass);
    if ($res){
        echo"<p class='text-center text-success'>Producto agregado correctamente.</p>";    
    }else{
        echo"<p class='text-center text-danger'>Error al insertar.</p>";
    }
}

// función para actualizar
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    if (!empty($_POST['id_producto'])) {
        $id = $_POST['id_producto'];
        $producto = $_POST['producto'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];

        $query = "UPDATE productos SET producto='$producto', descripcion='$descripcion', cantidad=$cantidad WHERE id_producto=$id";
        $res = ejecutar($query, $server, $base, $usr, $pass);
        if ($res){
            echo"<p class='text-center text-success'>Producto actualizado correctamente.</p>";
        }else{
            echo"<p class='text-center text-danger'>Error al actualizar.</p>";
        }
    } else {
        echo "<p class='text-center text-danger'>Debes especificar un ID de producto para actualizar.</p>";
    }
}

// función para eliminar
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    if (!empty($_POST['id_producto'])) {
        $id = $_POST['id_producto'];
        $query = "DELETE FROM productos WHERE id_producto=$id";
        $res = ejecutar($query, $server, $base, $usr, $pass);
        if ($res) {
            echo "<p class='text-center text-success'>Producto eliminado correctamente.</p>";
        } else {
            echo "<p class='text-center text-danger'>Error al eliminar.</p>";
        }
    } else {
        echo "<p class='text-center text-danger'>Debes especificar un ID de producto para eliminar.</p>";
    }
}

// mostrar datos
$query = "SELECT * FROM productos";
$resultados = seleccionar($query, $server, $base, $usr, $pass);

echo "<h3 class='text-center mt-4'>Lista de productos</h3>";
echo "<div class='table-responsive w-75 mx-auto'>";
echo "<table class='table table-striped table-bordered text-center'>";
echo "<thead class='table-dark'><tr><th>ID Producto</th><th>Producto</th><th>Descripción</th><th>Cantidad</th></tr></thead><tbody>";

if ($resultados) {
    foreach ($resultados as $fila) {
        echo "<tr>
                <td>$fila[0]</td>
                <td>$fila[1]</td>
                <td>$fila[2]</td>
                <td>$fila[3]</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No hay productos disponibles.</td></tr>";
}
echo "</tbody></table></div>";
?>
    </div>
</body>
</html>

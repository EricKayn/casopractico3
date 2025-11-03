<html>
<head>
    <meta charset="UTF-8" />
    <style>
        body{
            background-color: #e2d1d1ff;
        }
        table{
            background-color: #87a0ebff;
            border: 3px solid black;
        }
        th, td {
            padding: 8px;
            color: white;
            font-family: sans-serif ; 
        }
        h1{
            font-family:Arial, Helvetica, sans-serif;
        }
        input{
            width: 212px;
            border: 2px solid black;    
        }
    </style>
</head>
<body>
<h2>CRUD de Productos</h2>
<form method="POST">
    <label>ID Producto (solo para actualizar/eliminar/elim. cantidad):</label><br>
    <input type="number" name="id_producto"><br><br>

    <label>Producto:</label><br>
    <input type="text" name="producto" required><br><br>

    <label>Cantidad:</label><br>
    <input type="number" name="cantidad" required><br><br>

    <button type="submit" name="accion" value="crear">Crear</button>
    <button type="submit" name="accion" value="actualizar">Actualizar</button>
    <button type="submit" name="accion" value="eliminar">Eliminar</button>
</form>

<?php
$server = "127.0.0.1:3306";
$base   = "tienda";
$usr    = "root";
$pass   = "admin";
require("lib_caso_practico3.php");

// Verificar conexión general antes de hacer cualquier operación
$conexion = mysqli_connect($server, $usr, $pass, $base);
if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Función ejecutora de consultas con manejo de errores
function ejecutar($query, $server, $base, $usr, $pass) {
    $conn = mysqli_connect($server, $usr, $pass, $base);
    if (!$conn) {
        die("Error de conexión en ejecutar(): " . mysqli_connect_error());
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
        echo "Error en la consulta: " . mysqli_error($conn) . "<br>";
        return false;
    }
    return true;
}

// Función para seleccionar datos con manejo de errores
function seleccionar($query, $server, $base, $usr, $pass) {
    $conn = mysqli_connect($server, $usr, $pass, $base);
    if (!$conn) {
        die("Error de conexión en seleccionar(): " . mysqli_connect_error());
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
        echo "Error en la consulta: " . mysqli_error($conn) . "<br>";
        return false;
    }
    $datos = [];
    while ($fila = mysqli_fetch_row($res)) {
        $datos[] = $fila;
    }
    return $datos;
}

// Crear producto
if (isset($_POST['accion']) && $_POST['accion'] == 'crear') {
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $query = "INSERT INTO productos (producto, cantidad) VALUES ('$producto', $cantidad)";
    $res = ejecutar($query, $server, $base, $usr, $pass);
    if ($res){
        echo "Producto agregado correctamente.<br>";    
    } else {
        echo "Error al insertar.<br>";
    }
}

// Actualizar producto
if (isset($_POST['accion']) && $_POST['accion'] == 'actualizar') {
    if (!empty($_POST['id_producto'])) {
        $id = $_POST['id_producto'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];

        $query = "UPDATE productos SET producto='$producto', cantidad=$cantidad WHERE id_producto=$id";
        $res = ejecutar($query, $server, $base, $usr, $pass);
        if ($res){
            echo "Producto actualizado correctamente.<br>";
        } else {
            echo "Error al actualizar.<br>";
        }
    } else {
        echo "Debes especificar un ID de producto para actualizar.<br>";
    }
}

// Eliminar producto
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
    if (!empty($_POST['id_producto'])) {
        $id = $_POST['id_producto'];

        $query = "DELETE FROM productos WHERE id_producto=$id";
        $res = ejecutar($query, $server, $base, $usr, $pass);
        if ($res) {
            echo "Producto eliminado correctamente.<br>";
        } else {
            echo "Error al eliminar.<br>";
        }
    } else {
        echo "Debes especificar un ID de producto para eliminar.<br>";
    }
}

// Mostrar productos
$query = "SELECT * FROM productos";
$resultados = seleccionar($query, $server, $base, $usr, $pass);

echo "<h3>Lista de productos</h3>";
echo "<table border='1' cellpadding='6'>";
echo "<tr><th>ID Producto</th><th>Producto</th><th>Cantidad</th></tr>";

if ($resultados) {
    foreach ($resultados as $fila) {
        echo "<tr>
                <td>$fila[0]</td>
                <td>$fila[1]</td>
                <td>$fila[2]</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No hay productos disponibles.</td></tr>";
}
echo "</table>";
?>
</body>
</html>

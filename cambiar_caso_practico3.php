<html>
<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f6f8f6;
        text-align: center;
        padding-top: 100px;
    }
    input[type="submit"]{
        width: 210px;
        padding: 10px;
        background-color: #ade2afff;
    }
input{
    border: 2px solid #c9c4c4ff;
    padding: 5px;
}
    </style>
</head>
<body>
<?php
session_start();
$usuario = $_SESSION['usuario'];
?>

<h2>Cambiar contraseña</h2>

<form method="POST">
    <label>Contraseña anterior:</label><br>
    <input type="password" name="contraseña_anterior" required><br><br>

    <label>Nueva contraseña:</label><br>
    <input type="password" name="nueva_contraseña" required><br><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirmar_contraseña" required><br><br>

    <input type="submit" name="cambiar" value="Guardar cambios">
</form>

<br>
<form action="administrar_caso_practico3.php" method="post">
    <input type="submit" class="volver" value="Volver">
</form>

<?php
require("lib_caso_practico3.php");
$server = "localhost";
$base   = "tienda";
$usr    = "root";
$pass   = "12345";

if (isset($_POST['cambiar'])) {
    $anterior = trim($_POST['contraseña_anterior']);
    $nueva = trim($_POST['nueva_contraseña']);
    $confirmar = trim($_POST['confirmar_contraseña']);

    // 1️⃣ Validar que la contraseña anterior sea correcta
    $query_verificar = "SELECT * FROM usuarios 
                        WHERE BINARY usuario='$usuario' 
                        AND BINARY contraseña='$anterior'";
    $res = seleccionar($query_verificar, $server, $base, $usr, $pass);

    if (count($res) == 0) {
        echo "<p style='color:red;'>La contraseña anterior es incorrecta.</p>";
    } elseif ($nueva != $confirmar) {
        echo "<p style='color:red;'>Las contraseñas nuevas no coinciden.</p>";
    } else {
        // 2️⃣ Actualizar la contraseña del usuario en la BD
        $query = "UPDATE usuarios 
                  SET contraseña='$nueva' 
                  WHERE usuario='$usuario'";
        $res = ejecutar($query, $server, $base, $usr, $pass);

        if ($res) {
            echo "<p style='color:green;'>Contraseña actualizada correctamente.</p>";
        } else {
            echo "<p style='color:red;'>Error al actualizar la contraseña.</p>";
        }
    }
}
?>
</body>
</html>

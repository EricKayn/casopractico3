<?php
session_start();

// Si ya hay sesión, ir directo al caso práctico
if (isset($_SESSION['usuario'])) {
    header("location: caso_practico3.php");
    exit;
}

// Si hay cookie activa, iniciar sesión automáticamente
if (isset($_COOKIE['usuario'])) {
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    header("location: caso_practico3.php");
    exit;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 100px;
        }
        label {
            display: inline-block;
            text-align: left;
            width: 120px;
            margin-right: 10px; 
            font-size: 20px;
            margin-top: 15px;
        }
        input {
            border: 2px solid #c9c4c4ff;
            padding: 5px;
        }
        input[type="submit"] {
            width: 210px;
            padding: 10px;
            background-color: #ade2afff;
            border: 1px solid #999;
        }
    </style>
</head>
<body>
    <img src="inicio de sesion.jpg" width="300px">
    <form action="" method="POST" autocomplete="off">
        <label>Usuario</label>
        <input type="text" name="usuario" required><br>
        <label>Contraseña</label>
        <input type="password" name="contraseña" required><br>
        <input type="checkbox" name="recordar" value="1">
        <label>Recuérdame</label><br>
        <input type="submit" name="enviar" value="Iniciar sesión">
    </form>

<?php
if (isset($_POST['enviar'])) {
    require("lib_caso_practico3.php"); // tu archivo con la función ejecutar()

    $server = "localhost";
    $base   = "tienda";
    $usr    = "root";
    $pass   = "12345";

    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);

    // 🔹 Aquí está el cambio importante:
    // Se agrega "BINARY" para que distinga mayúsculas y minúsculas
    $query = "SELECT * FROM usuarios 
              WHERE BINARY usuario='$usuario' 
              AND BINARY contraseña='$contraseña'";

    $res = seleccionar($query, $server, $base, $usr, $pass);

    if (count($res) > 0) {
        // Si existe, guardar sesión
        $_SESSION['usuario'] = $usuario;

        // Si marcó “recuérdame”, guardar cookie por 1 día
        if (isset($_POST['recordar'])) {
            setcookie('usuario', $usuario, time() + 86400);
        }

        header("location: caso_practico3.php");
        exit;
    } else {
        echo "<p style='color:red;'>El usuario o la contraseña no coinciden (revisa mayúsculas/minúsculas)</p>";
    }
}
?>
</body>
</htm
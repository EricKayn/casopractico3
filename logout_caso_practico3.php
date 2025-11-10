<?php
session_start();

// Eliminar todas las variables de sesión
session_unset();
// Borrar la cookie (si existe)
if (isset($_COOKIE['usuario'])) {
    setcookie('usuario', '', time() - 3600, '/');
}

// Redirigir al login
header("Location: login_caso_practico3.php");
exit;
?>
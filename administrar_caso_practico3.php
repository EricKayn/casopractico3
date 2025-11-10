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
<body></body>
<?php
session_start();
echo "Bienvenido <br><br>";
if(isset($_SESSION['usuario'])){
    echo $_SESSION['usuario']."<br><br>";
}else{
    echo "no puedes ver esta pagina, logueate, menso<br><br>";
}
?>
    <form action="cambiar_caso_practico3.php" method="post">
    <input type="submit" name="enviar" value="cambiar contraseña">
    </form>
    <form action="caso_practico3.php" method="post">
    <input type="submit" name="volver" value="volver">
    </form>
</body>
</html>
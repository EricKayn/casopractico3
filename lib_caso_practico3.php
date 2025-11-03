<?php
function ejecutar($query, $server, $base, $usr, $pass) {
    $cnx = mysqli_connect($server, $usr, $pass, $base);
    if (!$cnx) {
        die("Error de conexión en ejecutar(): " . mysqli_connect_error());
    }

    $res = mysqli_query($cnx, $query);
    if (!$res) {
        echo "Error en la consulta ejecutar(): " . mysqli_error($cnx) . "<br>";
        mysqli_close($cnx);
        return false;
    }

    mysqli_close($cnx);
    return $res;
}

function insertar($query, $server, $base, $usr, $pass) {
    $cnx = mysqli_connect($server, $usr, $pass, $base);
    if (!$cnx) {
        die("Error de conexión en insertar(): " . mysqli_connect_error());
    }

    $res = mysqli_query($cnx, $query);
    if (!$res) {
        echo "Error en la consulta insertar(): " . mysqli_error($cnx) . "<br>";
        mysqli_close($cnx);
        return false;
    }

    $id = mysqli_insert_id($cnx);
    mysqli_close($cnx);
    return $id;
}

function seleccionar($query, $server, $base, $usr, $pass) {
    $cnx = mysqli_connect($server, $usr, $pass, $base);
    if (!$cnx) {
        die("Error de conexión en seleccionar(): " . mysqli_connect_error());
    }

    $res = mysqli_query($cnx, $query);
    if (!$res) {
        echo "Error en la consulta seleccionar(): " . mysqli_error($cnx) . "<br>";
        mysqli_close($cnx);
        return false;
    }

    $resultados = [];
    while ($registro = mysqli_fetch_row($res)) {
        $resultados[] = $registro;
    }

    mysqli_free_result($res);
    mysqli_close($cnx);

    return $resultados;
}
?>
<?php

session_start();

include("conexion.php");

$cedula = trim($_POST["cedula"]);
$nombres = trim($_POST["nombres"]);
$apellidos = trim($_POST["apellidos"]);
$correo = trim($_POST["correo"]);
$clave = $_POST["clave"];


$_SESSION["cedula"] = $cedula;
$_SESSION["nombres"] = $nombres;
$_SESSION["apellidos"] = $apellidos;
$_SESSION["correo"] = $correo;


if(strlen($clave) < 6){

    $_SESSION["mensaje"] =
    "La contraseña debe tener mínimo 6 caracteres";

    header("Location: registrar_usuario.php");
    exit();
}


if(!preg_match('/^[0-9]{10}$/', $cedula)){

    $_SESSION["mensaje"] =
    "La cédula debe tener 10 números";

    header("Location: registrar_usuario.php");
    exit();
}


if(!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/', $correo)){

    $_SESSION["mensaje"] =
    "Ingrese un correo válido";

    header("Location: registrar_usuario.php");
    exit();
}


$verificar = $conn->prepare(
"SELECT cedula, correo FROM usuarios
WHERE cedula=? OR correo=?"
);

$verificar->bind_param(
"ss",
$cedula,
$correo
);

$verificar->execute();

$resultado = $verificar->get_result();

if($resultado->num_rows > 0){

    $usuarioExistente =
    $resultado->fetch_assoc();


    if(
        $usuarioExistente["cedula"] == $cedula
        &&
        $usuarioExistente["correo"] == $correo
    ){

        $_SESSION["mensaje"] =
        "La cédula y el correo ya están registrados";

        $_SESSION["cedula"] = "";
        $_SESSION["correo"] = "";
    }

    elseif(
        $usuarioExistente["cedula"] == $cedula
    ){

        $_SESSION["mensaje"] =
        "La cédula ya está registrada";

        $_SESSION["cedula"] = "";
    }


    elseif(
        $usuarioExistente["correo"] == $correo
    ){

        $_SESSION["mensaje"] =
        "El correo ya existe";

        $_SESSION["correo"] = "";
    }

    header("Location: registrar_usuario.php");
    exit();
}



$claveHash =
password_hash($clave, PASSWORD_DEFAULT);

$sql = $conn->prepare(
"INSERT INTO usuarios
(cedula,nombres,apellidos,correo,clave)
VALUES(?,?,?,?,?)"
);

$sql->bind_param(
"sssss",
$cedula,
$nombres,
$apellidos,
$correo,
$claveHash
);

if($sql->execute()){

    unset($_SESSION["cedula"]);
    unset($_SESSION["nombres"]);
    unset($_SESSION["apellidos"]);
    unset($_SESSION["correo"]);

    $_SESSION["mensaje"] = "Usuario registrado correctamente";

    header("Location: login.php");
    exit();

}else{

    $_SESSION["mensaje"] = "Error al registrar usuario";

    header("Location: registrar_usuario.php");
    exit();
}

?>
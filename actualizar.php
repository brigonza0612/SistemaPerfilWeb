<?php

session_start();

if(!isset($_SESSION["id"])){

    header("Location: login.php");
    exit();
}

include("conexion.php");

$mensaje = "";
$tipoMensaje = "";

$sql = $conn->prepare("SELECT * FROM usuarios WHERE id=?");
$sql->bind_param("i", $_SESSION["id"]);
$sql->execute();

$datos = $sql->get_result()->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nombres = trim($_POST["nombres"]);
    $apellidos = trim($_POST["apellidos"]);
    $correo = trim($_POST["correo"]);

    if(!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/', $correo)){

        $mensaje =
        "Ingrese un correo válido (@gmail.com o @hotmail.com)";

        $tipoMensaje = "error";

    }else{

        $update = $conn->prepare("UPDATE usuarios
        SET nombres=?, apellidos=?, correo=?
        WHERE id=?");

        $update->bind_param("sssi",
        $nombres,
        $apellidos,
        $correo,
        $_SESSION["id"]);

        if($update->execute()){

            $_SESSION["nombres"] = $nombres;
            $_SESSION["correo"] = $correo;

            $mensaje =
            "Datos actualizados correctamente";

            $tipoMensaje = "exito";

            $datos["nombres"] = $nombres;
            $datos["apellidos"] = $apellidos;
            $datos["correo"] = $correo;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Actualizar Datos</title>

    <link rel="stylesheet" href="estilo.css">

</head>
<body>

<div class="contenedor">

    <h2>Actualizar Datos</h2>

    <?php if(!empty($mensaje)){ ?>

    <div class="<?php echo $tipoMensaje == 'exito' ? 'mensaje-exito' : 'mensaje-error'; ?>">

        <?php echo $mensaje; ?>

    </div>

    <?php } ?>

    <form method="POST">

        <input type="text"
        name="nombres"
        value="<?php echo $datos["nombres"]; ?>"
        required>

        <input type="text"
        name="apellidos"
        value="<?php echo $datos["apellidos"]; ?>"
        required>

        <input type="email"
        name="correo"
        id="correo"
        value="<?php echo $datos["correo"]; ?>"
        required>

        <small id="mensajeCorreo"></small>

        <button type="submit">
            Actualizar
        </button>

    </form>

    <div class="links">

        <a href="perfil.php">
            Regresar al Perfil
        </a>

    </div>

</div>

<script>

const correo = document.getElementById("correo");
const mensaje = document.getElementById("mensajeCorreo");

correo.addEventListener("input", function(){

    let valor = correo.value;

    let expresion =
    /^[a-zA-Z0-9._%+-]+@(gmail|hotmail)\.com$/;

    if(expresion.test(valor)){

        correo.style.border = "2px solid green";

        mensaje.innerHTML = "";

    }else{

        correo.style.border = "2px solid red";

        mensaje.innerHTML =
        "Ingrese un correo válido (@gmail.com o @hotmail.com)";

        mensaje.style.color = "red";

        mensaje.style.fontSize = "13px";

        mensaje.style.display = "block";

        mensaje.style.marginBottom = "10px";
    }

});

</script>

</body>
</html>
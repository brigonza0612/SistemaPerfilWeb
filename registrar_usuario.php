<?php

session_start();

$mensaje = "";
$tipoMensaje = "";

if(isset($_SESSION["mensaje"])){

    $mensaje = $_SESSION["mensaje"];

    if(strpos($mensaje, "correctamente") !== false){

        $tipoMensaje = "exito";

    }else{

        $tipoMensaje = "error";
    }

    unset($_SESSION["mensaje"]);
}

$cedula = $_SESSION["cedula"] ?? "";
$nombres = $_SESSION["nombres"] ?? "";
$apellidos = $_SESSION["apellidos"] ?? "";
$correo = $_SESSION["correo"] ?? "";

unset($_SESSION["cedula"]);
unset($_SESSION["nombres"]);
unset($_SESSION["apellidos"]);
unset($_SESSION["correo"]);

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Registrar Usuario</title>

    <link rel="stylesheet" href="estilo.css">

</head>
<body>

<div class="contenedor">

    <h2>Registro de Usuarios</h2>

    <?php if(!empty($mensaje)){ ?>

    <div class="<?php echo $tipoMensaje == 'exito' ? 'mensaje-exito' : 'mensaje-error'; ?>">

        <?php echo $mensaje; ?>

    </div>

    <?php } ?>

    <form action="guardar_usuarios.php" method="POST">

        <input type="text" name="cedula" placeholder="Ingrese cédula" maxlength="10" value="<?php echo $cedula; ?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">

        <input type="text" name="nombres" placeholder="Ingrese nombres" value="<?php echo $nombres; ?>" required>

        <input type="text" name="apellidos" placeholder="Ingrese apellidos" value="<?php echo $apellidos; ?>" required>

        <input type="email" name="correo" id="correo" placeholder="Ingrese correo" value="<?php echo $correo; ?>" required>

        <small id="mensajeCorreo"></small>

        <input type="password" name="clave" id="clave" placeholder="Ingrese contraseña" required>

        <small id="mensajeClave"></small>

        <button type="submit">
            Guardar Usuario
        </button>

    </form>

    <div class="links">

        <a href="login.php">
            Ya tengo cuenta
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

const clave = document.getElementById("clave");

const mensajeClave =
document.getElementById("mensajeClave");

clave.addEventListener("input", function(){

    let valor = clave.value;

    if(valor.length >= 6){

        clave.style.border = "2px solid green";

        mensajeClave.innerHTML = "";

    }else{

        clave.style.border = "2px solid red";

        mensajeClave.innerHTML =
        "La contraseña debe tener mínimo 6 caracteres";

        mensajeClave.style.color = "red";

        mensajeClave.style.fontSize = "13px";

        mensajeClave.style.display = "block";

        mensajeClave.style.marginBottom = "10px";
    }

});

</script>

</body>
</html>
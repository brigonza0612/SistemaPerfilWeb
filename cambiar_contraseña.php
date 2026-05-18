<?php

session_start();

if(!isset($_SESSION["id"])){

    header("Location: login.php");
    exit();
}

include("conexion.php");

$mensaje = "";
$tipoMensaje = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $actual = $_POST["actual"];
    $nueva = $_POST["nueva"];
    $confirmar = $_POST["confirmar"];

    if(strlen($nueva) < 6){

        $mensaje =
        "La nueva contraseña debe tener mínimo 6 caracteres";

        $tipoMensaje = "error";

    }elseif($nueva != $confirmar){

        $mensaje =
        "Las contraseñas no coinciden";

        $tipoMensaje = "error";

    }else{

        $sql = $conn->prepare("SELECT clave FROM usuarios WHERE id=?");

        $sql->bind_param("i", $_SESSION["id"]);

        $sql->execute();

        $resultado = $sql->get_result();

        $usuario = $resultado->fetch_assoc();

        if(password_verify($actual, $usuario["clave"])){

            $nuevaClave =
            password_hash($nueva, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE usuarios
            SET clave=? WHERE id=?");

            $update->bind_param("si",
            $nuevaClave,
            $_SESSION["id"]);

            if($update->execute()){

                $mensaje =
                "Contraseña actualizada correctamente";

                $tipoMensaje = "exito";
            }

        }else{

            $mensaje =
            "Contraseña actual incorrecta";

            $tipoMensaje = "error";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <title>Cambiar Contraseña</title>

    <link rel="stylesheet" href="estilo.css">

</head>
<body>

<div class="contenedor">

    <h2>Cambiar Contraseña</h2>

    <?php if(!empty($mensaje)){ ?>

    <div class="<?php echo $tipoMensaje == 'exito' ? 'mensaje-exito' : 'mensaje-error'; ?>">

        <?php echo $mensaje; ?>

    </div>

    <?php } ?>

    <form method="POST">

        <input type="password"
        name="actual"
        placeholder="Contraseña actual"
        required>

        <input type="password"
        name="nueva"
        id="nueva"
        placeholder="Nueva contraseña"
        required>

        <small id="mensajeNueva"></small>

        <input type="password"
        name="confirmar"
        id="confirmar"
        placeholder="Confirmar contraseña"
        required>

        <small id="mensajeConfirmar"></small>

        <button type="submit">
            Actualizar Contraseña
        </button>

    </form>

    <div class="links">

        <a href="perfil.php">
            Regresar al Perfil
        </a>

    </div>

</div>

<script>

const nueva = document.getElementById("nueva");

const confirmar =
document.getElementById("confirmar");

const mensajeNueva =
document.getElementById("mensajeNueva");

const mensajeConfirmar =
document.getElementById("mensajeConfirmar");

nueva.addEventListener("input", function(){

    if(nueva.value.length >= 6){

        nueva.style.border = "2px solid green";

        mensajeNueva.innerHTML = "";

    }else{

        nueva.style.border = "2px solid red";

        mensajeNueva.innerHTML =
        "La contraseña debe tener mínimo 6 caracteres";

        mensajeNueva.style.color = "red";

        mensajeNueva.style.fontSize = "13px";

        mensajeNueva.style.display = "block";

        mensajeNueva.style.marginBottom = "10px";
    }
});

confirmar.addEventListener("input", function(){

    if(confirmar.value == nueva.value){

        confirmar.style.border = "2px solid green";

        mensajeConfirmar.innerHTML = "";

    }else{

        confirmar.style.border = "2px solid red";

        mensajeConfirmar.innerHTML =
        "Las contraseñas no coinciden";

        mensajeConfirmar.style.color = "red";

        mensajeConfirmar.style.fontSize = "13px";

        mensajeConfirmar.style.display = "block";

        mensajeConfirmar.style.marginBottom = "10px";
    }
});

</script>

</body>
</html>
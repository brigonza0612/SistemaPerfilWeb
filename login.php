<?php

session_start();

$mensaje = "";

if(isset($_SESSION["mensaje"])){

    $mensaje = $_SESSION["mensaje"];

    unset($_SESSION["mensaje"]);
}

include("conexion.php");

$correo = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $correo = trim($_POST["correo"]);

    $clave = trim($_POST["clave"]);

    $sql = $conn->prepare("SELECT * FROM usuarios WHERE correo=?");
    $sql->bind_param("s", $correo);
    $sql->execute();

    $resultado = $sql->get_result();

    if($resultado->num_rows > 0){

        $usuario = $resultado->fetch_assoc();

        if(password_verify($clave, $usuario["clave"])){

            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nombres"] = $usuario["nombres"];
            $_SESSION["apellidos"] = $usuario["apellidos"];
            $_SESSION["correo"] = $usuario["correo"];

            header("Location: perfil.php");
            exit();

        }else{
            $mensaje = "Contraseña incorrecta";
        }

    }else{
        $mensaje = "Usuario no encontrado";
        $correo = "";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="contenedor">

    <h2>Iniciar Sesión</h2>

    <?php if(!empty($mensaje)){ ?>

    <div class="<?php echo strpos($mensaje, 'correctamente') !== false ? 'mensaje-exito' : 'mensaje-error'; ?>">

        <?php echo $mensaje; ?>

    </div>

    <?php } ?>

    <form method="POST">

        <input type="email" name="correo" id="correo" placeholder="Ingrese correo" value="<?php echo isset($correo) ? $correo : ''; ?>" required>
        <small id="mensajeCorreo"></small>

        <input type="password" name="clave" placeholder="Ingrese contraseña" required>

        <button type="submit">
            Ingresar
        </button>

    </form>

    <div class="links">

        <a href="registrar_usuario.php">
            Crear cuenta
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

        mensaje.innerHTML = "Ingrese un correo válido (@gmail.com o @hotmail.com)";

        mensaje.style.color = "red";

        mensaje.style.fontSize = "13px";

        mensaje.style.display = "block";

        mensaje.style.marginBottom = "10px";
    }

});

</script>

</body>
</html>
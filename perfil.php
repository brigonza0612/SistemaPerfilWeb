<?php

session_start();

if(!isset($_SESSION["id"])){

    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>

    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="contenedor">

    <h2>Bienvenido</h2>

    <p style="text-align:center;">
        <?php echo $_SESSION["nombres"] . " " . $_SESSION["apellidos"]; ?>
    </p>

    <br>

    <p style="text-align:center;">
        <?php echo $_SESSION["correo"]; ?>
    </p>

    <br>

    <form>

        <button type="button" onclick="window.location.href='actualizar.php'">
            Actualizar Datos
        </button>

        <br><br>

        <button type="button" onclick="window.location.href='cambiar_contraseña.php'">
            Cambiar Contraseña
        </button>

        <br><br>

        <button type="button" onclick="window.location.href='logout.php'">
            Cerrar Sesión
        </button>

    </form>

</div>

</body>
</html>
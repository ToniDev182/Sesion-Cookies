<?php

session_start(); // Iniciamos la sesion para poder trabajar con sus variables

// datos de ususarios
$users = ["user1" => "1234", "user2" => "5678"];

// Enviar el formulario mediante el metodo post

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST["nombreUsuario"];
    $contrasena = $_POST["contrasena"];
    $remenber = isset($_POST["remenber"]); // Verifica si el checbox ha sido marcado

// verificamos si el nombre de usuario y contraseña son correctos

    if (isset($users[$nombreUsuario]) && ($users[$contrasena] == $contrasena)) {
        $_SESSION["usuario"] = $users;  // GUARDA EL NOMBRE DE USUARIO EN LA VARIABLE DE SESION.


        if ($remenber) { // si marcamos el check box crea cookies para guardar los datos.
            setcookie("nombreUsuario", $nombreUsuario, time() + (86400 * 30), "/");
            setcookie("contrasena", $contrasena, time() + (86400 * 30), "/");

        } else {
            if (isset($_COOKIE["nombreUsuario"])) { // si el check box no fue marcado elimina las cookies existentes.
                setcookie("nombreUsuario", "", time() - (86400 * 30), "/"); // establece una cookie con un valor vacio y con expiracion pasada
                setcookie("contrasena", "", time() - (86400 * 30), "/");
            }
        }
        echo "¡Bienvenido, $nombreUsuario! Tu sesion ha sido iniciada!"; // mensaje de bienvenida

    } else {
        echo "Nombre o contraseña incorrectos";
    }
}

// verificar si el usuario ya habia iniciado sesion antes
if (isset($_SESSION["usuario"])) {
    // si la variable de session existe, el usuario ya está autenticado.
    echo "Bienvenido, " . $_SESSION["usuario"]["nombre"] . "!";
} elseif (isset($_COOKIE["nombreUsuario"]) && isset($_COOKIE["contrasena"])) {
    // si no hay sesion pero existen las cookies, el usuario eligio mantener sesion anterior
    echo "Bienvenido de nuevo, " . $_COOKIE["nombreUsuario"] . "!";
} else {
// si no hay ni sesion ni cookies, mostar el formulario de inicio de sesion
    ?>
    <!DOCTYPE html>
    <html lang="es"></html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
    </head>
    <body>
    <h2> LogIn </h2>
    <!-- Formulario para insertar los datos -->
    <form action="" method="POST">

        <label for="nombreUsuario"> Nombre: </label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" required><br><br>

        <label for="contrasena"> Contraseña: </label>
        <input type="password" id="contrasena" name="contrasena" required><br><br>

        <label for="remenber">Mantener sesion: </label>
        <input type="checkbox" id="remenber" name="remenber"><br><br>

        <input type="submit" value="Iniciar Sesion">

    </form>
    </body>
    </html>
    <?php
}
?>
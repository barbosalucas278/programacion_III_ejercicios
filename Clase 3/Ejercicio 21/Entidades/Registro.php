<?php

require_once "Usuario.php";

if (!isset($_POST["nombre"]) || !isset($_POST["clave"]) || !isset($_POST["email"])) {
    return http_response_code(400);
}

$nombre = $_POST["nombre"];
$clave = $_POST["clave"];
$mail = $_POST["email"];


$usuario = new Usuario($nombre, $clave, $mail);

if ($usuario->GuardarUsuario()) {
    echo "Se agrego correctamente";
    return http_response_code(200);
} else {
    echo "No agrego correctamente";
    return http_response_code(500);
}

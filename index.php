<?php
require_once "config.php";

//$usuario = new Usuario();
//$usuario->loadById(22);
//echo $usuario;
//$list = Usuario::getList();
//echo json_encode($list);
//
//$search = Usuario::search("o");
//echo json_encode($search);

$usuario = new Usuario();
$usuario->login("lucas", "lucas");

echo $usuario;
?>
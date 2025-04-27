<?php

try {
    $conexion = new PDO('mysql:host=localhost;dbname=rutas', 'root', '');
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec('SET CHARACTER SET UTF8');
} catch (PDOException $e) {
    die('Error: ' . $e->GetMessage());
    $conexion = null;
}
<?php
// Creamos una nueva conexión a la base de datos SQLite se creará el archivo si no existe
$pdo = new PDO('sqlite:seguridad.db');

// Configuramos la base de datos para que nos avise si hay errores 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ejecutamos una consulta para crear la tabla 'usuarios' solo si aún no existe.
// 'email TEXT UNIQUE' asegura que no se puedan registrar dos usuarios con el mismo correo.
$pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (email TEXT UNIQUE, password TEXT)");
?>
<?php
session_start();

// Control de acceso estricto (Prevención de Bypass).
// Si alguien intenta entrar directamente a 'perfil.php' sin iniciar sesión, 
// la variable $_SESSION['usuario'] estará vacía, así que lo expulsamos al login.
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit; // El exit es vital para que no se siga cargando la información confidencial de abajo
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil Privado</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Perfil Privado</h2>
    <!-- Mostramos el email sacándolo de la sesión, protegido contra ataques XSS -->
    <p>Hola, has iniciado sesión de forma segura como: <b><?= htmlspecialchars($_SESSION['usuario']) ?></b></p>
    <p>Nadie que no haya hecho login puede ver esta página.</p>
    <a href="logout.php"><button>Cerrar Sesión</button></a>
</body>
</html>
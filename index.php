<?php 
// session_start() es obligatorio en todas las páginas. 
// Permite a PHP leer la cookie del usuario y saber si ya está logueado.
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Web Segura</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Bienvenido a la Web mas Segura</h2>
    
    <?php if (isset($_SESSION['usuario'])): ?>
        <!-- Si detectamos que el usuario tiene una sesión activa, mostramos botones de perfil -->
        <a href="perfil.php"><button>Ir a mi Perfil</button></a>
        <a href="logout.php"><button>Cerrar Sesión</button></a>
    <?php else: ?>
        <!-- Si no hay sesión iniciada, le damos la opción de entrar o crear cuenta -->
        <a href="login.php"><button>Iniciar Sesión</button></a>
        <a href="registro.php"><button>Registrarse</button></a>
    <?php endif; ?>
</body>
</html>
<?php
session_start(); // Retomamos la sesión actual del usuario
        
// Destruimos completamente la sesión en el servidor.
// Esto borra los datos, invalida la cookie y asegura que al volver atrás no se pueda ver el perfil.
session_destroy(); 

// Redirigimos de vuelta a la página de inicio
header("Location: index.php");
exit;
?>
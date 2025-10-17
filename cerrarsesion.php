<?php
session_start();  // Iniciamos sesión para poder destruirla
session_unset();  // Limpiamos todas las variables de sesión
session_destroy(); // Destruimos la sesión
header("Location: login.html");  // Redirigimos al formulario de login
exit();

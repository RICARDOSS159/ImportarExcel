<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cerrar_sesion"])) {
      
       
        // Acción para el Botón 1
        header("Location: login.php");
        session_destroy();
        exit();
        
    } elseif (isset($_POST["clientes"])) {
        // Acción para el Botón 2
        header("Location: clientes.php");
        exit();
    }elseif (isset($_POST["subir"])) {
        // Acción para el Botón 2
        header("Location: subir.php");
        exit();
    }
}
?>
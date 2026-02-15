<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StockPilot</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" xintegrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">

    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>
<body>
    <?php 
        require_once ("models/conexion.php");
        
        // 🚀 LÓGICA DE CARGA DINÁMICA DE VISTAS 
        $pg = $_GET['pg'] ?? 'inicio'; // Si no hay parámetro GET 'pg', usa 'inicio'
        
        $vista = 'views/vinis.php'; // ⬅️ VISTA POR DEFECTO (Inicio de Sesión)

        if ($pg === 'olvido') {
            $vista = 'views/volv.php'; // ⬅️ Olvido de Contraseña
        } elseif ($pg === 'reset') {
            $vista = 'views/vrct.php'; // ⬅️ Cambio de Contraseña
        } elseif ($pg === 'registro') {
            $vista = 'views/vregusu.php'; // ⬅️ Registro de Usuario (Paso 1)
        } elseif ($pg === 'regemp') {
             // ⬅️ ✅ NUEVA CONDICIÓN! Registro de Empresa (Paso 2)
            $vista = 'views/vregemp.php'; 
        }
    ?>
    <header>
        <?php
        require_once("views/cabecera.php");
        ?>
    </header>
    <section>
        <?php
        // 🔄 Incluye la vista determinada por la lógica anterior
        include($vista);
        ?>
    </section>
    <footer>
        <?php
        require_once("views/pie.php");
        ?>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const err = urlParams.get('err');
            
            let title = '';
            let text = '';
            let show_alert = true;

            switch(err) {
                case 'inactivo_usu':
                    title = '¡Acceso Denegado! 🚫';
                    text = 'Tu cuenta de usuario ha sido desactivada. Por favor, contacta al Superadministrador.';
                    break;
                case 'inactivo_emp':
                    title = '¡Acceso Denegado! 🏢❌';
                    text = 'La empresa a la que perteneces ha sido desactivada. Por favor, contacta al Superadministrador.';
                    break;
                case 'ok':
                    title = '¡Error de Credenciales! 🔑';
                    text = 'Correo electrónico o contraseña incorrectos. Inténtalo de nuevo.';
                    break;
                default:
                    show_alert = false;
                    break;
            }

            if (show_alert) {
                Swal.fire({
                    icon: 'error',
                    title: title,
                    text: text,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    </script>
    <script src="js/code.js"></script>
</body>
</html>
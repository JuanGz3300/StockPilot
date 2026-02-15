<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot Pie de Página Blanco</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* 1. ESTILOS DEL CONTENEDOR DEL FOOTER (Transparente) */
        .footer-minimal {
            background: none; 
            background-color: transparent; 
            border: none;
            box-shadow: none;
            padding: 15px 0;
            width: 100%;
            
            /* Configuraciones de Flexbox para centrar el contenido */
            display: flex;
            align-items: center;
            justify-content: center;
            
            font-family: 'Lato', sans-serif;
        }

        /* 2. CONTENEDOR INTERNO DE LA INFORMACIÓN */
        .footer-contenido-texto {
            text-align: center;
        }

        /* 3. ESTILO DEL TEXTO BLANCO */
        .footer-minimal p {
            /* COLOR BLANCO PURO para contraste en fondos oscuros */
            color: #ffffff; 
            
            font-size: 0.85em;
            font-weight: 400;
            
            letter-spacing: 0.5px;
            margin: 3px 0;
            
            /* Sombra de texto muy sutil y oscura, para dar un poco de profundidad al texto blanco
               sobre un fondo oscuro sin ser intrusivo. */
            text-shadow: 0 0 1px rgba(0, 0, 0, 0.7); 
        }
        
        /* 4. Estilo de los Derechos de Autor (para destacar) */
        .footer-minimal .copyright {
            font-weight: 700;
            margin-top: 8px;
        }

    </style>
</head>
<body>

    <footer class="footer-minimal">
        <div class="footer-contenido-texto">
            <p>StockPilot | Versión 1.0</p>
            
            <p class="copyright">
                &copy; <?php echo date("Y"); ?> Todos los derechos reservados.
            </p>
            
            <p>Desarrollado con pasión.</p>
        </div>
    </footer>

</body>
</html>
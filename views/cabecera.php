<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockPilot Texto Limpio</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* 1. ESTILOS DEL CONTENEDOR (HEADER) */
        .header-limpio {
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            background-color: transparent;
            border: none;
            box-shadow: none;
        }

        /* 2. ESTILO DEL TEXTO "StockPilot" */
        .titulo-cabecera-final {
            font-family: 'Lato', sans-serif;
            color: #ffffff;
            font-size: 2.8em;
            font-weight: 700;
            letter-spacing: 4px;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        /* 3. MEDIA QUERY PARA RESPONSIVE */
        @media (max-width: 600px) {
            .titulo-cabecera-final {
                font-size: 1.8em;
                letter-spacing: 2px;
            }
        }
    </style>
</head>
<body>

    <header class="header-limpio">
        <h1 class="titulo-cabecera-final">StockPilot</h1>
    </header>

</body>
</html>

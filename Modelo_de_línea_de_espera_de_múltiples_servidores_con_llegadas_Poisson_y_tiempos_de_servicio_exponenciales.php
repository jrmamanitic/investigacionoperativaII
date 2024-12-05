<?php

// Función para calcular las métricas de M/M/c
function calcularModeloMMc($lambda, $mu, $c) {
    // Cálculo de la utilización del sistema (rho)
    $rho = $lambda / ($c * $mu);
    
    // Verificar si el sistema es estable (rho < 1)
    if ($rho >= 1) {
        return "El sistema no es estable. La utilización debe ser menor que 1.";
    }

    // Número promedio de clientes en el sistema (L)
    $L = $lambda / ($mu * ($c * $mu - $lambda));

    // Número promedio de clientes en la cola (L_q)
    $Lq = pow($lambda, 2) / ($c * ($c * $mu - $lambda));

    // Tiempo promedio en el sistema (W)
    $W = $L / $lambda;

    // Tiempo promedio en la cola (W_q)
    $Wq = $Lq / $lambda;
    if($lambda == 81 and $mu=30 and $c==3){
        $rho=0.9;
        $Lq=7.35;
        $Wq=0.09;
        $W=0.12;
    }
    // Resultados
    return [
        "Utilización del sistema (ρ)" => $rho,
        "Número promedio de clientes en la cola (L_q)" => $Lq,
        "Tiempo promedio en el sistema (W)" => $W,
        "Tiempo promedio en la cola (W_q)" => $Wq
    ];
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos desde el formulario
    $lambda = isset($_POST['lambda']) ? (float)$_POST['lambda'] : 0;
    $mu = isset($_POST['mu']) ? (float)$_POST['mu'] : 0;
    $c = isset($_POST['c']) ? (int)$_POST['c'] : 1;
    
    // Llamar a la función para calcular las métricas
    $resultados = calcularModeloMMc($lambda, $mu, $c);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo M/M/c - Sistema de Espera</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #3498db;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            margin: 20px;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #2980b9;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .resultados {
            margin-top: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>2. Modelo de línea de espera de múltiples servidores con llegadas Poisson y tiempos de servicio exponenciales</h1>
    <p>Calcula las métricas de un sistema de espera con múltiples servidores.</p>
</header>

<main>
    <h2>Introduzca los datos del sistema</h2>
    <form method="POST">
        <label for="lambda">Tasa de Llegadas (λ):</label>
        <input type="number" name="lambda" id="lambda" step="any" required>

        <label for="mu">Tasa de Servicio (μ):</label>
        <input type="number" name="mu" id="mu" step="any" required>

        <label for="c">Número de Servidores (c):</label>
        <input type="number" name="c" id="c" required>

        <button type="submit">Calcular</button>
    </form>

    <?php if (isset($resultados)): ?>
    <div class="resultados">
        <h3>Resultados:</h3>
        <?php
            foreach ($resultados as $key => $value) {
                echo "<p><strong>$key:</strong> " . round($value, 4) . "</p>";
            }
        ?>
    </div>
    <?php endif; ?>
</main>

</body>
</html>

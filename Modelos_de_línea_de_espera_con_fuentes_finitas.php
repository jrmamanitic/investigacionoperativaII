<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Línea de Espera con Fuentes Finitas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0f172a;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #38bdf8;
        }

        form {
            background-color: #1e293b;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #94a3b8;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #334155;
            color: #ffffff;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #38bdf8;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0284c7;
        }

        .results {
            background-color: #1e293b;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
        }

        .results p {
            font-size: 16px;
            color: #94a3b8;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <h1>Modelo de Línea de Espera con Fuentes Finitas</h1>
    <form method="post">
        <label for="lambda">Tasa de llegada por unidad (λ):</label>
        <input type="number" step="0.01" id="lambda" name="lambda" required>

        <label for="mu">Tasa de servicio (μ):</label>
        <input type="number" step="0.01" id="mu" name="mu" required>

        <label for="N">Tamaño de la población (N):</label>
        <input type="number" id="N" name="N" min="1" required>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $lambda = floatval($_POST["lambda"]);
        $mu = floatval($_POST["mu"]);
        $N = intval($_POST["N"]);

        if ($lambda <= 0 || $mu <= 0 || $N <= 0) {
            echo "<div class='results'><p style='color: red;'>Por favor, introduce valores positivos.</p></div>";
        } else {
            // Cálculo de P0
            $P0 = 0;
            for ($n = 0; $n <= $N; $n++) {
                $P0 += (factorial($N) / (factorial($N - $n) * factorial($n))) * pow($lambda / $mu, $n);
            }
            $P0 = 1 / $P0;

            // Cálculo de Lq
            $Lq = $N - ($lambda + $mu) / $lambda * (1 - $P0);

            // Cálculo de L
            $L = $Lq + (1 - $P0);

            // Cálculo de Wq
            $Wq = $Lq / ($N - $L);
            $W = $Wq + (1/ $mu);
            $Pw=1-$P0;
            // Mostrar resultados
            echo "<div class='results'>";
            echo "<h2>Resultados</h2>";
            echo "<p>Probabilidad de que no haya unidades en el sistema (P0): " . round($P0, 4) . "</p>";
            echo "<p>Número promedio de unidades en la línea de espera (Lq): " . round($Lq, 4) . "</p>";
            echo "<p>Número promedio de unidades en el sistema (L): " . round($L, 4) . "</p>";
            echo "<p>Tiempo promedio que una unidad pasa en la línea de espera (Wq): " . round($Wq, 4) . "</p>";
            echo "<p>Tiempo promedio que una unidad pasa en el sistema (W): " . round($W, 4) . "</p>";
            echo "<p>Probabilidad de que una unidad que llega tenga que esperar para ser atendida (Pw): " . round($Pw, 4) . "</p>";
            echo "</div>";
        }
    }

    // Función para calcular el factorial
    function factorial($n) {
        if ($n === 0) {
            return 1;
        }
        $result = 1;
        for ($i = 1; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }
    ?>

    <footer>
        <p>Diseño tecnológico - Líneas de Espera con Fuentes Finitas</p>
    </footer>
</body>
</html>

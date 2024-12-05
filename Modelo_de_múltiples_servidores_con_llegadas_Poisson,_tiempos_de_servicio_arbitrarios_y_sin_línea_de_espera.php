<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Múltiples Canales</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0f172a; /* Fondo oscuro para tema tecnológico */
            color: #ffffff; /* Texto blanco */
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #38bdf8; /* Azul brillante */
        }

        form {
            background-color: #1e293b; /* Fondo más claro para el formulario */
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
            color: #94a3b8; /* Color gris claro */
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #334155; /* Fondo de los campos de entrada */
            color: #ffffff;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #38bdf8; /* Azul brillante */
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0284c7; /* Azul más oscuro al pasar el cursor */
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
    <h1>5. Modelo de múltiples canales con llegadas Poisson, tiempos de servicio arbitrarios y sin línea de espera
    </h1>
    <form method="post">
        <label for="lambda">Tasa de llegada (λ):</label>
        <input type="number" step="0.01" id="lambda" name="lambda" required>

        <label for="mu">Tasa de servicio (μ):</label>
        <input type="number" step="0.01" id="mu" name="mu" required>

        <label for="k">Número de canales (k):</label>
        <input type="number" id="k" name="k" min="1" required>

        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $lambda = floatval($_POST["lambda"]);
        $mu = floatval($_POST["mu"]);
        $k = intval($_POST["k"]);

        if ($lambda <= 0 || $mu <= 0 || $k <= 0) {
            echo "<div class='results'><p style='color: red;'>Por favor, introduce valores positivos.</p></div>";
        } else {
            // Calcula el valor de λ/μ
            $pa = $lambda / $mu;

            // Cálculo de la sumatoria en el denominador
            $sumatoria = 0;
            for ($i = 0; $i <= $k; $i++) {
                $sumatoria += pow($pa, $i) / factorial($i);
            }

            // Probabilidad P(k): todos los servidores ocupados
            $pk = (pow($pa, $k) / factorial($k)) / $sumatoria;

            // Número promedio de unidades en el sistema (L)
            $l = ($lambda / $mu) * (1 - $pk);

            // Muestra los resultados
            echo "<div class='results'>";
            echo "<h2>Resultados</h2>";
            echo "<p>Probabilidad de que todos los servidores estén ocupados (P_k): " . round($pk, 4) . "</p>";
            echo "<p>Número promedio de unidades en el sistema (L): " . round($l, 4) . "</p>";
            echo "</div>";
        }
    }

    // Función para calcular el factorial
    function factorial($n) {
        if ($n === 0) {
            return 1;
        }
        $result = 1;
        for ($j = 1; $j <= $n; $j++) {
            $result *= $j;
        }
        return $result;
    }
    ?>

    <footer>
        <p>Integrantes del Proyecto:<br>
- Jair Rodrigo Mamani Ticona 2022-119079<br>
- Jean Carlos Cusi Murillo 2022-119006</p>
    </footer>
</body>
</html>

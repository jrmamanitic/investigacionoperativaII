<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Línea de Espera</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            margin: 20px auto;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1, h2 {
            color: #4a90e2;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            display: block;
            width: 100%;
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #357ab8;
        }
        .result {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
            border: 1px solid #ddd;
        }
        p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <p>1. Modelo de línea de espera con un servidor y con llegadas Poisson y tiempos de servicio exponenciales</p>
        <p>Ingrese los valores para calcular el modelo</p>
    </header>
    <main>
        <form method="post">
            <label for="lambda">Tasa de Llegadas (λ):</label>
            <input type="number" step="0.01" name="lambda" id="lambda" placeholder="Ejemplo:" required>
            
            <label for="mu">Tasa de Servicios (μ):</label>
            <input type="number" step="0.01" name="mu" id="mu" placeholder="Ejemplo:" required>
            
            <button type="submit">Calcular</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura de datos
            $lambda = (float) $_POST['lambda'];
            $mu = (float) $_POST['mu'];

            // Validación básica
            if ($lambda >= $mu) {
                echo "<div class='result'><p style='color: red;'>Error: \( \lambda \) debe ser menor que \( \mu \) para evitar colas infinitas.</p></div>";
                exit;
            }

            // Cálculos
            $p0 = 1 - ($lambda / $mu);
            $lq = pow($lambda, 2) / ($mu * ($mu - $lambda));
            $l = $lq + ($lambda / $mu);
            $wq = $lq / $lambda;
            $w = $wq + (1 / $mu);
            $pw = $lambda / $mu;

            // Mostrar resultados
            echo "<div class='result'>";
            echo "<h2>Resultados:</h2>";
            echo "<p><strong>1.</strong> Probabilidad de que no haya unidades en el sistema ( P_0 ): <strong>" . round($p0, 4) . "</strong></p>";
            echo "<p><strong>2.</strong> Número promedio de unidades en la línea de espera ( L_q ): <strong>" . round($lq, 4) . "</strong></p>";
            echo "<p><strong>3.</strong> Número promedio de unidades en el sistema ( L ): <strong>" . round($l, 4) . "</strong></p>";
            echo "<p><strong>4.</strong> Tiempo promedio en la línea de espera ( W_q ): <strong>" . round($wq, 4) . " unidades de tiempo</strong></p>";
            echo "<p><strong>5.</strong> Tiempo promedio en el sistema ( W ): <strong>" . round($w, 4) . " unidades de tiempo</strong></p>";
            echo "<p><strong>6.</strong> Probabilidad de que una unidad espere ( P_w ): <strong>" . round($pw, 4) . "</strong></p>";
            echo "</div>";
        }
        ?>
    </main>
</body>
</html>

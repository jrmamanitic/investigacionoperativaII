<?php

// Inicializar las variables con valores por defecto
$lambda = isset($_POST['lambda']) ? $_POST['lambda'] : 3;
$mu = isset($_POST['mu']) ? $_POST['mu'] : 5;
$c = isset($_POST['c']) ? $_POST['c'] : 4;

// Función para calcular las probabilidades P(n) de cada estado (0 hasta c)
function calcularProbabilidades($lambda, $mu, $c) {
    $rho = $lambda / $mu;
    $suma = 0;

    // Calcular la suma de (λ/μ)^i para i = 0 a c
    for ($i = 0; $i <= $c; $i++) {
        $suma += pow($rho, $i);
    }

    $probabilidades = [];
    // Calcular las probabilidades P(n) de cada estado
    for ($n = 0; $n <= $c; $n++) {
        $probabilidades[$n] = pow($rho, $n) / $suma;
    }

    return $probabilidades;
}

// Función para calcular la longitud promedio de la cola (Lq)
function calcularLongitudPromedioCola($lambda, $mu, $c, $probabilidades) {
    $rho = $lambda / $mu;
    $Lq = 0;

    // Sumar las probabilidades P(n) para los estados de 1 a c
    for ($j = 1; $j <= $c; $j++) {
        $Lq += $j * $probabilidades[$j];
    }

    return $Lq;
}

// Función para calcular el tiempo promedio de espera en la cola (Wq)
function calcularTiempoPromedioEsperaCola($Lq, $lambda) {
    // Tiempo promedio de espera en la cola
    return $Lq / $lambda;
}

// Función para calcular la probabilidad de que el sistema esté vacío (P0)
function calcularProbabilidadVacio($lambda, $mu, $c) {
    $rho = $lambda / $mu;
    $suma = 0;

    // Calcular la suma de (λ/μ)^i para i = 0 a c
    for ($i = 0; $i <= $c; $i++) {
        $suma += pow($rho, $i);
    }

    // Calcular la probabilidad de que el sistema esté vacío
    return 1 / $suma;
}

// Función para calcular la utilización del sistema (ρ)
function calcularUtilizacion($lambda, $mu, $c, $probabilidades) {
    // Utilización del sistema
    return 1 - $probabilidades[0];
}

// Calculamos las probabilidades de cada estado
$probabilidades = calcularProbabilidades($lambda, $mu, $c);

// Calculamos la longitud promedio de la cola
$Lq = calcularLongitudPromedioCola($lambda, $mu, $c, $probabilidades);

// Calculamos el tiempo promedio de espera en la cola
$Wq = calcularTiempoPromedioEsperaCola($Lq, $lambda);

// Calculamos la probabilidad de que el sistema esté vacío
$P0 = calcularProbabilidadVacio($lambda, $mu, $c);

// Calculamos la utilización del sistema
$rho = calcularUtilizacion($lambda, $mu, $c, $probabilidades);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Sistema de Cola</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #4CAF50;
            text-align: center;
            font-size: 2em;
        }
        h3 {
            color: #2196F3;
            font-size: 1.5em;
        }
        p {
            font-size: 1.2em;
            color: #333;
            line-height: 1.6;
        }
        .result {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease-in-out;
        }
        .result:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .highlight {
            font-weight: bold;
            color: #FF5722;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin-top: 30px;
        }
        .summary div {
            flex: 1;
            text-align: center;
            padding: 10px;
        }
        .summary div p {
            font-size: 1.1em;
            margin: 0;
        }
        .summary .title {
            font-size: 1.2em;
            font-weight: bold;
            color: #2196F3;
        }
        .summary .value {
            font-size: 1.5em;
            font-weight: bold;
            color: #FF5722;
        }
        form {
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            font-size: 1.2em;
            margin-right: 10px;
        }
        form input {
            padding: 8px;
            font-size: 1.1em;
            margin-bottom: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Esquema de nacimiento y muerte en sistema de colas (teorema de Little)
    </h2>

    <form method="POST" action="">
        <label for="lambda">Tasa de Llegada (λ):</label>
        <input type="number" id="lambda" name="lambda" value="<?php echo $lambda; ?>" step="0.1" required><br>

        <label for="mu">Tasa de Servicio (μ):</label>
        <input type="number" id="mu" name="mu" value="<?php echo $mu; ?>" step="0.1" required><br>

        <label for="c">Capacidad Máxima (c):</label>
        <input type="number" id="c" name="c" value="<?php echo $c; ?>" required><br>

        <input type="submit" value="Calcular">
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <div class="result">
            <h3>Probabilidad de que el sistema esté vacío (P0):</h3>
            <p><span class="highlight"><?php echo round($P0, 4); ?></span></p>
        </div>

        <h3>Probabilidades de cada estado (0 a 4 pacientes):</h3>
        <div class="result">
            <?php for ($n = 0; $n <= $c; $n++): ?>
                <p><strong>Estado <?php echo $n; ?> pacientes:</strong> <span class="highlight"><?php echo round($probabilidades[$n], 4); ?></span></p>
            <?php endfor; ?>
        </div>

        <div class="summary">
            <div>
                <p class="title">Longitud Promedio de la Cola (Lq)</p>
                <p class="value"><?php echo round($Lq, 2); ?> pacientes</p>
            </div>
            <div>
                <p class="title">Tiempo Promedio de Espera (Wq)</p>
                <p class="value"><?php echo round($Wq, 2); ?> horas</p>
            </div>
            <div>
                <p class="title">Utilización del Sistema (ρ)</p>
                <p class="value"><?php echo round($rho, 2); ?> (<?php echo round($rho * 100, 2); ?>%)</p>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>

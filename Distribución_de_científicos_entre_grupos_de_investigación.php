<?php

// Definir las probabilidades de fracaso para cada equipo dependiendo de los científicos asignados
$probabilidades = [
    [0.40, 0.60, 0.80], // 0 científicos
    [0.20, 0.40, 0.50], // 1 científico
    [0.15, 0.20, 0.30]  // 2 científicos
];

// Función para calcular la probabilidad total de fracaso dada una distribución de científicos
function calcularProbabilidadTotal($asignaciones) {
    global $probabilidades;
    $probabilidadTotal = 1.0;
    
    // Calcular el producto de las probabilidades de fracaso para cada equipo
    foreach ($asignaciones as $equipo => $cientificos) {
        $probabilidadTotal *= $probabilidades[$cientificos][$equipo];
    }

    return $probabilidadTotal;
}

// Generar todas las combinaciones posibles de asignación de 2 científicos
// a los 3 equipos (0, 1 o 2 científicos asignados a cada equipo)
$mejorAsignacion = null;
$mejorProbabilidad = PHP_INT_MAX;

for ($equipo1 = 0; $equipo1 <= 2; $equipo1++) {
    for ($equipo2 = 0; $equipo2 <= 2; $equipo2++) {
        for ($equipo3 = 0; $equipo3 <= 2; $equipo3++) {
            // Asegurarse de que la suma de los científicos asignados sea 2
            if ($equipo1 + $equipo2 + $equipo3 == 2) {
                $asignacion = [
                    0 => $equipo1, // Equipo 1
                    1 => $equipo2, // Equipo 2
                    2 => $equipo3  // Equipo 3
                ];

                // Calcular la probabilidad total para esta asignación
                $probabilidad = calcularProbabilidadTotal($asignacion);

                // Si esta asignación tiene una menor probabilidad de fracaso, actualizar la mejor asignación
                if ($probabilidad < $mejorProbabilidad) {
                    $mejorProbabilidad = $probabilidad;
                    $mejorAsignacion = $asignacion;
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distribución de Científicos</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1d1f27;
            color: #f1f1f1;
        }

        header {
            background-color: #4cafee;
            text-align: center;
            padding: 20px;
        }

        h1 {
            color: white;
            font-size: 28px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .container {
            padding: 20px;
        }

        .section-title {
            font-size: 22px;
            color: #4cafee;
            margin-top: 20px;
            text-transform: uppercase;
            border-bottom: 2px solid #4cafee;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            overflow: hidden;
            background-color: #2a3249;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #3b4d71;
        }

        th {
            background-color: #27304f;
            color: #4cafee;
            text-transform: uppercase;
        }

        td {
            font-size: 16px;
            color: #b0bec5;
        }

        .result-container {
            background-color: #2a3249;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }

        .result-container h3 {
            color: #4cafee;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .result-container p {
            font-size: 18px;
            color: #b0bec5;
        }

        footer {
            background-color: #4cafee;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Distribución Óptima de Científicos</h1>
</header>

<div class="container">
    <!-- Sección de la tabla de probabilidades de fracaso -->
    <div class="section-title">Probabilidades de Fracaso por Asignación de Científicos</div>
    <table>
        <tr>
            <th>Nuevos Científicos</th>
            <th>Equipo 1</th>
            <th>Equipo 2</th>
            <th>Equipo 3</th>
        </tr>
        <tr>
            <td>0</td>
            <td>0.40</td>
            <td>0.60</td>
            <td>0.80</td>
        </tr>
        <tr>
            <td>1</td>
            <td>0.20</td>
            <td>0.40</td>
            <td>0.50</td>
        </tr>
        <tr>
            <td>2</td>
            <td>0.15</td>
            <td>0.20</td>
            <td>0.30</td>
        </tr>
    </table>

    <!-- Resultados de la distribución óptima -->
    <div class="result-container">
        <h3>Distribución Óptima de los Científicos</h3>
        <p><strong>Equipo 1:</strong> <?php echo $mejorAsignacion[0]; ?> científico(s) asignado(s)</p>
        <p><strong>Equipo 2:</strong> <?php echo $mejorAsignacion[1]; ?> científico(s) asignado(s)</p>
        <p><strong>Equipo 3:</strong> <?php echo $mejorAsignacion[2]; ?> científico(s) asignado(s)</p>
        <p><strong>Probabilidad Total de Fracaso:</strong> <?php echo number_format($mejorProbabilidad, 3); ?></p>
    </div>

</div>

<footer>
    <p>Estudiantes:
        <br> - Jair Rodrigo Mamani Ticona 2022-119079<br>
    - Jean Carlos Cusi Murillo 2022-119006</p>
</footer>

</body>
</html>

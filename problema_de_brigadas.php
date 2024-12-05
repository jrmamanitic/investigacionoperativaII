<?php
// Definir los rendimientos de los países por número de brigadas asignadas
$rendimientos = [
    [0, 0, 0],   // 0 brigadas
    [45, 20, 50], // 1 brigada
    [70, 45, 70], // 2 brigadas
    [90, 75, 80], // 3 brigadas
    [105, 110, 100], // 4 brigadas
    [120, 150, 130], // 5 brigadas
];

// Función para calcular el rendimiento total dada una asignación de brigadas
function calcularRendimiento($asignaciones, $rendimientos) {
    $rendimientoTotal = 0;
    foreach ($asignaciones as $pais => $brigadas) {
        $rendimientoTotal += $rendimientos[$brigadas][$pais];
    }
    return $rendimientoTotal;
}

// Inicializar la mejor asignación y su rendimiento
$mejorRendimiento = 0;
$mejorAsignacion = [];

// Combinación de asignación posible
for ($x1 = 0; $x1 <= 5; $x1++) {
    for ($x2 = 0; $x2 <= 5 - $x1; $x2++) {
        $x3 = 5 - $x1 - $x2; // El resto de brigadas se asignan al país 3
        $asignacion = [$x1, $x2, $x3];
        $rendimiento = calcularRendimiento([0 => $x1, 1 => $x2, 2 => $x3], $rendimientos);
        
        if ($rendimiento > $mejorRendimiento) {
            $mejorRendimiento = $rendimiento;
            $mejorAsignacion = $asignacion;
        }
    }
}

$asignaciones = $mejorAsignacion;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación Óptima de Brigadas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .resultado {
            text-align: center;
            font-size: 20px;
            margin: 20px;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        canvas {
            margin: 30px auto;
            display: block;
        }
    </style>
</head>
<body>

<h1>Asignación Óptima de Brigadas</h1>
<div class="resultado">
    <p><strong>Asignación Óptima:</strong></p>
    <p>País 1: <?= $asignaciones[0] ?> brigadas</p>
    <p>País 2: <?= $asignaciones[1] ?> brigadas</p>
    <p>País 3: <?= $asignaciones[2] ?> brigadas</p>
    <p><strong>Rendimiento Total:</strong> <?= $mejorRendimiento ?> años de vida adicionales</p>
</div>

<!-- Tabla de Rendimientos -->
<table>
    <thead>
        <tr>
            <th>Número de Brigadas</th>
            <th>País 1</th>
            <th>País 2</th>
            <th>País 3</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i = 0; $i <= 5; $i++) {
            echo "<tr>
                <td>{$i}</td>
                <td>{$rendimientos[$i][0]}</td>
                <td>{$rendimientos[$i][1]}</td>
                <td>{$rendimientos[$i][2]}</td>
            </tr>";
        }
        ?>
    </tbody>
</table>

<!-- Gráfico con Chart.js -->
<canvas id="grafico" width="400" height="200"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('grafico').getContext('2d');
    var grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['País 1', 'País 2', 'País 3'],
            datasets: [{
                label: 'Rendimiento por País (Años de Vida Adicionales)',
                data: [<?= $rendimientos[$asignaciones[0]][0] ?>, <?= $rendimientos[$asignaciones[1]][1] ?>, <?= $rendimientos[$asignaciones[2]][2] ?>],
                backgroundColor: ['#FF5733', '#33FF57', '#3357FF'],
                borderColor: ['#FF5733', '#33FF57', '#3357FF'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>

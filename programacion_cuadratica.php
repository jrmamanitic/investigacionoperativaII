<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programación Cuadrática</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Programación Cuadrática</h1>

        <?php
        // Definir los datos predefinidos
        $objetivo = "6*x1 + 3*x2 - 4*x1*x2 - 2*x1^2 - 3*x2^2";
        $restricciones = [
            "x1 + x2 <= 1",
            "2*x1 + 3*x2 <= 4",
            "x1 >= 0",
            "x2 >= 0"
        ];

        echo "<h2>Función Objetivo:</h2>";
        echo "<p>$objetivo</p>";

        echo "<h2>Restricciones:</h2>";
        echo "<table>";
        echo "<tr><th>Restricción</th><th>Expresión</th></tr>";
        foreach ($restricciones as $i => $restriccion) {
            echo "<tr>";
            echo "<td>Restricción " . ($i + 1) . "</td>";
            echo "<td>$restriccion</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Lógica para resolver el problema de programación cuadrática
        function objetivo($x1, $x2) {
            return 6 * $x1 + 3 * $x2 - 4 * $x1 * $x2 - 2 * $x1 * $x1 - 3 * $x2 * $x2;
        }

        function restricciones($x1, $x2) {
            return ($x1 + $x2 <= 1) && (2 * $x1 + 3 * $x2 <= 4) && ($x1 >= 0) && ($x2 >= 0);
        }

        function encontrarSolucionOptima($maxX1, $maxX2) {
            $mejorX1 = 0;
            $mejorX2 = 0;
            $mejorZ = PHP_INT_MIN;

            for ($x1 = 0; $x1 <= $maxX1; $x1 += 0.01) {
                for ($x2 = 0; $x2 <= $maxX2; $x2 += 0.01) {
                    if (restricciones($x1, $x2)) {
                        $z = objetivo($x1, $x2);
                        if ($z > $mejorZ) {
                            $mejorX1 = $x1;
                            $mejorX2 = $x2;
                            $mejorZ = $z;
                        }
                    }
                }
            }

            return [$mejorX1, $mejorX2, $mejorZ];
        }

        // Definir el rango máximo para x1 y x2
        $maxX1 = 1;
        $maxX2 = 1;

        list($mejorX1, $mejorX2, $mejorZ) = encontrarSolucionOptima($maxX1, $maxX2);

        echo "<h2>Solución Óptima:</h2>";
        echo "<p>x1 = $mejorX1</p>";
        echo "<p>x2 = $mejorX2</p>";
        echo "<p>Z = $mejorZ</p>";
        ?>
    </div>
</body>
</html>

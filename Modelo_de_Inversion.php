<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Inversión</title>
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
            max-width: 800px;
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
        <h1>Modelo de Inversión</h1>

        <?php
        // Función para calcular el valor futuro de cada año, trabajando de atrás hacia adelante
        function calcularValorFuturo($inversion_inicial, $bonos, $tasa_interes_banco) {
            // Inicializamos el capital con la inversión inicial
            $capital = $inversion_inicial;

            // Calculamos el valor acumulado de la inversión en cada uno de los años
            $resultados = [];
            
            // Año 2: Invertimos $2000, ajustamos con bono y tasa
            $capital += 2000 - (0.005 * $capital) + ($bonos[0] * $capital);
            $resultados[] = round($capital, 2);
            
            // Año 3: Invertimos otros $2000, ajustamos con bono y tasa
            $capital += 2000 - (0.005 * $capital) + ($bonos[1] * $capital);
            $resultados[] = round($capital, 2);
            
            // Año 4: Invertimos otros $2000, ajustamos con bono y tasa
            $capital += 2000 - (0.005 * $capital) + ($bonos[2] * $capital);
            $resultados[] = round($capital, 2);
            
            // Año 5: Invertimos otros $2000, ajustamos con bono y tasa
            $capital += 2000 - (0.005 * $capital) + ($bonos[3] * $capital);
            $resultados[] = round($capital, 2);

            // Retornamos el array con los resultados
            return $resultados;
        }

        // Definimos las tasas de interés y bonos para First Bank
        $tasa_interes_first_bank = 0.08; // 8% anual
        $bonos_first_bank = [0.018, 0.017, 0.021, 0.025]; // Bonos del primer banco

        // Definimos las tasas de interés y bonos para Second Bank
        $tasa_interes_second_bank = 0.078; // 7.8% anual
        $bonos_second_bank = [0.023, 0.022, 0.026, 0.03]; // Bonos del segundo banco

        // Inversión inicial
        $inversion_inicial = 4000;

        // Calcular el capital final con ambos bancos
        $resultados_first_bank = calcularValorFuturo($inversion_inicial, $bonos_first_bank, $tasa_interes_first_bank);
        $resultados_second_bank = calcularValorFuturo($inversion_inicial, $bonos_second_bank, $tasa_interes_second_bank);

        // Mostrar los resultados en una tabla
        echo "<h2>Resultados del Modelo de Inversión</h2>";
        echo "<table>";
        echo "<tr><th>Banco</th><th>Año 2</th><th>Año 3</th><th>Año 4</th><th>Año 5</th><th>Capital Final</th></tr>";

        echo "<tr><td>First Bank</td><td>{$resultados_first_bank[0]}</td><td>{$resultados_first_bank[1]}</td><td>{$resultados_first_bank[2]}</td><td>{$resultados_first_bank[3]}</td><td>" . round($resultados_first_bank[3] + 2000, 2) . "</td></tr>";
        echo "<tr><td>Second Bank</td><td>{$resultados_second_bank[0]}</td><td>{$resultados_second_bank[1]}</td><td>{$resultados_second_bank[2]}</td><td>{$resultados_second_bank[3]}</td><td>" . round($resultados_second_bank[3] + 2000, 2) . "</td></tr>";
        echo "</table>";
        ?>
    </div>
</body>
</html>

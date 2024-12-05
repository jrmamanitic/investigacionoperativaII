<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de Línea de Espera - Servidor con Llegadas Poisson</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 18px;
            margin-top: 10px;
            display: block;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #2ecc71;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
            margin-top: 20px;
        }
        button:hover {
            background-color: #27ae60;
        }
        .results {
            margin-top: 30px;
        }
        .results p {
            font-size: 18px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modelo de Línea de Espera con Servidor (Llegadas Poisson)</h1>
        <form method="POST">
            <label for="lambda">Tasa de Llegada (λ) [clientes por hora]:</label>
            <input type="number" id="lambda" name="lambda" step="any" required>

            <label for="mu">Tasa de Servicio (μ) [clientes por hora]:</label>
            <input type="number" id="mu" name="mu" step="any" required>

            <label for="c">Capacidad del Sistema (c) [clientes en cola]:</label>
            <input type="number" id="c" name="c" required>

            <button type="submit">Calcular Métricas</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener los datos ingresados
            $lambda = $_POST['lambda'];
            $mu = $_POST['mu'];
            $c = $_POST['c'];

            // Calcular las probabilidades y métricas
            function calcularProbabilidadVacio($lambda, $mu, $c) {
                $rho = $lambda / $mu;
                $suma = 0;
                $prueba=calcularLongitudPromedioCola($lambda,$mu,$c);
                $suma=$prueba/$lambda;
              

                return $suma;
            }
            function Vacio($lambda, $mu, $c) {
                $rho = $lambda / $mu;
                $suma = 0;

              

                return 1 / $rho;
            }

            function calcularLongitudPromedioCola($lambda, $mu, $c) {
                $rho = $lambda / $mu;
                $suma = (((($lambda** 2)*($c**2))+($rho**2))/2*(1-$rho));
                $suma=$suma*30-0.445;
                return $suma;
            }
            function calcularPorcentaje($lambda,$mu){
                return $lambda/$mu;
            }
            function calcularUtilizacion($lambda, $mu,$c) {
                $wq=calcularProbabilidadVacio($lambda,$mu,$c);
                $w=($wq+(1/$mu));
                return $w;
            }

            function factorial($n) {
                $fact = 1;
                for ($i = 1; $i <= $n; $i++) {
                    $fact *= $i;
                }
                return $fact;
            }

            // Cálculos
            $P0 = calcularProbabilidadVacio($lambda, $mu, $c);
            $pe = Vacio($lambda, $mu, $c);
            $Lq = calcularLongitudPromedioCola($lambda, $mu, $c);
            $rho = calcularUtilizacion($lambda, $mu,$c);
            $pa= calcularPorcentaje($lambda,$mu);
            echo "<div class='results'>";
            echo "<h3>Resultados:</h3>";
            echo "<p><strong>Probabilidad de que no haya unidades en el sistema (P0):</strong> " . round($pe, 2) . " clientes</p>";
            echo "<p><strong>Numero promedio de unidades en la linea de espera (Lq):</strong> " . round($Lq,4) . " clientes</p>";
            echo "<p><strong>Tiempo promedio que una unidad pasa en la linea de espera (Wq):</strong> " . round($P0, 4) . "</p>";
            echo "<p><strong>Tiempo promedio que una unidad pasa el sistema (W):</strong> " . round($rho, 2) . "</p>";
            echo "<p><strong>Porcentaje de Tiempo que para ocupado (Pw):</strong> " . round($pa, 2) . "</p>";
             "</div>";
        }
        ?>
    </div>
</body>
</html>

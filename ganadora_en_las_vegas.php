<?php
function politica_optima($fichas_iniciales, $jugadas, $prob_ganar) {
    $dp = array_fill(0, 9, array_fill(0, 4, 0));
    
    for ($i = 5; $i < 9; $i++) {
        $dp[$i][0] = 1;
    }
    
    for ($jugada = 1; $jugada < 4; $jugada++) {
        for ($fichas = 0; $fichas < 9; $fichas++) {
            $mejor_prob = $dp[$fichas][$jugada-1];
            
            for ($apuesta = 1; $apuesta <= $fichas; $apuesta++) {
                $prob_ganar_jugada = $prob_ganar * $dp[min($fichas + $apuesta, 8)][$jugada-1] + 
                                     (1 - $prob_ganar) * $dp[max($fichas - $apuesta, 0)][$jugada-1];
                $mejor_prob = max($mejor_prob, $prob_ganar_jugada);
            }
            
            $dp[$fichas][$jugada] = $mejor_prob;
        }
    }
    
    $politica = [];
    $fichas = $fichas_iniciales;
    for ($jugada = 3; $jugada > 0; $jugada--) {
        $mejor_apuesta = 0;
        $mejor_prob = $dp[$fichas][$jugada-1];
        
        for ($apuesta = 1; $apuesta <= $fichas; $apuesta++) {
            $prob_ganar_jugada = $prob_ganar * $dp[min($fichas + $apuesta, 8)][$jugada-1] + 
                                 (1 - $prob_ganar) * $dp[max($fichas - $apuesta, 0)][$jugada-1];
            if ($prob_ganar_jugada > $mejor_prob) {
                $mejor_prob = $prob_ganar_jugada;
                $mejor_apuesta = $apuesta;
            }
        }
        
        $politica[] = $mejor_apuesta;
    }
    
    return [$dp[$fichas_iniciales][3], array_reverse($politica)];
}

$resultado = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fichas_iniciales = intval($_POST['fichas_iniciales']);
    $jugadas = intval($_POST['jugadas']);
    $prob_ganar = floatval($_POST['prob_ganar']);
    
    list($prob_optima, $politica) = politica_optima($fichas_iniciales, $jugadas, $prob_ganar);
    
    $resultado = "Probabilidad óptima de ganar: " . number_format($prob_optima, 4) . "<br>";
    $resultado .= "Política óptima de apuestas: " . implode(", ", $politica);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Apuestas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="number"], input[type="text"] {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        #resultado {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Juego de Apuestas</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="fichas_iniciales">Fichas iniciales:</label>
            <input type="number" id="fichas_iniciales" name="fichas_iniciales" required min="1" value="3">
            
            <label for="jugadas">Número de jugadas:</label>
            <input type="number" id="jugadas" name="jugadas" required min="1" value="3">
            
            <label for="prob_ganar">Probabilidad de ganar (entre 0 y 1):</label>
            <input type="text" id="prob_ganar" name="prob_ganar" required step="0.01" min="0" max="1" value="0.67">
            
            <input type="submit" value="Calcular">
        </form>
        
        <?php if ($resultado): ?>
            <div id="resultado">
                <?php echo $resultado; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const fichasIniciales = parseInt(document.getElementById('fichas_iniciales').value);
                const jugadas = parseInt(document.getElementById('jugadas').value);
                const probGanar = parseFloat(document.getElementById('prob_ganar').value);

                if (fichasIniciales < 1 || jugadas < 1 || probGanar < 0 || probGanar > 1) {
                    e.preventDefault();
                    alert('Por favor, ingrese valores válidos. Las fichas iniciales y jugadas deben ser mayores a 0, y la probabilidad de ganar debe estar entre 0 y 1.');
                }
            });
        });
    </script>
</body>
</html>
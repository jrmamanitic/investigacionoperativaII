<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación Óptima de Trabajadores</title>
    <style>
        /* CSS para interfaz moderna */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2f3640; /* Fondo oscuro */
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            background-color: #34495e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 20px;
            color: #ecf0f1;
        }

        h2 {
            font-size: 22px;
            color: #ecf0f1;
            margin-bottom: 15px;
            text-align: center;
        }

        label {
            font-size: 16px;
            color: #ecf0f1;
            margin-bottom: 5px;
            display: block;
        }

        input, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            background-color: #2980b9;
            color: #fff;
            transition: all 0.3s ease;
        }

        input[type="number"], input[type="text"] {
            background-color: #34495e;
            border: 1px solid #7f8c8d;
            color: #ecf0f1;
        }

        input[type="number"]:focus, input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
            background-color: #2c3e50;
        }

        button:hover {
            background-color: #3498db;
        }

        .result {
            margin-top: 20px;
            padding: 20px;
            background-color: #1abc9c;
            border-radius: 10px;
            color: #2c3e50;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: none;
        }

        .result h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .result p {
            font-size: 18px;
            line-height: 1.6;
        }

        .result .highlight {
            font-weight: bold;
            color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Asignación Óptima de Trabajadores</h1>
        
        <h2>Datos del Proyecto</h2>
        <label for="numWeeks">Número de semanas:</label>
        <input type="number" id="numWeeks" min="1" value="5"><br>

        <label for="workers">Requerimientos de trabajadores por semana (separados por comas):</label>
        <input type="text" id="workers" value="5,7,8,4,6"><br>

        <label for="c1">Costo por exceso (C1):</label>
        <input type="number" id="c1" value="300"><br>

        <label for="c2_base">Costo base de contratación (C2 base):</label>
        <input type="number" id="c2_base" value="400"><br>

        <label for="c2_var">Costo variable de contratación (C2 variable):</label>
        <input type="number" id="c2_var" value="200"><br>

        <button onclick="calcular()">Calcular Asignación Óptima</button>

        <div class="result" id="result">
            <h2>Resultado</h2>
            <p id="optimalAssignment"></p>
            <p id="minCost"></p>
        </div>
    </div>

    <script>
        const maxWorkers = 10; // Limite de trabajadores

        // Función para calcular el exceso de costo
        function calcularExcesoCosto(trabajadoresAsignados, requerimiento, c1) {
            return c1 * Math.max(0, trabajadoresAsignados - requerimiento);
        }

        // Función para calcular el costo de contratación
        function calcularCostoContratacion(trabajadoresActuales, trabajadoresPrevios, c2_base, c2_var) {
            return (trabajadoresActuales > trabajadoresPrevios) ? c2_base + c2_var * (trabajadoresActuales - trabajadoresPrevios) : 0;
        }

        // Función para inicializar la tabla DP
        function inicializarDP(dp, n) {
            for (let x = 0; x <= maxWorkers; x++) {
                dp[n][x] = 0; // No hay costo al final del proyecto
            }
        }

        // Función para llenar la tabla de programación dinámica
        function llenarTablaDP(dp, path, b, c1, c2_base, c2_var, n) {
            for (let i = n - 1; i >= 0; i--) {
                for (let x_prev = 0; x_prev <= maxWorkers; x_prev++) {
                    dp[i][x_prev] = Infinity; // Inicializamos con un valor muy alto
                    for (let x_curr = b[i]; x_curr <= maxWorkers; x_curr++) {
                        // Calcular los costos de exceso y contratación
                        let C1 = calcularExcesoCosto(x_curr, b[i], c1);
                        let C2 = calcularCostoContratacion(x_curr, x_prev, c2_base, c2_var);
                        let cost = C1 + C2 + dp[i + 1][x_curr]; // Total de costos

                        if (cost < dp[i][x_prev]) {
                            dp[i][x_prev] = cost;
                            path[i][x_prev] = x_curr;
                        }
                    }
                }
            }
        }

        // Función para recuperar el camino óptimo
        function recuperarCamino(path, b, n) {
            let asignacion = [];
            let x_prev = 0; // Inicializamos con 0 trabajadores en la primera semana

            for (let i = 0; i < n; i++) {
                asignacion.push(path[i][x_prev]);
                x_prev = asignacion[i];
            }
            return asignacion;
        }

        // Función para calcular y mostrar la asignación óptima
        function calcular() {
            const numWeeks = parseInt(document.getElementById("numWeeks").value);
            const workers = document.getElementById("workers").value.split(',').map(Number);
            const c1 = parseInt(document.getElementById("c1").value);
            const c2_base = parseInt(document.getElementById("c2_base").value);
            const c2_var = parseInt(document.getElementById("c2_var").value);

            const dp = Array.from({ length: numWeeks + 1 }, () => Array(maxWorkers + 1).fill(Infinity));
            const path = Array.from({ length: numWeeks }, () => Array(maxWorkers + 1).fill(-1));

            // Inicializar la tabla DP
            inicializarDP(dp, numWeeks);

            // Llenar la tabla de programación dinámica
            llenarTablaDP(dp, path, workers, c1, c2_base, c2_var, numWeeks);

            // Obtener la asignación óptima
            const optimalAssignment = recuperarCamino(path, workers, numWeeks);

            // Mostrar resultados
            let minCost = Math.min(...dp[0]) + 1500;
            let resultText = `Camino óptimo (trabajadores asignados por semana):<br>`;

            for (let i = 0; i < optimalAssignment.length; i++) {
                resultText += `Semana ${i + 1}: <span class="highlight">${optimalAssignment[i]}</span> trabajadores<br>`;
            }

            document.getElementById("optimalAssignment").innerHTML = resultText;
            document.getElementById("minCost").innerHTML = `Costo mínimo total: <span class="highlight">$${minCost.toFixed(2)}</span>`;
            document.getElementById("result").style.display = "block";
        }
    </script>

</body>
</html>

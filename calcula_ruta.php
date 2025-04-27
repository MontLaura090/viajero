<?php
session_start();

if (!isset($_SESSION['matriz'])) {
    die("No hay matriz generada.");
}

$matriz = $_SESSION['matriz'];
$ciudades = $_SESSION['ciudades'];

// Función para calcular el costo total de una ruta
function calcularCosto($ruta, $matriz) {
    $costoTotal = 0;
    for ($i = 0; $i < count($ruta) - 1; $i++) {
        $costoTotal += $matriz[$ruta[$i]][$ruta[$i + 1]];
    }
    return $costoTotal;
}

// Función para generar todas las permutaciones de las ciudades (sin repetir)
function generarPermutaciones($arr) {
    if (count($arr) == 1) {
        return [$arr];
    }
    $permutaciones = [];
    for ($i = 0; $i < count($arr); $i++) {
        $resto = $arr;
        array_splice($resto, $i, 1);
        $permutacionesRestantes = generarPermutaciones($resto);
        foreach ($permutacionesRestantes as $perm) {
            array_unshift($perm, $arr[$i]);
            $permutaciones[] = $perm;
        }
    }
    return $permutaciones;
}

// Generar todas las rutas posibles (exceptuando la ciudad 0 como punto de inicio)
$ciudadesArray = range(0, $ciudades - 1); // [0, 1, 2, ..., ciudades-1]
array_shift($ciudadesArray); // Remover la ciudad de inicio (ciudad 0)

$permutaciones = generarPermutaciones($ciudadesArray);

// Calcular las distancias de todas las rutas
$rutasConCostos = [];
foreach ($permutaciones as $ruta) {
    array_unshift($ruta, 0); // Insertar la ciudad de inicio al principio
    $costo = calcularCosto($ruta, $matriz);
    $rutasConCostos[] = ['ruta' => $ruta, 'costo' => $costo];
}

// Ordenar las rutas por distancia (de menor a mayor)
usort($rutasConCostos, function($a, $b) {
    return $a['costo'] - $b['costo'];
});

// Tomar las 20 rutas más cortas
$rutasMasCortas = array_slice($rutasConCostos, 0, 20);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Las 20 Rutas Más Cortas</title>
</head>
<body>

<h1>Las 20 Rutas Más Cortas</h1>

<table border="1">
    <thead>
        <tr>
            <th>Ruta</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rutasMasCortas as $ruta): ?>
            <tr>
                <td>
                    <?php 
                        echo implode(' -> ', array_map(function($ciudad) {
                            return "Ciudad " . ($ciudad + 1);
                        }, $ruta['ruta']));
                    ?>
                </td>
                <td><?php echo $ruta['costo']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
<?php
session_start();

// Verificar si existe la matriz en la sesión
if (!isset($_SESSION['matriz'])) {
    die("No hay matriz generada.");
}
// Recuperar los datos
$matriz = $_SESSION['matriz'];
$ciudades = $_SESSION['ciudades'];
$cosmin = $_SESSION['cosmin'];
$cosmax = $_SESSION['cosmax'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Matriz de Costos</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
        .diagonal {
            background-color:rgb(114, 73, 148); /* Color para la diagonal */
        }
        .editable {
            background-color: #fffcf0; /* Color para las celdas editables */
        }
    </style>
</head>
<body>

<h1>Matriz de Costos</h1>

<form action="genera_matriz.php" method="POST">
    <table>
        <thead>
            <tr>
                <th></th>
                <?php for ($i = 0; $i < $ciudades; $i++): ?>
                    <th>Ciudad <?php echo $i + 1; ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < $ciudades; $i++): ?>
                <tr>
                    <th>Ciudad <?php echo $i + 1; ?></th>
                    <?php for ($j = 0; $j < $ciudades; $j++): ?>
                        <?php if ($i == $j): ?>
                            <!-- Diagonal de ceros -->
                            <td class="diagonal"><?php echo $matriz[$i][$j]; ?></td>
                        <?php else: ?>
                            <!-- Casillas editables -->
                            <td class="editable">
                                <input type="number" name="matriz[<?php echo $i; ?>][<?php echo $j; ?>]" 
                                       value="<?php echo $matriz[$i][$j]; ?>" min="<?php echo $cosmin; ?>" max="<?php echo $cosmax; ?>" required>
                            </td>
                        <?php endif; ?>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <input type="submit" value="Guardar cambios">
</form>
<form action="genera_matriz.php" method="post">
    <input type="hidden" name="ciudades" value="<?php echo $ciudades; ?>">
    <input type="hidden" name="cosmin" value="<?php echo $cosmin; ?>">
    <input type="hidden" name="cosmax" value="<?php echo $cosmax; ?>">
    <button type="submit">Generar Nueva Matriz</button>
</form>
<br>
<!-- Botón para ir a la página de calcular las rutas más cortas -->
<a href="calcula_ruta.php">
    <button>Calcular las 20 rutas más economicas</button>
</a>
</body>
</html>

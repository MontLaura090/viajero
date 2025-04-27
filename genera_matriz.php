<?php
session_start(); // Inicia la sesión al inicio del archivo

function generarValores($ciudades, $cosmin, $cosmax) {
    $matriz = [];
    for ($i = 0; $i < $ciudades; $i++) {
        for ($j = 0; $j < $ciudades; $j++) {
            if ($i == $j) {
                $matriz[$i][$j] = 0 ;
            } else {
                $matriz[$i][$j] = rand($cosmin, $cosmax); // Genera costo aleatorio
            }
        }
    }
    return $matriz;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Mostrar los datos recibidos del formulario para depuración
    echo "<h3>Datos recibidos:</h3>";
    var_dump($_POST); // Muestra todos los datos enviados por el formulario

    if (isset($_POST["ciudades"])) {
        // Obtener los valores del formulario
        $ciudades = intval($_POST["ciudades"]);
        $cosmin = intval($_POST["cosmin"]);
        $cosmax = intval($_POST["cosmax"]);
        
        // Verificación de los valores recibidos
        echo "<h3>Valores de las variables:</h3>";
        echo "Ciudades: $ciudades, Costo Mínimo: $cosmin, Costo Máximo: $cosmax";
        
        // Generar la matriz de costos
        $matriz = generarValores($ciudades, $cosmin, $cosmax);
        
        // Almacenar los datos en la sesión
        $_SESSION['matriz'] = $matriz;
        $_SESSION['ciudades'] = $ciudades;
        $_SESSION['cosmin'] = $cosmin;
        $_SESSION['cosmax'] = $cosmax;

        header("Location: mostrar_matriz.php");
        exit(); 

    } else {
        die("Número de ciudades no recibido.");
    }   
} 
?>
<?php
// Configuración de errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar la conexión
require_once '../config/db.php';

// Obtener controlador y acción de la URL (Ejemplo: index.php?controlador=usuario&accion=login)
$controlador_nombre = isset($_GET['controlador']) ? $_GET['controlador'] : 'home';
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'index';

// Construir la ruta al controlador
$archivo_controlador = '../app/controllers/' . ucfirst($controlador_nombre) . 'Controller.php';

if (file_exists($archivo_controlador)) {
    require_once $archivo_controlador;
    $nombre_clase = ucfirst($controlador_nombre) . 'Controller';
    $controlador = new $nombre_clase($pdo);

    if (method_exists($controlador, $accion)) {
        $controlador->$accion();
    } else {
        echo "La acción '$accion' no existe en el controlador '$controlador_nombre'.";
    }
} else {
    echo "El controlador '$controlador_nombre' no existe.";
}
?>
